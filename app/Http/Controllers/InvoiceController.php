<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf; 

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Customer;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with('customer')->orderBy('id', 'desc')->paginate(10); // Retrieve 10 invoices per page
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customersList = Customer::get();
        return view('invoices.create', compact('customersList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        Log::info('Received invoice data:', $request->all());
        $rules = array(
            'customer_id' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);

        // // process the login
        if ($validator->fails()) {
            return Redirect::to('invoices/create')
                ->withErrors($validator)
                ->withInput($request->except('password'));
        } else {

            $maxId = Invoice::max('id') ?? 0; // Use 0 if no rows exist

            // Increment to generate a new invoice number
            $newInvoiceNumber = $maxId + 1;

            // store
            $mytime = Carbon::now();
            $invoice1 = new Invoice();
            $invoice1->invoice_no = $newInvoiceNumber;
            $invoice1->invoice_date = $request->get('invoice_date');
            $invoice1->customer_id = $request->get('customer_id');
            $invoice1->terms = $request->get('terms');
            $invoice1->reference = $request->get('reference');
            $invoice1->gross_amt = $request->get('gross_amt');
            $invoice1->vat_amt = $request->get('vat_amt');
            $invoice1->net_amt = $request->get('net_amt');
            $invoice1->created_at = $mytime->toDateTimeString();
            if ($invoice1->save()) {

                $items = $request->get('items') ?? [];
                $items = array_filter($request->get('items') ?? [], function ($item) {
                    return isset($item['particulars']) && trim($item['particulars']) !== '';
                });
                foreach ($items as $itemData) {
                    $item = new InvoiceItem();
                    $item->invoice_id = $invoice1->id;
                    $item->particulars = $itemData['particulars'];
                    $item->qty = $itemData['qty'];
                    $item->rate = $itemData['rate'];
                    $item->amount = $itemData['amount'];
                    $item->vat = $itemData['vat'];
                    $item->vat_perc = $itemData['vat_perc'];
                    $item->net = $itemData['net'];
                    $item->save();
                }

                return response()->json([
                    'status' => 'invoice-created',
                    'invoice_id' => $invoice1->id,
                    'message' => 'Invoice created successfully'
                ], 201);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to create invoice'
                ], 500);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoice = Invoice::with(['customer', 'invoiceItems'])->findOrFail($id);
    
        // Return view with no-cache headers
        return response()
            ->view('invoices.show', compact('invoice'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoice = Invoice::with(['customer', 'invoiceItems'])->findOrFail($id);
        $customersList = Customer::all();
    
        // Return view with no-cache headers
        return response()
            ->view('invoices.edit', compact('invoice', 'customersList'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, int $id)
    {
        Log::info('Updating invoice data:', $request->all());
        $rules = [
            'customer_id' => 'required',
            'invoice_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.particulars' => 'required|string',
            'items.*.qty' => 'required|integer',
            'items.*.rate' => 'required|numeric',
            'items.*.amount' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        try {
            $invoice = Invoice::findOrFail($id);
            $invoice->customer_id = $request->get('customer_id');
            $invoice->invoice_date = $request->get('invoice_date');
            $invoice->terms = $request->get('terms');
            $invoice->reference = $request->get('reference');
            $invoice->gross_amt = $request->get('gross_amt');
            $invoice->vat_amt = $request->get('vat_amt');
            $invoice->net_amt = $request->get('net_amt');
            $invoice->save();
            Log::info($request->get('invoice_date'));
            $existingItems = $invoice->invoiceItems()->pluck('id')->toArray();

            $updatedItemIds = [];

            foreach ($request->get('items') as $itemData) {
                if (isset($itemData['id']) && in_array($itemData['id'], $existingItems)) {
                    $item = InvoiceItem::find($itemData['id']);
                    $item->particulars = $itemData['particulars'];
                    $item->qty = $itemData['qty'];
                    $item->rate = $itemData['rate'];
                    $item->amount = $itemData['amount'];
                    $item->vat_perc = $itemData['vat_perc'];
                    $item->vat = $itemData['vat'];
                    $item->net = $itemData['net'];
                    $item->save();
                    $updatedItemIds[] = $itemData['id'];
                } else {
                    // Create new item
                    $invoice->invoiceItems()->create([
                        'particulars' => $itemData['particulars'],
                        'qty' => $itemData['qty'],
                        'rate' => $itemData['rate'],
                        'amount' => $itemData['amount'],
                        'vat' => $itemData['vat'],
                        'vat_perc' => $itemData['vat_perc'],
                        'net' => $itemData['net'],
                    ]);
                }
            }

            // Delete items that were not included in the update request
            $itemsToDelete = array_diff($existingItems, $updatedItemIds);
            InvoiceItem::destroy($itemsToDelete);

            return response()->json([
                'status' => 'invoice-updated',
                'invoice_id' => $invoice->id,
                'message' => 'Invoice updated successfully'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Failed to update invoice:', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update invoice'
            ], 500);
        }
    }

    public function print($id)
    {
        try {
            $invoice = Invoice::with(['customer', 'invoiceItems'])->findOrFail($id);
            
            // Load the view for the PDF, passing the invoice data
            $pdf = Pdf::loadView('invoices.print', compact('invoice'));
            
            // Download the PDF file with a custom filename
            return $pdf->download('Invoice-' . $invoice->invoice_no . '.pdf');
        } catch (\Exception $e) {
            Log::error('Failed to generate invoice PDF:', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to generate PDF'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}

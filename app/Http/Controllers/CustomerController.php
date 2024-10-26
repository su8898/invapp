<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::orderBy('company_name', 'asc')->paginate(10);
        return view('customers.index', compact('customers'));
    }

    public function open(int $id)
    {
        $customer = Customer::find($id);
        ;
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $rules = array(
            'company_name' => 'required',
            'email' => 'required|email',
        );
        $validator = Validator::make($request->all(), $rules);

        // // process the login
        if ($validator->fails()) {
            return Redirect::to('customers/create')
                ->withErrors($validator)
                ->withInput($request->except('password'));
        } else {
            // store
            $mytime = Carbon::now();
            $customer1 = new Customer();
            $customer1->company_name = $request->get('company_name');
            $customer1->email = $request->get('email');
            $customer1->contact_name = $request->get('contact_name');
            $customer1->contact_no = $request->get('contact_no');
            $customer1->addr_number = $request->get('addr_number');
            $customer1->addr_street = $request->get('addr_street');
            $customer1->addr_city = $request->get('addr_city');
            $customer1->addr_postcode = $request->get('addr_postcode');
            $customer1->vat_no = $request->get('vat_no');
            $customer1->updated_at = $mytime->toDateTimeString();
            // $customer1->save();
            if ($customer1->save()) {
                return redirect()->route('customers.index')->with('status', 'customer-created');
            } else {
                Session::flash('status', 'Successfully updated tank!');
            }

            // redirect
            //Session::flash('message', 'Successfully updated tank!');
            return Redirect::route('customers.create')->with('status', 'customer-created');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        // Find the customer by ID, along with their invoices
        $customer = Customer::with('invoices')->find($id);
    
        // Check if the customer exists
        if (!$customer) {
            return redirect()->route('customers.index')->with('error', 'Customer not found.');
        }
        // dd($customer->invoices); // Debugging line
        // Pass the customer with invoices to the view
        return view('customers.show', compact('customer'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, int $id)
    {
        $rules = array(
            'company_name' => 'required',
            'email' => 'required|email',
        );
        $validator = Validator::make($request->all(), $rules);

        // // process the login
        if ($validator->fails()) {
            return Redirect::to('customers/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput($request->except('password'));
        } else {
            try {
                // store
                $mytime = Carbon::now();
                $customer1 = Customer::find($id);
                $customer1->company_name = $request->get('company_name');
                $customer1->email = $request->get('email');
                $customer1->contact_name = $request->get('contact_name');
                $customer1->contact_no = $request->get('contact_no');
                $customer1->addr_number = $request->get('addr_number');
                $customer1->addr_street = $request->get('addr_street');
                $customer1->addr_city = $request->get('addr_city');
                $customer1->addr_postcode = $request->get('addr_postcode');
                $customer1->vat_no = $request->get('vat_no');
                $customer1->updated_at = $mytime->toDateTimeString();
                if ($customer1->save()) {
                    return redirect()->route('customers.index')->with('status', 'customer-updated');
                } else {
                    Session::flash('status', 'Successfully updated tank!');
                }

            } catch (\Exception $e) {
                Session::flash('status', 'Error!');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }

    public function getCustomerAddress($id)
    {
        // Fetch customer details by ID
        $customer = Customer::find($id);

        // Check if customer exists
        if ($customer) {
            // Return the customer's address details in JSON format
            return response()->json([
                'company_name' => $customer->company_name,
                'addr_number' => $customer->addr_number,
                'addr_street' => $customer->addr_street,
                'addr_city' => $customer->addr_city,
                'addr_postcode' => $customer->addr_postcode,
                'vat_no' => $customer->vat_no,
            ]);
        } else {
            // Return an error if customer is not found
            return response()->json(['error' => 'Customer not found'], 404);
        }
    }

}

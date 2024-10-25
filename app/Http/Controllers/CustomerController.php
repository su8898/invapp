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
        $customers = Customer::paginate();
        return view('customers.index', compact('customers'));
    }

    public function open(int $id)
    {
        $customer = Customer::find($id);;
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
            'company_name'       => 'required',
            'email'      => 'required|email',
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
            $customer1->save();

            // redirect
            //Session::flash('message', 'Successfully updated tank!');
            return Redirect::route('customers.create')->with('status', 'customer-created');
            return Redirect::to('customers');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
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
            'company_name'       => 'required',
            'email'      => 'required|email',
        );
        $validator = Validator::make($request->all(), $rules);

        // // process the login
        if ($validator->fails()) {
            return Redirect::to('customers/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput($request->except('password'));
        } else {
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
            $customer1->save();

            // redirect
            //Session::flash('message', 'Successfully updated tank!');
            return Redirect::route('customers.edit',[$id])->with('status', 'customer-updated');
            return Redirect::to('customers');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}

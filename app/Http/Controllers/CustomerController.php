<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use File;

class CustomerController extends Controller
{
    public function index(Request $request)
    {

        $customers = Customer::when($request->search, function ($q) use ($request) {
            $q->where('first_name', 'like', '%'.$request->search.'%')
                ->orWhere('last_name', 'like', '%'.$request->search.'%')
                ->orWhere('email', 'like', '%'.$request->search.'%')
                ->orWhere('phone', 'like', '%'.$request->search.'%');
        })->get();


        return view('customer.index', compact('customers'));

    }

    public function create()
    {
        return view('customer.create');

    }

    public function store(CustomerStoreRequest $request)
    {
        $customer = new Customer();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = $image->store('', 'public');
            $destinationPath = '/uploads/'.$name;
            $customer->image = $destinationPath;
        }

        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->bank_account_number = $request->bank_account_number;
        $customer->about = $request->about;
        $customer->save();

        return redirect()->route('customers.index');

    }

    public function show(string $id)
    {
        $customer = Customer::findOrFail($id);

        return view('customer.show', compact('customer'));

    }

    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);

        return view('customer.edit', compact('customer'));
    }

    public function update(CustomerStoreRequest $request, $id)
    {
        $customer = Customer::findOrFail($id);
        if ($request->hasFile('image')) {

            // delete old image
            File::delete(public_path($customer->image));

            // handle new image
            $image = $request->file('image');
            $name = $image->store('', 'public');
            $destinationPath = '/uploads/'.$name;
            $customer->image = $destinationPath;
        }

        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->bank_account_number = $request->bank_account_number;
        $customer->about = $request->about;
        $customer->save();

        return redirect()->route('customers.index');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        File::delete(public_path($customer->image));
        $customer->delete();
        return redirect()->route('customers.index');
    }
}

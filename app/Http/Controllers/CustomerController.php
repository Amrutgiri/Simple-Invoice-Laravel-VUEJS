<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function getAllCustomers(Request $request)
	{
        $customers = Customer::orderBy('id', 'DESC')->get();

        return response()->json([
            'customers'=>$customers,
        ], 200);
	}
}

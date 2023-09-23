<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AddressController extends Controller
{
    public function addresses(Request $request)
    {
        try {
            $this->validate($request, [
                'customer_id' => 'required|exists:customers,id',
                'address' => 'required',
                'district' => 'required',
                'city' => 'required',
                'province' => 'required',
                'postal_code' => 'required',
            ]);
    
            $address = new Address();
            $address->customer_id = $request->customer_id;
            $address->address = $request->address;
            $address->district = $request->district;
            $address->city = $request->city;
            $address->province = $request->province;
            $address->postal_code = $request->postal_code;

            $address->save();
    
            return response()->json(['message' => 'Address created successfully'], 201);
        } catch (\Throwable $th) {
            Log::error('Error creating address: ' . $th->getMessage());
    
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'customer_id' => 'required|exists:customers,id',
                'address' => 'required',
                'district' => 'required',
                'city' => 'required',
                'province' => 'required',
                'postal_code' => 'required',
            ]);

            $address = Address::find($id);

            if (!$address) {
                return response()->json(['message' => 'Address not found'], 404);
            }
    
            $address->customer_id = $request->customer_id;
            $address->address = $request->address;
            $address->district = $request->district;
            $address->city = $request->city;
            $address->province = $request->province;
            $address->postal_code = $request->postal_code;

            $address->save();
    
            return response()->json(['message' => 'Address updated successfully'], 201);
        } catch (\Throwable $th) {
            Log::error('Error creating address: ' . $th->getMessage());
    
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public function delete($id)
    {
        try {
            $address = Address::find($id);

            if (!$address) {
                return response()->json(['message' => 'Address no found'], 404);
            }

            $address->delete();

            return response()->json(['message' => 'Address deleted']);
        } catch (\Throwable $th) {
            Log::error('Error deleting address: ' . $th->getMessage());
            return response()->json(['error' => 'Internal server error']);
        }
    }
}

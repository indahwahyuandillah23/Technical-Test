<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'gender' => ['nullable', Rule::in(['M', 'F'])],
            'search' => 'nullable|string',
            'per_page' => 'nullable|integer|min:1',
        ]);

        $gender = request()->input('gender');
        $search = request()->input('search');

        try {
            $query = Customer::orderBy('name', 'asc')
            ->when($gender, function ($q) use ($gender) {
                $q->where('gender', $gender);
            })
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });

            $perPage = request()->input('per_page', 10);
            $customers = $query->paginate($perPage);

            $response = [
                'data' => $customers->items(),
                'pagination' => [
                    'current_page' => $customers->currentPage(),
                    'total' => $customers->total(),
                    'per_page' => $customers->perPage(),
                ],
            ];

            Log::info('Success retrieve customer data', ['page' => $request->input('per_page')]);

            return response()->json($response, 200);
        } catch (\Throwable $e) {
            log::error('Error occurred retrieving customer data', ['exception'=> $e]);
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public function show($id)
    {
        try {
            $customers = Customer::with('addresses')->find($id);

            if (!$customers) {
                return response()->json(['message' => 'Customer not found'], 404);
            }

            return response()->json($customers, 200);
        } catch (\Throwable $th) {
            Log::error('Error fetching customer: ' . $th->getMessage());

            return response()->json(['error' => 'Internal server error'], 500);
        }

    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'title' => 'required',
                'name' => 'required',
                'gender' => 'required|in:M,F',
                'phone_number' => 'required',
                'image' => 'url',
                'email' => 'required|email|unique:customers,email',
            ]);
    
            $customer = new Customer;
            $customer->title = $request->title;
            $customer->name = $request->name;
            $customer->gender = $request->gender;
            $customer->phone_number = $request->phone_number;
            $customer->image = $request->image;
            $customer->email = $request->email;

            $customer->save();
    
            return response()->json(['message' => 'Customer created successfully'], 201);
        } catch (\Throwable $th) {
            Log::error('Error creating customer: ' . $th->getMessage());
    
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'title' => 'required',
                'name' => 'required',
                'gender' => 'required|in:M,F',
                'phone_number' => 'required',
                'image' => 'url',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('customers', 'email')->ignore($request->id),
                ],
            ]);

            $customer = Customer::find($id);

            if (!$customer) {
                return response()->json(['message' => 'Customer not found'], 404);
            }
    
            $customer->title = $request->title;
            $customer->name = $request->name;
            $customer->gender = $request->gender;
            $customer->phone_number = $request->phone_number;
            $customer->image = $request->image;
            $customer->email = $request->email;

            $customer->save();
    
            return response()->json(['message' => 'Customer updated successfully'], 201);
        } catch (\Throwable $th) {
            Log::error('Error creating customer: ' . $th->getMessage());
    
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public function delete($id)
    {
        try {
            $customer = Customer::find($id);

            if (!$customer) {
                return response()->json(['message' => 'Customer no found'], 404);
            }

            $customer->delete();

            return response()->json(['message' => 'Customer deleted']);
        } catch (\Throwable $th) {
            Log::error('Error deleting customer: ' . $th->getMessage());
            return response()->json(['error' => 'Internal server error']);
        }
    }
}

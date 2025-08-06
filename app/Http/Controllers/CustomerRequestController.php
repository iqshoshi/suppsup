<?php

namespace App\Http\Controllers;

use App\Models\CustomerRequest;
use Illuminate\Http\Request;

class CustomerRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $requests = CustomerRequest::orderBy('created_at', 'desc')->get();
        return view('customer_requests.index', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('customer_requests.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku_code' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'product_description' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'customer_name' => 'required|string|max:255',
            'contact_no' => 'required|string|max:255',
            'associate' => 'required|string|max:255',
            'status' => 'required|in:requested,ordered,arrived,called_for_pickup,fulfilled,customer_cancelled',
            'notes' => 'nullable|string',
        ]);

        // Add default value for vendor since it's not in the form
        $validated['vendor'] = 'TBD'; // or null, or get from another table later

        CustomerRequest::create($validated);
        
        return redirect()->route('customer-requests.index')->with('success', 'Customer request added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerRequest $customerRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit($id)
    {
        $request = CustomerRequest::findOrFail($id);
        return view('customer_requests.edit', compact('request'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $requestData, $id)
    {
        // Find the existing request by id
        $customerRequest = CustomerRequest::findOrFail($id);

        // Define the allowed status values matching your updated enum
        $allowedStatuses = [
            'requested',
            'ordered_from_vendor',
            'ready_for_pickup',
            'called_to_pickup',
            'completed',
            'cancelled',
            'item_on_backorder',
            'item_discontinued',
            'called_item_in_bo',
            'called_item_dcd',
        ];

        // If this is a quick status-only update (usually from a small form or ajax)
        if ($requestData->has('status') && count($requestData->all()) <= 3) {
            $status = $requestData->input('status');

            // Validate that status is one of allowed statuses
            if (!in_array($status, $allowedStatuses)) {
                return redirect()->back()->withErrors(['status' => 'Invalid status selected']);
            }

            // Set the status
            $customerRequest->status = $status;

            // Handle called_to_pickup_at timestamp logic:
            if ($status === 'called_to_pickup' && $customerRequest->status !== 'called_to_pickup') {
                $customerRequest->called_to_pickup_at = now();
            } elseif ($status !== 'called_to_pickup') {
                $customerRequest->called_to_pickup_at = null;
            }

            $customerRequest->save();

        } else {
            // Full form update with validation
            $validated = $requestData->validate([
                'sku_code' => 'required|string|max:255',
                'vendor' => 'required|string|max:255',
                'brand' => 'required|string|max:255',
                'product_description' => 'required|string',
                'quantity' => 'required|integer|min:1',
                'customer_name' => 'nullable|string|max:255',
                'contact_no' => 'nullable|string|max:255',
                'associate' => 'nullable|string|max:255',
                'status' => 'required|in:' . implode(',', $allowedStatuses),
                'notes' => 'nullable|string',
            ]);

            // Handle called_to_pickup_at timestamp logic in full update as well
            if ($validated['status'] === 'called_to_pickup' && $customerRequest->status !== 'called_to_pickup') {
                $validated['called_to_pickup_at'] = now();
            } elseif ($validated['status'] !== 'called_to_pickup') {
                $validated['called_to_pickup_at'] = null;
            }

            $customerRequest->update($validated);
        }

        return redirect()->route('customer-requests.index')->with('success', 'Request updated successfully.');
    }






    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerRequest $customerRequest)
    {
        try {
            $customerRequest->delete();
            
            return redirect()->route('customer-requests.index')
                ->with('success', 'Customer request deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('customer-requests.index')
                ->with('error', 'Failed to delete customer request. Please try again.');
        }
    }
}

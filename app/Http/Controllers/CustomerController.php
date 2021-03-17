<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $customers = Customer::all();
            return CustomerResource::collection($customers);
        } catch(\Exception $ex) {
            Log::error('message: ' . $ex->getMessage());
            return response(['error' => $ex->getMessage()]);
        }
    }

    /**
     * Search of a specif customer
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function find(Request $request) {
        $term = $request->term;
        try {
            $customers = Customer::when($term, function ($query, $term) {
                $query->where('nom', 'ilike', $term . '%' )
                      ->orWhere('phone', 'ilike', $term . '%')
                      ->orderBy('name');
            })->get();

            return CustomerResource::collection($customers);
        } catch(Exception $ex) {
            // #TODO catch error
        }

        return CustomerResource::collection([]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:200',
            'phone' => 'max:50',
        ]);

        if($validator->fails()) {
            // #TODO, being more specific
            return response(['error' => 'Error in sened data']);
        }
        $validated = $validator->validated();

        try {
            $customer = Customer::create($validated);
            return new CustomerResource($customer);

        } catch(\Exception $ex) {
            Log::error('message: ' . $ex->getMessage());
            return response(['error' => $ex->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $customer = Customer::find($id);
            return new CustomerResource($customer);
        } catch(\Exception $ex) {
            Log::error('message: ' . $ex->getMessage());
            return response(['error' => $ex->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'max:200',
            'phone' => 'max:50',
        ]);

        if($validator->fails()) {
            // #TODO, being more specific
            return response(['error' => 'Error in sened data']);
        }
        $validated = $validator->validated();

        try {
            $updated = Customer::where('id', $id)->update($validated);
            if($updated) {
                return response(['status' => 'sucess']);
            }
        } catch(\Exception $ex) {
            Log::error('message: ' . $ex->getMessage());
            return response(['error' => $ex->getMessage()]);
        }

        return response(['status' => 'error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // #TODO adding softdeleting logic
    }
}

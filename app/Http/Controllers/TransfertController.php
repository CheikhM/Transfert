<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransfertResource;
use App\Models\Transfert;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TransfertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transferts = Transfert::all();
        return TransfertResource::collection($transferts);
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
            'amount' => 'required',
            'price' => 'required',
            'customer_id' => 'required',
            'currency' => 'required',
            'sender' => '',
            'receiver' => ''
        ]);

        if($validator->fails()) {
            // #TODO, being more specific
            return response(['error' => 'Error in sened data']);
        }

        $data = $validator->validated();

        // Check if customer  exists
        if(!CustomerService::isExistant($data['customer_id'])) {
            return response(['error' => 'User does\'nt exists']);
        }

        try {
            $transfert = Transfert::create($validator->validated());
            return new TransfertResource($transfert);
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
        $transfert = Transfert::where('id', $id)->first();
        if($transfert) {
            return new TransfertResource($transfert);
        } else {
            return response(['data' => NULL]);
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
        $data = $request->all();

        try {
            $updated = Transfert::where('id', $id)->update($data);
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
       // Todo soft deleting..
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransfertResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'price' => $this->price,
            'customer' => new CustomerResource($this->customer),
            'currency' => new CurrencyResource($this->currency),
            'sender' => new UserResource($this->sender),
            'receiver' => new UserResource($this->receiver),

        ];
    }
}

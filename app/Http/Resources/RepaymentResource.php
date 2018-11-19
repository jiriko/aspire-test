<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RepaymentResource extends JsonResource
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
            'loan' => new LoanResource($this->whenLoaded('loan')),
            'loan_id' => $this->user_id,
            'amount' => $this->amount,
            'paid_at' => $this->paid_at,
        ];
    }
}

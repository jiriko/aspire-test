<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
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
            'user' => new UserResource($this->whenLoaded('user')),
            'user_id' => $this->user_id,
            'repayment_frequency' => $this->repayment_frequency,
            'interest_rate' => $this->interest_rate,
            'arrangement_fee' => $this->arrangement_fee,
            'duration' => $this->duration,
            'amount' => $this->amount,
            'approved_at' => $this->paid_at,
        ];
    }
}

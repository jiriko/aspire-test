<?php

namespace App\Models;


use Carbon\Carbon;

class Repayment extends BaseModel
{
    protected $casts = [
      'due_at' => 'date:Y-m-d'
    ];


    public function pay()
    {
        $this->update([
            'paid_at' => Carbon::now()
        ]);
    }
}

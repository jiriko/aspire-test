<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RepaymentResource;
use App\Models\Repayment;

class RepaymentPaymentController extends Controller
{
    public function __invoke(Repayment $repayment)
    {
        if($repayment->paid_at) {
            //good case for a policy but no authentication in place yet
            abort(403);
        }

        $repayment->pay();

        return new RepaymentResource($repayment);
    }
}

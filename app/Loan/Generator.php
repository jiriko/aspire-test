<?php

namespace App\Loan;

use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Generator
{
    public static function create($request)
    {
        return (new static($request))->handle($request);
    }

    public function handle($request)
    {
        DB::beginTransaction();

        $loan = $this->createLoan($request);

        $this->generateRepayments($loan);

        DB::commit();

        return $loan;
    }

    /**
     * @param $request
     * @return \App\Models\Loan $loan
     */
    protected function createLoan($request)
    {
        return Loan::create([
            'user_id' => $request['user_id'],
            'duration' => $request['duration'],
            'repayment_frequency' => $request['repayment_frequency'],
            'interest_rate' => $request['interest_rate'],
            'arrangement_fee' => $request['arrangement_fee'],
            'amount' => $request['amount'],
            'approved_at' => $request['approved_at'] ?? Carbon::now(),
        ]);
    }

    protected function generateRepayments(Loan $loan) : void
    {
        for ($i = $loan->periods(); $i <= $loan->duration; $i += $loan->periods()) {
            $loan->repayments()->create([
                'amount' => $loan->amountToPayPerPeriod(),
                'due_at' => Carbon::parse($loan->approved_at)->addMonths($i),
            ]);
        }
    }
}
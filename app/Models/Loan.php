<?php

namespace App\Models;


class Loan extends BaseModel
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function repayments()
    {
        return $this->hasMany(Repayment::class);
    }

    /**
     * @return float|int
     */
    public function amountToPayPerPeriod()
    {
        return ($this->amount + $this->loanInterest()) / $this->duration;
    }

    /**
     * @return float|int
     */
    public function loanInterest()
    {
        return $this->amount * $this->interest_rate / 100;
    }

    /**
     * @return float|int
     */
    public function periods()
    {
        return $this->duration / $this->repayment_frequency;
    }
}

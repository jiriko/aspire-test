<?php

namespace Tests\Unit\Loan;

use App\Loan\Generator;
use App\Models\Loan;
use App\Models\Repayment;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GeneratorTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();

        $this->user = create(User::class);
    }

    /** @test */
    public function it_creates_a_loan()
    {
        Generator::create($this->getData());

        tap(Loan::first(), function ($loan) {
            $this->assertEquals($this->user->id, $loan->user_id);
            $this->assertEquals(12, $loan->duration);
            $this->assertEquals(12, $loan->repayment_frequency);
            $this->assertEquals(2, $loan->interest_rate);
            $this->assertEquals(2000, $loan->arrangement_fee);
            $this->assertEquals(50000, $loan->amount);
        });
    }

    /** @test */
    public function it_generates_correct_repayment_amount()
    {
        Generator::create($this->getData());

        tap(Repayment::first(), function ($repayment) {
            //50000 + 1000 / 12 = 4250;
            $this->assertEquals(4250, $repayment->amount);
        });
    }

    /** @test */
    public function it_generates_correct_number_of_repayments()
    {
        Generator::create($this->getData());

        $this->assertEquals(12, Loan::first()->repayments()->count());
    }

     /** @test */
     public function it_generates_correct_repayment_date()
     {
         Generator::create($this->getData(['approved_at' => '2018-11-19']));

         tap(Repayment::first(), function ($repayment) {
             $this->assertEquals('2018-12-19', $repayment->due_at->format('Y-m-d'));
         });

         tap(Repayment::find(12), function ($repayment) {
             $this->assertEquals('2019-11-19', $repayment->due_at->format('Y-m-d'));
         });
     }

    protected function getData($overrides = [])
    {
        return array_merge([
            'user_id' => $this->user->id,
            'duration' => 12,
            'repayment_frequency' => 12,
            'interest_rate' => 2,
            'arrangement_fee' => 2000,
            'amount' => 50000,
        ], $overrides);
    }
}

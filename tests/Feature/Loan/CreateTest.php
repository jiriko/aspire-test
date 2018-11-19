<?php

namespace Tests\Feature\Loan;

use App\Models\Loan;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();

        $this->user = create(User::class);
    }

    /** @test */
    public function a_loan_can_be_created_for_a_user()
    {
        $this->post('/api/loans', $this->validParams())
            ->assertStatus(201)
            ->assertJson([
                    'data' =>
                        [
                            'id' => 1,
                            'user_id' => $this->user->id,
                            'repayment_frequency' => 12,
                            'interest_rate' => 2,
                            'arrangement_fee' => 2000,
                            'duration' => 12,
                            'amount' => 50000,
                        ],
                ]
            );

        $this->assertEquals(12, Loan::first()->repayments()->count());
    }

    /** @test */
    public function user_id_is_required()
    {
        $this->withExceptionHandling();
        $this->post('/api/loans', $this->validParams(['user_id' => null]))
            ->assertSessionHasErrors('user_id');
    }

    /** @test */
    public function duration_is_required()
    {
        $this->withExceptionHandling();
        $this->post('/api/loans', $this->validParams(['duration' => null]))
            ->assertSessionHasErrors('duration');
    }

    /** @test */
    public function duration_is_numeric()
    {
        $this->withExceptionHandling();
        $this->post('/api/loans', $this->validParams(['duration' => 'abc']))
            ->assertSessionHasErrors('duration');
    }

    public function amount_is_required()
    {
        $this->withExceptionHandling();
        $this->post('/api/loans', $this->validParams(['amount' => null]))
            ->assertSessionHasErrors('amount');
    }

    /** @test */
    public function amount_is_numeric()
    {
        $this->withExceptionHandling();
        $this->post('/api/loans', $this->validParams(['amount' => 'abc']))
            ->assertSessionHasErrors('amount');
    }

    /** @test */
    public function repayment_frequency_is_required()
    {
        $this->withExceptionHandling();
        $this->post('/api/loans', $this->validParams(['repayment_frequency' => null]))
            ->assertSessionHasErrors('repayment_frequency');
    }

    /** @test */
    public function repayment_frequency_is_numeric()
    {
        $this->withExceptionHandling();
        $this->post('/api/loans', $this->validParams(['repayment_frequency' => 'abc']))
            ->assertSessionHasErrors('repayment_frequency');
    }

    /** @test */
    public function interest_rate_is_required()
    {
        $this->withExceptionHandling();
        $this->post('/api/loans', $this->validParams(['interest_rate' => null]))
            ->assertSessionHasErrors('interest_rate');
    }

    /** @test */
    public function interest_rate_is_numeric()
    {
        $this->withExceptionHandling();
        $this->post('/api/loans', $this->validParams(['interest_rate' => 'abc']))
            ->assertSessionHasErrors('interest_rate');
    }

    /** @test */
    public function arrangement_fee_is_required()
    {
        $this->withExceptionHandling();
        $this->post('/api/loans', $this->validParams(['arrangement_fee' => null]))
            ->assertSessionHasErrors('arrangement_fee');
    }

    /** @test */
    public function arrangement_fee_is_numeric()
    {
        $this->withExceptionHandling();
        $this->post('/api/loans', $this->validParams(['arrangement_fee' => 'abc']))
            ->assertSessionHasErrors('arrangement_fee');
    }

    protected function validParams($overrides = [])
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

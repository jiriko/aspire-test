<?php

namespace Tests\Feature\Loan;

use App\Models\Loan;
use App\Models\Repayment;
use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PayTest extends TestCase
{
    use RefreshDatabase;

     /** @test */
     public function a_repayment_can_be_paid()
     {
        $repayment = create(Repayment::class, ['paid_at' => null]);

        $this->assertNull($repayment->paid_at);

        $this->post(route('repayments.pay', $repayment->id))
            ->assertStatus(200);

        $this->assertEquals(Carbon::now(), $repayment->refresh()->paid_at);
     }

      /** @test */
      public function can_not_pay_already_paid_repayments()
      {
          $this->withExceptionHandling();

          $repayment = create(Repayment::class, ['paid_at' => Carbon::now()]);

          $this->post(route('repayments.pay', $repayment->id))
            ->assertStatus(403);
      }
}

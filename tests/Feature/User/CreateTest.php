<?php

namespace Tests\Feature\User;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_be_created()
    {
        $this->post('/api/users', $this->validParams())
            ->assertStatus(201)
            ->assertJson([
                    'data' =>
                        [
                            'id' => 1,
                            'name' => 'John Doe',
                            'email' => 'john@example.com',
                        ],
                ]
            );
    }

    /** @test */
    public function email_is_required()
    {
        $this->withExceptionHandling();

        $this->post('/api/users', $this->validParams(['email' => null]))
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function email_is_unique()
    {
        $this->withExceptionHandling();
        create(User::class, ['email' => 'john@example.com']);

        $this->post('/api/users', $this->validParams(['email' => 'john@example.com']))
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function name_is_required()
    {
        $this->withExceptionHandling();

        $this->post('/api/users', $this->validParams(['name' => null]))
            ->assertSessionHasErrors('name');
    }

    protected function validParams($overrides = [])
    {
        return array_merge([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'foobar245',
            'password_confirmation' => 'foobar245',
        ], $overrides);
    }
}

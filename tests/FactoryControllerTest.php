<?php

declare(strict_types=1);

namespace Vural\E2ERoutes\Tests;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FactoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_can_create_a_model_with_request() : void
    {
        $response = $this->postJson('e2e/user')
            ->assertStatus(201)
            ->assertJsonStructure(['id', 'name', 'email', 'created_at', 'updated_at']);

        /** @var User $user */
        $user = $response->getOriginalContent();
        $this->assertNotNull(User::first());
        $this->assertTrue(User::first()->is($user));
    }

    /** @test */
    function it_can_override_attributes() : void
    {
        $this->postJson('e2e/user', [
            'attributes' => ['name' => 'John'],
        ])
            ->assertStatus(201)
            ->assertJsonStructure(['id', 'name', 'email', 'created_at', 'updated_at']);

        /** @var User $john */
        $john = User::first();
        $this->assertNotNull(User::first());
        $this->assertTrue(User::first()->is($john));
        $this->assertSame('John', $john->name);
    }

    /** @test */
    function it_can_create_given_amount_of_models() : void
    {
        $response = $this->postJson('e2e/user', ['times' => 5])
            ->assertStatus(201)
            ->assertJsonStructure([['id', 'name', 'email', 'created_at', 'updated_at']]);

        /** @var Collection<User> $users */
        $users = $response->getOriginalContent();
        $this->assertCount(5, User::all());
        $this->assertEmpty($users->diff(User::all()));
    }

    /** @test */
    function it_will_return_404_request_model_does_not_exists() : void
    {
        $this->postJson('e2e/notExistingModel')->assertNotFound();
    }

    /** @test */
    function it_will_return_404_if_requested_model_does_not_have_factory()
    {
        $this->postJson('e2e/account')->assertNotFound();
    }

    /** @test */
    function it_can_create_model_with_state()
    {
        $response = $this->postJson('e2e/user', ['states' => ['withFooName']])->assertStatus(201);

        /** @var User $model */
        $model = $response->getOriginalContent();

        $this->assertSame('foo', $model->name);
    }

    /** @test */
    function it_will_return_404_if_state_is_not_found()
    {
        $this->postJson('e2e/user', ['states' => ['notExistingState']])->assertNotFound();
    }
}

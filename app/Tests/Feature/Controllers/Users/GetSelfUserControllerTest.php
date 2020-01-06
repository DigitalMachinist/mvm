<?php

namespace App\Tests\Feature\Controllers\Rooms;

use Domain\Projects\Project;
use Domain\Rooms\Room;
use Domain\Users\User;
use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Support\Tests\TestCase;

class GetSelfUserControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeReturnsTheAuthenticatedUser(): void
    {
        $user = factory(User::class)
            ->create([
                'email' => 'butthead@mtv.net',
                'name'  => 'Butthead',
            ]);

        $response = $this
            ->actingAs($user, 'api')
            ->getJson("/api/user");

        $response->assertStatus(200);

        $response->assertSeeText($user->email);
        $response->assertSeeText($user->name);
    }

    function testInvokeErrors401WhenNotLoggedIn()
    {
        $response = $this->getJson("/api/user");

        $response->assertStatus(401);
    }
}

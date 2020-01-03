<?php

namespace Domain\Users\Tests;

use Domain\Projects\Project;
use Domain\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Support\Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    function testProjectsRelationship(): void
    {
        $user = factory(User::class)->create();

        $projects = factory(Project::class, 3)
            ->create([
                'user_id' => $user->id,
            ]);

        $this
            ->assertEqualsCanonicalizing(
                $projects->pluck('id'),
                $user->projects()->get()->pluck('id')
            );
    }
}

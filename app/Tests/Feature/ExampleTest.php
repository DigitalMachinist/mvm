<?php

namespace App\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Support\Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    function testBasicTest(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RouteTests extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_auth_routes()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MainpageTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_mainpage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSeeText('Login');
        // $response->assertSeeText('Register');
    }

    /** @test */
    public function test_open_login_page()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);

        $response->assertSeeText('Login');
        $response->assertSeeText('Email Address');
        $response->assertSeeText('Password');
    }
}

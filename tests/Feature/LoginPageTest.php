<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginPageTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_login()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $this->assertAuthenticated();

        $response->assertRedirect('/home');
    }
/*
    public function test_user_fail_login()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password1'
        ]);
        $this->assertEquals(302, $response->getStatusCode());
        $response->assertRedirect('/login');
    }
*/
    public function test_user_can_not_access_dashboard()
    {
        $response = $this->get('/home');

        $response->assertRedirect('/login');
    }

    public function test_user_can_not_access_modal()
    {
        $response = $this->get('/modal');

        $response->assertRedirect('/login');
    }

    public function test_user_can_not_access_penjualan()
    {
        $response = $this->get('/penjualan');

        $response->assertRedirect('/login');
    }

    public function test_user_can_not_access_misc()
    {
        $response = $this->get('/misc');

        $response->assertRedirect('/login');
    }

    public function test_user_can_not_access_users()
    {
        $response = $this->get('/users');

        $response->assertRedirect('/login');
    }

    public function test_user_can_not_access_stocks()
    {
        $response = $this->get('/stocks');

        $response->assertRedirect('/login');
    }

    public function test_user_can_not_access_stocks_adjustment()
    {
        $response = $this->get('/stocks/adjustment');

        $response->assertRedirect('/login');
    }

    public function test_user_can_not_access_stocks_habis()
    {
        $response = $this->get('/stocks/habis');

        $response->assertRedirect('/login');
    }

    public function test_user_can_not_access_items()
    {
        $response = $this->get('/items');

        $response->assertRedirect('/login');
    }

    public function test_user_can_not_access_reports()
    {
        $response = $this->get('/reports');

        $response->assertRedirect('/login');
    }

    public function test_user_can_not_access_resetpassword()
    {
        $response = $this->get('/resetpassword');

        $response->assertRedirect('/login');
    }
    
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ModalTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function setUp() : void
    {
        parent::setUp();

        $this->setBaseRoute('modal');
        $this->setBaseModel('App\Models\Inventory');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_create_modal()
    {       
        $this->signIn();

        $response = $this->get('/modal');
        $response->assertStatus(200);
        $response->assertSeeText('Modal');
        $response->assertSeeText('Tambah Modal');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_unauthenticated_user_can_not_create_modal()
    {
        $response = $this->get('/modal');
        $response->assertRedirect('/login');
    }

}

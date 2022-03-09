<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp() : void
    {
        parent::setUp();

        $this->setBaseRoute('items');
        $this->setBaseModel('App\Models\Item');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_create_item()
    {
        $this->signIn();
        $attributes = [
            'item_code' => $this->faker->regexify('[A-Z]{1}[0-4]{3}'),
            'item_name' => $this->faker->name(),
            'bal_kg' => $this->faker->randomFloat(1, 0.5, 10),
        ];

        $response = $this->create($attributes);
    }

    public function test_unauthenticated_user_can_not_create_item()
    {
        $attributes = [
            'item_code' => $this->faker->regexify('[A-Z]{1}[0-4]{3}'),
            'item_name' => $this->faker->name(),
            'bal_kg' => $this->faker->randomFloat(1, 0.5, 10),
        ];

        $response = $this->failCreate($attributes);

        $response->assertRedirect('/login');
    }

    public function test_user_update_item()
    {
        $this->signIn();
        $attributes = [
            'item_code' => $this->faker->regexify('[A-Z]{1}[0-4]{3}'),
            'item_name' => $this->faker->name(),
            'bal_kg' => $this->faker->randomFloat(1, 0.5, 10),
        ];

        $response = $this->update($attributes);
    }
}

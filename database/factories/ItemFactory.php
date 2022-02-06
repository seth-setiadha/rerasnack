<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $bal_kg = $this->faker->randomFloat(1, 0.5, 10);

        return [
            'item_code' => $this->faker->regexify('[A-Z]{1}[0-4]{3}'),
            'item_name' => $this->faker->name(),
            'item_description' => $this->faker->text(),
            'item_image' => $this->faker->name(),
            'user_id' => User::inRandomOrder()->first()->id,
            'bal_kg' => $bal_kg,
            'bal_gr' => intval($bal_kg * 1000),
            'active' => "Y"
        ];
    }
}

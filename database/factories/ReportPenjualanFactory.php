<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReportPenjualanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'item_id' => $this->faker->name(),
            'tanggal'   => $this->faker->date(),
            'item_code' => $this->faker->name(),
            'item_name' => $this->faker->date(),
            'unit'      => $this->faker->date(),
            'unit_price'=> $this->faker->date(),
            'qty'       => $this->faker->date(),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MiscFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $qty = $this->faker->randomDigitNotNull();
        $unit_price = $this->faker->randomNumber(4, true);
        return [
            'tanggal' => $this->faker->date('2022-02-d'),
            'misc_name' => $this->faker->name(),
            'qty' => $qty,
            'unit_price' => $unit_price,
            'sub_total' => ($qty * $unit_price)
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $quantity = $this->faker->numberBetween(0,1000);

        return [
            'name' => $this->faker->unique()->word,
            'description' => $this->faker->sentence,
            'quantity' => $quantity,
            'status' => $quantity > 0 ? 'available' : 'out of stock',
            'image' => $this->faker->image(),
        ];
    }
}

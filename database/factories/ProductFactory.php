<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // Image test
        static $image = "/uploads/product/image_test_400_x_400.png";

        return [
            "name" => fake()->name(),
            "description" => fake()->text(),
            "price" => fake()->numberBetween(100, 1000),
            "is_sales" => fake()->randomElement([0, 1, 2]),
            "image" => $image ?? $image = fake()->image(),
            "is_delete" => fake()->randomElement([0, 1]),
            'created_at' => fake()->dateTimeThisDecade(),
            'updated_at' => fake()->dateTimeThisDecade(),
        ];
    }
}

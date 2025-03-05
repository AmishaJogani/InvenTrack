<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
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
    public function definition(): array
    {
        return [
          'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
            'name' => $this->faker->unique()->words(3, true),
            'price' => $this->faker->randomFloat(2, 100, 5000),
            'description' => $this->faker->sentence(),
            'unit' => $this->faker->numberBetween(1, 100),
            'low_stock_alert' => $this->faker->numberBetween(0, 10),
        ];
    }
}

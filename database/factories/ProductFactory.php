<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'slug' => $this->faker->unique()->slug,
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(10000, 500000),
            'old_price' => null,
            'stock' => $this->faker->numberBetween(0, 20),
            'thumbnail' => null,
            'sku' => $this->faker->bothify('SKU-###'),
            'weight' => 500,
            'kategori_id' => null,
            'subcategory_id' => null,
            'subsubcategory_id' => null,
            'brand_id' => null,
            'is_active' => true,
            'is_new' => false,
            'is_best_seller' => false,
        ];
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    /**
     * Test index a new product.
     *
     * @return void
     */
    public function testIndex()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/products');

        $response->assertStatus(200);
        $response->assertViewIs('pages.products.index');
        $response->assertViewHas('data', Product::all());
    }

    /**
     * Test storing a new product.
     *
     * @return void
     */
    public function testStore()
    {
        $user = User::factory()->create();
        $productData = [
            'name' => $this->faker->word,
            'type' => $this->faker->randomElement(['Atasan', 'Bawahan', 'Jaket', 'Sepatu']),
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(250000, 2250000),
            'quantity' => $this->faker->numberBetween(300, 1000),
        ];

        $response = $this->actingAs($user)->post('/products', $productData);

        $response->assertStatus(302);
        $response->assertRedirect('/products');
        $this->assertDatabaseHas('products', $productData);
    }

    /**
     * Test updating an existing product.
     *
     * @return void
     */
    public function testUpdate()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'name' => $this->faker->word,
            'type' => $this->faker->randomElement(['Atasan', 'Bawahan', 'Jaket', 'Sepatu']),
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(250000, 2250000),
            'quantity' => $this->faker->numberBetween(300, 1000),
        ]);

        $updatedData = [
            'name' => $this->faker->word,
            'type' => $this->faker->randomElement(['Atasan', 'Bawahan', 'Jaket', 'Sepatu']),
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(250000, 2250000),
            'quantity' => $this->faker->numberBetween(300, 1000),
        ];

        $response = $this->actingAs($user)->put('/products/' . $product->id, $updatedData);

        $response->assertStatus(302);
        $response->assertRedirect('/products');
        $this->assertDatabaseHas('products', $updatedData);
    }

    /**
     * Test deleting a product.
     *
     * @return void
     */
    public function testDestroy()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'name' => $this->faker->word,
            'type' => $this->faker->randomElement(['Atasan', 'Bawahan', 'Jaket', 'Sepatu']),
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(250000, 2250000),
            'quantity' => $this->faker->numberBetween(300, 1000),
        ]);

        $response = $this->actingAs($user)->delete('/products/' . $product->id);

        $response->assertStatus(302);
        $response->assertRedirect('/products');
        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }
}

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
     * Test case for the create method of ProductController.
     *
     * @return void
     */
    public function testCreate()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/products/create');

        $response->assertStatus(200);
        $response->assertViewIs('pages.products.create');
    }

    /**
     * Test storing a new product.
     *
     * @return void
     */
    public function testStore()
    {
        $productData = [
            'name' => $this->faker->word,
            'type' => $this->faker->randomElement(['Atasan', 'Bawahan', 'Jaket', 'Sepatu']),
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(250000, 2250000),
            'quantity' => $this->faker->numberBetween(300, 1000),
        ];

        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/products', $productData);

        $response->assertStatus(302);
        $response->assertRedirect('/products');
        $this->assertDatabaseHas('products', $productData);
    }

    /**
     * Test case for the edit method of ProductController.
     *
     * @return void
     */
    public function testEdit()
    {
        $product = Product::factory()->create([
            'name' => $this->faker->word,
            'type' => $this->faker->randomElement(['Atasan', 'Bawahan', 'Jaket', 'Sepatu']),
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(250000, 2250000),
            'quantity' => $this->faker->numberBetween(300, 1000),
        ]);

        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/products/' . $product->id . '/edit');


        $response->assertStatus(200);
        $response->assertViewIs('pages.products.edit');
        $response->assertViewHas('item');
    }

    /**
     * Test updating an existing product.
     *
     * @return void
     */
    public function testUpdate()
    {
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

        $user = User::factory()->create();
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
        $product = Product::factory()->create([
            'name' => $this->faker->word,
            'type' => $this->faker->randomElement(['Atasan', 'Bawahan', 'Jaket', 'Sepatu']),
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(250000, 2250000),
            'quantity' => $this->faker->numberBetween(300, 1000),
        ]);

        $user = User::factory()->create();
        $response = $this->actingAs($user)->delete('/products/' . $product->id);

        $response->assertStatus(302);
        $response->assertRedirect('/products');
        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }

    /**
     * Test case for the gallery method of ProductController.
     *
     * @return void
     */
    public function testGallery()
    {
        $product = Product::factory()->create([
            'name' => $this->faker->word,
            'type' => $this->faker->randomElement(['Atasan', 'Bawahan', 'Jaket', 'Sepatu']),
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(250000, 2250000),
            'quantity' => $this->faker->numberBetween(300, 1000),
        ]);

        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/products/' . $product->id . '/gallery');

        $response->assertStatus(200);
        $response->assertViewIs('pages.products.gallery');
        $response->assertViewHas('product');
        $response->assertViewHas('data');
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    protected $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = [
            'name' => $this->faker->word,
            'type' => $this->faker->randomElement(['Atasan', 'Bawahan', 'Jaket', 'Sepatu']),
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(250000, 2250000),
            'quantity' => $this->faker->numberBetween(300, 1000),
        ];

        $this->product['slug'] = Str::slug($this->product['name']);
    }

    /**
     * Test index a new product.
     *
     * @return void
     */
    public function test_product_get_all_page()
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
    public function test_product_create_page()
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
    public function test_product_store()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/products', $this->product);

        $response->assertStatus(302);
        $response->assertRedirect('/products');
        $response->assertSessionHas('suc', __('message.success.create'));
        $this->assertDatabaseHas('products', $this->product);
    }

    /**
     * Test case for the edit method of ProductController.
     *
     * @return void
     */
    public function test_product_edit_page()
    {
        $product = Product::factory()->create($this->product);

        $user = User::factory()->create();
        $response = $this->actingAs($user)->get("/products/{$product->id}/edit");
        $response->assertStatus(200);
        $response->assertViewIs('pages.products.edit');
        $response->assertViewHas('item');
    }
    /**
     * Test updating an existing product.
     *
     * @return void
     */
    public function test_product_update()
    {
        $product = Product::factory()->create($this->product);

        $updatedData = $this->product;

        $user = User::factory()->create();
        $response = $this->actingAs($user)->put("/products/{$product->id}", $updatedData);
        $response->assertStatus(302);
        $response->assertRedirect('/products');
        $response->assertSessionHas('suc', __('message.success.update'));
        $this->assertDatabaseHas('products', $updatedData);
        $this->assertDatabaseMissing('products', $product->toArray());
    }

    /**
     * Test deleting a product.
     *
     * @return void
     */
    public function test_product_delete()
    {
        $product = Product::factory()->create($this->product);

        $user = User::factory()->create();
        $response = $this->actingAs($user)->delete("/products/{$product->id}");

        $response->assertStatus(302);
        $response->assertRedirect('/products');
        $response->assertSessionHas('suc', __('message.success.delete'));
        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }

    /**
     * Test case for the gallery method of ProductController.
     *
     * @return void
     */
    public function test_product_gallery_page()
    {
        $product = Product::factory()->create($this->product);
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get("/products/{$product->id}/galleries");
        $response->assertStatus(200);
        $response->assertViewIs('pages.products.gallery');
        $response->assertViewHas('data');
    }
}

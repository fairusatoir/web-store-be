<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiProductTest extends TestCase
{

    use WithFaker;

    /**
     * Test get products.
     *
     * @return void
     */
    public function test_product_get_all()
    {
        DB::transaction(function () {
            $user = User::factory()->create();
            $response = $this->actingAs($user)
                ->withHeaders([
                    'X-touchpoint-request' => 'testing',
                ])
                ->get('/api/products');

            $response->assertStatus(200);

            $response->assertJsonStructure([
                'data' => [
                    'data',
                    'total',
                    'links',
                ],
            ]);

            $response->assertJson([
                'meta' => [
                    'message' => 'Data Produk Berhasil diambil!',
                    'status_code' => 200,
                    'status' => 'success',
                ],
            ]);
        });
    }

    /**
     * Test get product by id.
     *
     * @return void
     */
    public function test_product_get_by_slug()
    {
        DB::transaction(function () {
            $user = User::factory()->create();
            try {
                $product = Product::findOrFail('1');
            } catch (ModelNotFoundException $e) {
                $product = Product::create([
                    'name' => $this->faker->word,
                    'type' => $this->faker->randomElement(['Atasan', 'Bawahan', 'Jaket', 'Sepatu']),
                    'description' => $this->faker->sentence,
                    'price' => $this->faker->numberBetween(250000, 2250000),
                    'quantity' => $this->faker->numberBetween(300, 1000),
                ]);
            }
            $response = $this->actingAs($user)
                ->withHeaders([
                    'X-touchpoint-request' => 'testing',
                ])
                ->get("/api/products/{$product->slug}");

            $response->assertStatus(200);

            $response->assertJsonStructure([
                'data',
                'meta'
            ]);

            $response->assertJson([
                'meta' => [
                    'message' => "Data {$product->slug} Berhasil diambil!",
                    'status_code' => 200,
                    'status' => 'success',
                ],
            ]);

            $response->assertJsonFragment([
                'name' => $product->name,
                'type' => $product->type,
                'price' => $product->price,
                'quantity' => $product->quantity,
            ]);
        });
    }
}

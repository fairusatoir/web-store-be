<?php

namespace Database\Seeders;

use App\Models\Product;
use Exception;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();
            $limit = 5;
            for ($i = 0; $i < $limit; $i++) {
                $name = Faker::create()->word;
                Product::create([
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'type' => Faker::create()->randomElement(['Atasan', 'Bawahan', 'Jaket', 'Sepatu']),
                    'description' => Faker::create()->sentence,
                    'price' => Faker::create()->randomFloat(2, 10, 100),
                    'quantity' => Faker::create()->numberBetween(1, 100),
                ]);
            }
            DB::commit();
            echo "\t" . $limit . " Product has been created\n";
        } catch (Exception $e) {
            echo "\tProduct has error " . $e->getMessage() . "\n";
        }
        // @phpstan-ignore-next-line

    }
}

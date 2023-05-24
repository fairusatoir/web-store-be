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
                Product::create([
                    'name' => Faker::create()->word,
                    'type' => Faker::create()->randomElement(['Atasan', 'Bawahan', 'Jaket', 'Sepatu']),
                    'description' => Faker::create()->sentence,
                    'price' => Faker::create()->numberBetween(250000, 2250000),
                    'quantity' => Faker::create()->numberBetween(300, 1000),
                ]);
            }
            DB::commit();
            echo "\t" . $limit . " Product has been created\n";
        } catch (Exception $e) {
            DB::rollBack();
            echo "\tProduct has error " . $e->getMessage() . "\n";
        }
    }
}

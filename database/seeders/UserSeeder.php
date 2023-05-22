<?php

namespace Database\Seeders;

use App\Models\User;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();
            User::create([
                'name' => "Super Admin",
                'email' => "superadmin@email.com",
                'password' => Hash::make('passwordaman123'),
            ]);
            DB::commit();
            echo "\tSuper Admin has been created\n";
        } catch (Exception $e) {
            DB::rollBack();
            echo "\tTransaction has error " . $e->getMessage() . "\n";
        }
    }
}

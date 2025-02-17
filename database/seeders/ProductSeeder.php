<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'Product 1',
                'code' => $this->generateProductCode(),
                'price' => 100.00,
                'description' => 'Default description for Product 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Product 2',
                'code' => $this->generateProductCode(),
                'price' => 150.50,
                'description' => 'Default description for Product 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Product 3',
                'code' => $this->generateProductCode(),
                'price' => 200.00,
                'description' => 'Default description for Product 3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Product 4',
                'code' => $this->generateProductCode(),
                'price' => 250.75,
                'description' => 'Default description for Product 4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Product 5',
                'code' => $this->generateProductCode(),
                'price' => 300.99,
                'description' => 'Default description for Product 5',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    private function generateProductCode()
    {
        return 'PRD-' . strtoupper(Str::random(8));
    }
}

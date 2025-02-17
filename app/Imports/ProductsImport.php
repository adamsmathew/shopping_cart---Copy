<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        dd('ytu');
        return new Product([
            'name' => $row['name'],
            'description' => $row['description'],
            'price' => $row['price'],
            'images' => null, // Set images to null
        ]);
    }
}
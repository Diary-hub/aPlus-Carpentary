<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Led 12x2 inch',
            'quantity' => 11,
            'color' => 'Red',
            'dinar_price' => 2500,
            'dolar_price' => 1.5,
            'dolar_data' => 147000,
            'category_id' => 3,
            'company_id' => 2,
            'description' => 'Magna proident sit consectetur velit duis ipsum aute laboris cupidatat amet reprehenderit mollit. Voluptate amet quis esse enim sunt ea. Ullamco quis elit nostrud commodo incididunt eiusmod ad. Labore cupidatat veniam non sit aliquip officia Lorem ex aliqua esse nostrud velit. Sint esse cillum mollit Lorem elit labore. Fugiat dolore qui et nostrud pariatur incididunt eiusmod aute ullamco ut.',

        ]);

        Product::create([
            'name' => 'Srew Wood',
            'quantity' => 2,
            'color' => 'Black',
            'dinar_price' => 750,
            'dolar_price' => 0.55,
            'dolar_data' => 155000,
            'category_id' => 2,
            'company_id' => 3,
            'description' => 'Magna proident sit consectetur velit duis ipsum aute laboris cupidatat amet reprehenderit mollit. Voluptate amet quis esse enim sunt ea. Ullamco quis elit nostrud commodo incididunt eiusmod ad. Labore cupidatat veniam non sit aliquip officia Lorem ex aliqua esse nostrud velit. Sint esse cillum mollit Lorem elit labore. Fugiat dolore qui et nostrud pariatur incididunt eiusmod aute ullamco ut.',

        ]);
    }
}

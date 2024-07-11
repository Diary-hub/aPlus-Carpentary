<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'name' => 'DocXy',

        ]);

        Company::create([
            'name' => 'Ingico',

        ]);

        Company::create([
            'name' => 'Walmart',

        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ["Brand1", "Karra", "98551616161"], ["Brand2", "Kamaldada", "986565656"]
        ];
        foreach ($data as $datasus) {
            $brand = new Brand();
            $brand->name = $datasus[0];
            $brand->address = $datasus[1];
            $brand->phone_no = $datasus[2];
            $brand->save();
        }
    }
}

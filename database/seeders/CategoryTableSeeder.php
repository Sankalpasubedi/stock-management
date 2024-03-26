<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ["Category1"],
            ["Category2"]
        ];

        foreach ($data as $datum) {
            $category = new Category();
            $category->name = $datum[0];
            $category->save();
        }
    }
}

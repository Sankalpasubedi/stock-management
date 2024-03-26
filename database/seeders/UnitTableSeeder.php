<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ["Unit1"], ["Unit2"]
        ];
        foreach ($data as $datasus) {
            $Unit = new Unit();
            $Unit->name = $datasus[0];
            $Unit->save();
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ["Vendor1", "Karra", "98551616161"], ["Vendor2", "Kamaldada", "986565656"]
        ];
        foreach ($data as $datasus) {
            $Vendor = new Vendor();
            $Vendor->name = $datasus[0];
            $Vendor->address = $datasus[1];
            $Vendor->phone_no = $datasus[2];
            $Vendor->save();
        }
    }
}

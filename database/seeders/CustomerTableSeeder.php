<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ["Customer1", "Karra", "98551616161"], ["Customer2", "Kamaldada", "986565656"]
        ];
        foreach ($data as $datasus) {
            $customer = new Customer();
            $customer->name = $datasus[0];
            $customer->address = $datasus[1];
            $customer->phone_no = $datasus[2];
            $customer->save();
        }
    }
}

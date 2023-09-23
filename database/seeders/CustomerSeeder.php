<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Factory::factoryForModel(\App\Models\Customer::class)->count(10)->create()->each(function ($customer){
            Factory::factoryForModel(\App\Models\Address::class)->create(['customer_id' => $customer->id]);
        });
    }
}

<?php

namespace Database\Seeders;

use App\Models\Medidores;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedidoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Medidores::factory()->count(100)->create();
    }
}
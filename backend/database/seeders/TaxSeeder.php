<?php

namespace Database\Seeders;

use Database\Seeders\Tax\IIBBTaxSeeder;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(IIBBTaxSeeder::class);
    }
}

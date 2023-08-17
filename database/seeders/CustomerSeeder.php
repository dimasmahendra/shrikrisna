<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = DB::table("customer")->count();
        if ($count == 0) {
            Customer::factory(100)->create();
        }
    }
}

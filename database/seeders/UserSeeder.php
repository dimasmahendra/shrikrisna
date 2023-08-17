<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = DB::table("users")->count();
        if ($count == 0) {
            DB::table('users')->insert([
                'id' => 1,
                'id_role' => 1,
                'name' => "Administrator",
                'email' => 'admin@example.com',
                'password' => Hash::make('Admin!23'),
                'photo' => "no-image.svg",
                'is_reset' => 0,
                'verify_at' => Carbon::now(),
                'status' => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
        }
    }
}

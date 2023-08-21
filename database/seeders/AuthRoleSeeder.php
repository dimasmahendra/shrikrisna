<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AuthRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = DB::table("auth_role")->count();
        if ($count == 0) {
            
            $data = [
                [
                    'id' => 1,
                    'role_name' => "Super Admin",
                    'read_only' => 1,
                    'status' => "active",
                    'created_at' => date("Y-m-d H:i:s")
                ],
                [
                    'id' => 2,
                    'role_name' => "Staff",
                    'read_only' => 1,
                    'status' => "active",
                    'created_at' => date("Y-m-d H:i:s")
                ],
            ];

            DB::table('auth_role')->insert($data);
            DB::statement("SELECT setval(pg_get_serial_sequence('auth_role', 'id'), coalesce(max(id)+1, 1), false) FROM auth_role;");
        }
    }
}

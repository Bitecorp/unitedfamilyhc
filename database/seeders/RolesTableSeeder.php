<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $roles = [
            [
                'name_role' => 'ADMIN'
            ],
            [
                'name_role' => 'WORKER'
            ],
            [
                'name_role' => 'MANAGER'
            ],
            [
                'name_role' => 'PATIENTE'
            ],
        ];

        foreach ($roles as $value) {
            DB::table('roles')->insert([
                'name_role' => $value['name_role'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

    }
}
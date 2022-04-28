<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaritalStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $maritalStatus = [
            [
                'name_marital_status' => 'MARIED'
            ],
        ];

        foreach ($maritalStatus as $value) {
            DB::table('marital_status')->insert([
                'name_marital_status' => $value['name_marital_status'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

    }
}

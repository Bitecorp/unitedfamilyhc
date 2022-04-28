<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $status = [
            [
                'name_status' => 'ACTIVE'
            ],
            [
                'name_status' => 'INACTIVE'
            ],
        ];

        foreach ($status as $value) {
            DB::table('status')->insert([
                'name_status' => $value['name_status'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

    }
}

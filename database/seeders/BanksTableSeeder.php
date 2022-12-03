<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $banks = [
            [
                'name_bank' => 'CITY BANK'
            ],
        ];

        foreach ($banks as $value) {
            DB::table('banks')->insert([
                'name_bank' => $value['name_bank'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

    }
}
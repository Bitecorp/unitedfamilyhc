<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TitleJobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $titles = [
            [
                'title_job' => 'Home Health Aide'
            ],
        ];

        foreach ($titles as $value) {
            DB::table('title_jobs')->insert([
                'name_job' => $value['title_job'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

    }
}

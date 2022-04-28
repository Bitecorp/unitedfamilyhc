<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(WorkersTableSeeder::class);
        $this->call(StatusTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(MaritalStatusesTableSeeder::class);
        $this->call(TitleJobsTableSeeder::class);
        $this->call(TypeDocsTableSeeder::class);
    }
}

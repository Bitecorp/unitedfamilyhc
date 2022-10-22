<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Worker;
use Illuminate\Database\Seeder;

class WorkersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()APP_DEBUG is set to true while APP_ENV is not local

    This could make your application vulnerable to remote execution. Read more about Ignition security.
    {
        $users = [
            [
                'first_name' => 'user',
                'last_name' => 'develop',
                'home_phone' => '0000000000',
                'email' => 'admin@gmail.com',
                'password' => '$$Adm1nW1nnts3rv3r$$',
                'statu_id' => '1',
                'role_id' => '1'
            ],
            [
                'first_name' => 'Admi United',
                'last_name' => 'Family HC',
                'home_phone' => '0963300777',
                'email' => 'administrator@unitedfamilyhc.com',
                'password' => '$$Adm1nW1nnts3rv3r$$',
                'statu_id' => '1',
                'role_id' => '1'
            ],
            [
                'first_name' => 'Manager United',
                'last_name' => 'Family HC',
                'home_phone' => '0963300725',
                'email' => 'manager@unitedfamilyhc.com',
                'password' => '$$Adm1nW1nnts3rv3r$$',
                'statu_id' => '1',
                'role_id' => '3'
            ]
        ];

        foreach ($users as $value) {
            DB::table('users')->insert([
                'first_name' => $value['first_name'],
                'last_name' => $value['last_name'],
                'email' => $value['email'],
                'password' => Hash::make($value['password']),
                'statu_id' => $value['statu_id'],
                'home_phone' => $value['home_phone'],
                'role_id' => $value['role_id'],
                'remember_token' => Str::random(10),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $worker = Worker::latest('id')->first();

            DB::table('contacts_emergencys')->insert([
                    'user_id' => $worker->id,
                    'created_at' => now(),
                    'updated_at' => now()
            ]);

            DB::table('jobs_information')->insert([
                    'user_id' => $worker->id,
                    'created_at' => now(),
                    'updated_at' => now()
            ]);

            DB::table('educations')->insert([
                    'user_id' => $worker->id,
                    'created_at' => now(),
                    'updated_at' => now()
            ]);

            DB::table('confirmations')->insert([
                    'user_id' => $worker->id,
                    'created_at' => now(),
                    'updated_at' => now()
            ]);

            DB::table('references')->insert([
                    'user_id' => $worker->id,
                    'reference_number' => '1',
                    'created_at' => now(),
                    'updated_at' => now()
            ]);

            DB::table('references_jobs')->insert([
                    'user_id' => $worker->id,
                    'reference_number' => '1',
                    'created_at' => now(),
                    'updated_at' => now()
            ]);

            DB::table('references')->insert([
                    'user_id' => $worker->id,
                    'reference_number' => '2',
                    'created_at' => now(),
                    'updated_at' => now()
            ]);

            DB::table('references_jobs')->insert([
                    'user_id' => $worker->id,
                    'reference_number' => '2',
                    'created_at' => now(),
                    'updated_at' => now()
            ]);
        }
    }
}

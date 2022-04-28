<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeDocsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
        {

        $docs = [
            [
                'name_doc' => 'ID Card',
                'document_certificate' => '0'
            ],
            [
                'name_doc' => 'Medical Degree',
                'document_certificate' => '0'
            ],
            [
                'name_doc' => 'License',
                'document_certificate' => '0'
            ],
        ];

        foreach ($docs as $value) {
            DB::table('type_docs')->insert([
                'name_doc' => $value['name_doc'],
                'document_certificate' => $value['document_certificate'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

    }
}

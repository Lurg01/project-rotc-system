<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemesteryearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('semesteryears')->insert([
            [
                'id' => 1,
                'student_id' => 1,
                'semester' => '1',
                'year' => '2023',
            ],
            [
                'id' => 2,
                'student_id' => 2,
                'semester' => '1',
                'year' => '2023',
            ],
            [
                'id' => 3,
                'student_id' => 3,
                'semester' => '1',
                'year' => '2023',
            ],
            [
                'id' => 4,
                'student_id' => 4,
                'semester' => '1',
                'year' => '2023',
            ],
            [
                'id' => 5,
                'student_id' => 5,
                'semester' => '1',
                'year' => '2023',
            ],
            [
                'id' => 6,
                'student_id' => 6,
                'semester' => '1',
                'year' => '2023',
            ],
            [
                'id' => 7,
                'student_id' => 7,
                'semester' => '1',
                'year' => '2023',
            ],
            [
                'id' => 8,
                'student_id' => 8,
                'semester' => '1',
                'year' => '2023',
            ]
        ]);
    }
}

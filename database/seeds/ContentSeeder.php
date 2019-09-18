<?php

use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('content')->insert([
            'title' => 'What is Laravel',
            'content' => 'Laravel is a PHP framework...',
        ]);
    }
}

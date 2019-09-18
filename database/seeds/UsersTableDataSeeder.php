<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
	            'name' => 'admin',
	            'email' => 'admin@admin.com',
	            'password' => bcrypt('123456'),
                'role' => 2,
                'status' => 1,
            ]);
            $user_name = array('test1','test2');
            for ($i=0; $i < count($user_name); $i++) { 
                User::create([
                    'name' => $user_name[$i],
                    'email' => $user_name[$i].'@mail.com',
                    'password' => bcrypt('123456'),
                    'status' => 1,
                ]);
            }
    }
    
}

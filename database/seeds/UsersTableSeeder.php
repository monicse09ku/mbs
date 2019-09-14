<?php

use Illuminate\Database\Seeder;

use App\User;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	User::truncate();

    	$users = [
            [
                'name' => "John Doe",
                'email' => 'admin@gmail.com',
                'password' => bcrypt('123456!@#'),
                'role' => 'super_admin',
            ],
    	];

    	foreach($users as $user) {
    		User::create($user);
    	}

    }
}

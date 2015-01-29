<?php

class UserTableSeeder extends Seeder {
	public function run()
	{
		User::create([
			'email'    => 'admin@shiyanlou.com',
			'password' => Hash::make('123456'),
			'nickname' => 'admin',
			'is_admin' => 1,
		]);

		User::create([
			'email'    => 'snow@shiyanlou.com',
			'password' => Hash::make('123456'),
			'nickname' => 'snow',
			'is_admin' => 0,
		]);
	}
}
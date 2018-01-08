<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Andreu García Martínez',
            'email' => 'anduwet2@gmail.com',
            'password' => bcrypt('12345'),
        ]);
    }
}

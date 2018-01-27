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
            'dni' => '29196333H',
            'phone' => '622 666 125',
            'address_uno' => 'Calle Cienfuegos 16, pta 3',
            'address_dos' => '46006, Valencia.',
            'banco_name' => 'Openbank',
            'banco_cuenta' => 'ES1800730100500560829887',
        ]);
    }
}

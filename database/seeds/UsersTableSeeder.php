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
          'id' => 1,
          'name' => 'Andreu García Martínez',
          'email' => 'anduwet2@gmail.com',
          'email_public' => 'andreu.garcia@taxo.es',
          'password' => '$2y$10$QSrhjY93nu87G7s0ix.Fae8TzYJma7RNPRN2n2tFUZYlpHmzC2Br2',
          'dni' => '29196333H',
          'phone' => '622 666 125',
          'address_uno' => 'Calle Cienfuegos 16, pta 3',
          'address_dos' => '46006, Valencia.',
          'irpf' => 7,
          'iva' => 21,
          'banco_name' => 'Openbank',
          'banco_cuenta' => 'ES1800730100500560829887',
          'api_token' => 'tnIaufFIQjA1VMgTnAWzAvMyTyFkAIi004K6c88CVGhsMKMWUQFWQdOELM37',
          'remember_token' => 'L2fzIFyaNJwun3TkCvGTzngEqAiIpdnH9CEcynZ0QSfhkLN9s7Th5wbqUOnr',
          'created_at' => NULL,
          'updated_at' => '2018-03-17 02:12:44',
        ]);

        DB::table('users')->insert([
          'id' => 2,
          'name' => 'Guillermo Ortiz Herrera',
          'email' => 'guillermoortizherrera1987@gmail.com',
          'email_public' => 'guillermoortizherrera1987@gmail.com',
          'password' => '$2y$10$MYT0xms9voAf/KYLee0QCefnPS1UjgzFtNiWYq0jTMBGVaQD60pCy',
          'dni' => '47289535V',
          'phone' => '628 945 336',
          'address_uno' => 'Avda Constitución 39, 11',
          'address_dos' => '46009, Valencia.',
          'irpf' => 7,
          'iva' => 21,
          'banco_name' => 'Bankia',
          'banco_cuenta' => '',
          'api_token' => '',
          'remember_token' => '',
          'created_at' => NULL,
          'updated_at' => '2018-01-28 19:04:28',
        ]);

        DB::table('users')->insert([
          'id' => 3,
          'name' => 'Marta Tornero Rubio',
          'email' => 'mtornerorubio@gmail.com',
          'email_public' => 'marta@mtornero.com',
          'password' => '$2y$10$Ihb96nrSQzzxug3cTjTz0.JzTnrdjnhf5fbJDvsZD7KjVGKShkERK',
          'dni' => '22598640J',
          'phone' => NULL,
          'address_uno' => 'c/Reina Doña María, 9 puerta 7',
          'address_dos' => '46006, Valencia',
          'irpf' => 15,
          'iva' => 21,
          'banco_name' => 'ING',
          'banco_cuenta' => 'ES43 1465 0100 95 1725734305',
          'api_token' => NULL,
          'remember_token' => 'Hs5PTfyE3qIwWKmDIlgpz8dTXh6P8XcqQaDcUDj8aeOSecnBxxZlpigDZ9At',
          'created_at' => NULL,
          'updated_at' => NULL,
        ]);
    }
}

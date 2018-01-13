<?php

use Illuminate\Database\Seeder;

class FacturasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('facturas')->insert([
          ['num' => '001/17', 'user_id' => 1, 'client_id' => 1, 'horas' => 0, 'precio' => 2000, 'pagada' => 1, 'persona_fisica' => 1, 'created_at' => '2017-04-30 00:00:00'],
          ['num' => '002/17', 'user_id' => 1, 'client_id' => 2, 'horas' => 100, 'precio' => 51, 'pagada' => 1, 'persona_fisica' => 0, 'created_at' => '2017-04-30 00:00:00'],
          ['num' => '003/17', 'user_id' => 1, 'client_id' => 2, 'horas' => 100, 'precio' => 51, 'pagada' => 1, 'persona_fisica' => 0, 'created_at' => '2017-05-30 00:00:00'],
          ['num' => '004/17', 'user_id' => 1, 'client_id' => 2, 'horas' => 290, 'precio' => 15, 'pagada' => 1, 'persona_fisica' => 0, 'created_at' => '2017-08-04 00:00:00'],
          ['num' => '005/17', 'user_id' => 1, 'client_id' => 2, 'horas' => 0, 'precio' => 1600, 'pagada' => 1, 'persona_fisica' => 0, 'created_at' => '2017-09-30 00:00:00'],
          ['num' => '006/17', 'user_id' => 1, 'client_id' => 2, 'horas' => 0, 'precio' => 1600, 'pagada' => 1, 'persona_fisica' => 0, 'created_at' => '2017-10-31 00:00:00'],
          ['num' => '007/17', 'user_id' => 1, 'client_id' => 2, 'horas' => 107, 'precio' => 15, 'pagada' => 1, 'persona_fisica' => 0, 'created_at' => '2017-11-30 00:00:00'],
          ['num' => '008/17', 'user_id' => 1, 'client_id' => 2, 'horas' => 0, 'precio' => 1590, 'pagada' => 1, 'persona_fisica' => 0, 'created_at' => '2017-12-31 00:00:00'],
      ]);
    }
}

<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('clients')->insert([
          ['id' => 1, 'user_id' => 1, 'nif' => '15255691K', 'name' => 'Jose Ángel Rodriguez González', 'address' => 'Avenida Aragón, 30 Bajo, Valencia', 'persona_fisica' => 1],
          ['id' => 2, 'user_id' => 1, 'nif' => 'B96735576', 'name' => 'TAXO Valoración, S.L.', 'address' => 'Avda. de Aragón 30 F 13, Valencia', 'persona_fisica' => 0],
          ['id' => 3, 'user_id' => 1, 'nif' => 'B98537004', 'name' => 'Nemesis media, S.L', 'address' => 'Calle Flora 1 9, Valencia', 'persona_fisica' => 0],
          ['id' => 4, 'user_id' => 1, 'nif' => 'B98893639', 'name' => 'O´Clock Digital Solutions S.L.', 'address' => 'Avenida Aragón, 30 Bajo, Valencia', 'persona_fisica' => 0],
          ['id' => 5, 'user_id' => 1, 'nif' => '50737188Q', 'name' => 'Manuel Ruiz del Corral', 'address' => 'C/ Aracne 23, 28022, Madrid', 'persona_fisica' => 1],
          ['id' => 6, 'user_id' => 1, 'nif' => '21670181H', 'name' => 'Carlos Gisbert Pérez', 'address' => 'C/ Sant Mateu 30, 4ºB, 03801, Alcoy', 'persona_fisica' => 1],
          ['id' => 7, 'user_id' => 3, 'nif' => 'B98917438', 'name' => 'Body Performance, SL', 'address' => 'C/ Caravaca, 9. Bjo Izqda 46021 – Valencia', 'persona_fisica' => 0],
          ['id' => 8, 'user_id' => 3, 'nif' => '71276875J', 'name' => 'Diana Cámara Gamero', 'address' => 'C/Pintor Guerrero del Castillo 2 pta 10, 29016 Málaga', 'persona_fisica' => 1],
          ['id' => 9, 'user_id' => 2, 'nif' => 'B96735576', 'name' => 'TAXO Valoración, S.L.', 'address' => 'Avda. de Aragón 30 F 13, Valencia', 'persona_fisica' => 0],
      ]);
    }
}

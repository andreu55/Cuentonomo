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
      ]);
    }
}

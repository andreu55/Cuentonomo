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
          ['id' => 1, 'nif' => '15255691K', 'name' => 'Jose Ángel Rodriguez González', 'address' => 'Avenida Aragón, 30 Bajo, Valencia'],
          ['id' => 2, 'nif' => 'B96735576', 'name' => 'TAXO Valoración, S.L.', 'address' => 'Avda. de Aragón 30 F 13, Valencia'],
          ['id' => 3, 'nif' => 'B98537004', 'name' => 'Nemesis media, S.L', 'address' => 'Calle Flora 1 9, Valencia'],
          ['id' => 4, 'nif' => 'B98893639', 'name' => 'O´Clock Digital Solutions S.L.', 'address' => 'Avenida Aragón, 30 Bajo, Valencia'],
      ]);
    }
}

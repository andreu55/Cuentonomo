<?php

use Illuminate\Database\Seeder;

class JornadasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jornadas')->insert([
          ['user_id' => 1, 'client_id' => 2, 'entrada' => '09:00:00', 'salida' => '18:30:00', 'notas' => NULL, 'fecha' => '2018-01-15'],
          ['user_id' => 1, 'client_id' => 2, 'entrada' => '09:00:00', 'salida' => '19:30:00', 'notas' => NULL, 'fecha' => '2018-01-16'],
          ['user_id' => 1, 'client_id' => 2, 'entrada' => '09:15:00', 'salida' => '17:30:00', 'notas' => NULL, 'fecha' => '2018-01-17'],
          ['user_id' => 1, 'client_id' => 2, 'entrada' => '09:00:00', 'salida' => '21:30:00', 'notas' => NULL, 'fecha' => '2018-01-18'],
          ['user_id' => 1, 'client_id' => 2, 'entrada' => '09:00:00', 'salida' => '15:00:00', 'notas' => NULL, 'fecha' => '2018-01-19'],

          ['user_id' => 1, 'client_id' => 2, 'entrada' => '12:00:00', 'salida' => '18:45:00', 'notas' => 'Visita Seg.Social y Dentista', 'fecha' => '2018-01-23'],
          ['user_id' => 1, 'client_id' => 2, 'entrada' => '09:00:00', 'salida' => '17:45:00', 'notas' => NULL, 'fecha' => '2018-01-24'],
          ['user_id' => 1, 'client_id' => 2, 'entrada' => '10:00:00', 'salida' => '19:45:00', 'notas' => NULL, 'fecha' => '2018-01-25'],
          ['user_id' => 1, 'client_id' => 2, 'entrada' => '10:00:00', 'salida' => '15:00:00', 'notas' => NULL, 'fecha' => '2018-01-26'],

          ['user_id' => 1, 'client_id' => 2, 'entrada' => '09:30:00', 'salida' => '19:45:00', 'notas' => 'Alta autónomo, visita Ramón Mateos', 'fecha' => '2018-01-29'],
          ['user_id' => 1, 'client_id' => 2, 'entrada' => '09:30:00', 'salida' => '18:30:00', 'notas' => NULL, 'fecha' => '2018-01-30'],
          ['user_id' => 1, 'client_id' => 2, 'entrada' => '09:15:00', 'salida' => '17:45:00', 'notas' => NULL, 'fecha' => '2018-01-31'],
          ['user_id' => 1, 'client_id' => 2, 'entrada' => '09:15:00', 'salida' => '17:30:00', 'notas' => NULL, 'fecha' => '2018-02-01'],
          ['user_id' => 1, 'client_id' => 2, 'entrada' => '09:00:00', 'salida' => '15:00:00', 'notas' => NULL, 'fecha' => '2018-02-02'],

          ['user_id' => 1, 'client_id' => 2, 'entrada' => '10:15:00', 'salida' => '18:30:00', 'notas' => NULL, 'fecha' => '2018-02-05'],
          ['user_id' => 1, 'client_id' => 2, 'entrada' => '09:00:00', 'salida' => '18:45:00', 'notas' => NULL, 'fecha' => '2018-02-06'],
          ['user_id' => 1, 'client_id' => 2, 'entrada' => '09:00:00', 'salida' => '18:00:00', 'notas' => NULL, 'fecha' => '2018-02-07'],
          ['user_id' => 1, 'client_id' => 2, 'entrada' => '09:45:00', 'salida' => '18:15:00', 'notas' => NULL, 'fecha' => '2018-02-08'],
          ['user_id' => 1, 'client_id' => 2, 'entrada' => '09:15:00', 'salida' => '15:15:00', 'notas' => NULL, 'fecha' => '2018-02-09'],

          ['user_id' => 1, 'client_id' => 2, 'entrada' => '09:00:00', 'salida' => '18:30:00', 'notas' => NULL, 'fecha' => '2018-02-12'],
        ]);
    }
}

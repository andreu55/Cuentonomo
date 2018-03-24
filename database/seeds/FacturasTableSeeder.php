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
          ['num' => '001/17', 'user_id' => 1, 'client_id' => 1, 'horas' => '0.00', 'precio' => '2000.00', 'pagada' => 1, 'created_at' => '2017-04-30 00:00:00'],
          ['num' => '002/17', 'user_id' => 1, 'client_id' => 2, 'horas' => '100.00', 'precio' => '51.00', 'pagada' => 1, 'created_at' => '2017-04-30 00:00:00'],
          ['num' => '003/17', 'user_id' => 1, 'client_id' => 2, 'horas' => '100.00', 'precio' => '51.00', 'pagada' => 1, 'created_at' => '2017-05-30 00:00:00'],
          ['num' => '004/17', 'user_id' => 1, 'client_id' => 2, 'horas' => '290.00', 'precio' => '15.00', 'pagada' => 1, 'created_at' => '2017-08-04 00:00:00'],
          ['num' => '005/17', 'user_id' => 1, 'client_id' => 2, 'horas' => '0.00', 'precio' => '1600.00', 'pagada' => 1, 'created_at' => '2017-09-30 00:00:00'],
          ['num' => '006/17', 'user_id' => 1, 'client_id' => 2, 'horas' => '0.00', 'precio' => '1600.00', 'pagada' => 1, 'created_at' => '2017-10-31 00:00:00'],
          ['num' => '007/17', 'user_id' => 1, 'client_id' => 2, 'horas' => '107.00', 'precio' => '15.00', 'pagada' => 1, 'created_at' => '2017-11-30 00:00:00'],
          ['num' => '008/17', 'user_id' => 1, 'client_id' => 2, 'horas' => '0.00', 'precio' => '1590.00', 'pagada' => 1, 'created_at' => '2017-12-31 00:00:00'],
          ['num' => '001/18', 'user_id' => 1, 'client_id' => 2, 'horas' => '166.53', 'precio' => '15.00', 'pagada' => 1, 'created_at' => '2018-01-30 23:00:00'],
          ['num' => '002/18', 'user_id' => 1, 'client_id' => 6, 'horas' => '0.00', 'precio' => '50.00', 'pagada' => 1, 'created_at' => '2018-02-01 23:00:00'],
          ['num' => '003/18', 'user_id' => 1, 'client_id' => 5, 'horas' => '0.00', 'precio' => '250.00', 'pagada' => 1, 'created_at' => '2018-02-02 23:00:00'],
          ['num' => '004/18', 'user_id' => 1, 'client_id' => 2, 'horas' => '166.53', 'precio' => '15.00', 'pagada' => 1, 'created_at' => '2018-02-27 23:00:00'],
          ['num' => '001/18', 'user_id' => 3, 'client_id' => 7, 'horas' => '0.00', 'precio' => '360.00', 'pagada' => 1, 'created_at' => '2018-03-08 23:00:00'],
          ['num' => '002/18', 'user_id' => 3, 'client_id' => 8, 'horas' => '0.00', 'precio' => '139.48', 'pagada' => 1, 'created_at' => '2018-03-13 23:00:00'],
      ]);
    }
}

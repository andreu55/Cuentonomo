<?php

use Illuminate\Database\Seeder;

class TipoGastosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_gastos')->insert([
            ['id' => 1, 'name' => 'Restaurantes', 'iva' => 0.10],
            ['id' => 2, 'name' => 'Hardware', 'iva' => 0.21],
        ]);
    }
}

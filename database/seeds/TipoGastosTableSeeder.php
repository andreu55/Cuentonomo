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
            ['id' => 1, 'name' => 'Restaurantes', 'iva' => 0.10, 'icon' => 'fas fa-utensils'],
            ['id' => 2, 'name' => 'Servicios', 'iva' => 0.21, 'icon' => 'fas fa-taxi'],
            ['id' => 3, 'name' => 'Hardware', 'iva' => 0.21, 'icon' => 'fas fa-hdd'],
            ['id' => 4, 'name' => 'Baile', 'iva' => 0.21, 'icon' => 'fas fa-music'],
        ]);
    }
}

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
            ['id' => 1, 'name' => 'Restaurantes', 'user_id' => null, 'iva' => 0.10, 'percent' => 1, 'icon' => 'fas fa-utensils'],
            ['id' => 2, 'name' => 'General', 'user_id' => null, 'iva' => 0.21, 'percent' => 1, 'icon' => 'fas fa-taxi'],
            ['id' => 3, 'name' => 'Hardware', 'user_id' => 1, 'iva' => 0.21, 'percent' => 1, 'icon' => 'fas fa-hdd'],
            ['id' => 4, 'name' => 'Baile', 'user_id' => 1, 'iva' => 0.21, 'percent' => 1, 'icon' => 'fas fa-music'],
            ['id' => 5, 'name' => 'Facturas casa', 'user_id' => null, 'iva' => 0.21, 'percent' => 0.30, 'icon' => 'far fa-lightbulb'],
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;

class GastosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Hay que crear el seeder de tipo_gastos y pasar tipo a tipo_gasto_id!!

        DB::table('gastos')->insert([
            ['user_id' => 1, 'cantidad' => 13.77, 'iva' => 0.21, 'concepto' => 'Yoigo', 'tipo_gasto_id' => 1, 'created_at' => '2017-07-01 00:00:00'],
        ]);

      // (1, '2017-07-01', '13.77', '0.21', 'Yoigo', 'servicios'),
      // (2, '2017-07-01', '42.07', '0.21', 'Vodafone', 'servicios'),
      // (3, '2017-07-03', '2.70', '0.10', 'Cafetería', 'restaurantes'),
      // (4, '2017-07-04', '12.00', '0.10', 'Cafetería', 'restaurantes'),
      // (5, '2017-07-06', '3.00', '0.10', 'Cafetería', 'restaurantes'),
      // (6, '2017-07-06', '94.90', '0.21', 'PcComponentes HDD Solido', 'hardware'),
      // (7, '2017-07-06', '139.00', '0.21', 'Amazon Pantalla', 'hardware'),
      // (8, '2017-07-07', '3.00', '0.10', 'Cafetería', 'restaurantes'),
      // (9, '2017-07-11', '8.70', '0.10', 'Cafetería', 'restaurantes'),
      // (10, '2017-07-12', '3.00', '0.10', 'Cafetería', 'restaurantes'),
      // (11, '2017-07-13', '6.00', '0.10', 'Cafetería', 'restaurantes'),
      // (12, '2017-07-14', '9.60', '0.10', 'Chivito', 'restaurantes'),
      // (13, '2017-07-17', '5.70', '0.10', 'Cafetería', 'restaurantes'),
      // (14, '2017-07-18', '3.00', '0.10', 'Cafetería', 'restaurantes'),
      // (15, '2017-07-20', '3.90', '0.10', 'Cafetería', 'restaurantes'),
      // (16, '2017-07-21', '2.70', '0.10', 'Cafetería', 'restaurantes'),
      // (17, '2017-07-24', '2.50', '0.10', 'Cafetería', 'restaurantes'),
      // (18, '2017-07-25', '2.50', '0.10', 'Cafetería', 'restaurantes'),
      // (19, '2017-07-26', '2.50', '0.10', 'Cafetería', 'restaurantes'),
      // (20, '2017-07-27', '10.00', '0.10', 'Colala', 'restaurantes'),
      // (21, '2017-07-28', '4.80', '0.10', 'Chivito', 'restaurantes'),
      // (22, '2017-08-01', '50.47', '0.21', 'Yoigo', 'servicios'),
      // (23, '2017-08-01', '3.30', '0.10', 'Cafetería', 'restaurantes'),
      // (24, '2017-08-02', '4.00', '0.10', 'Cafetería', 'restaurantes'),
      // (25, '2017-08-03', '3.00', '0.10', 'Cafetería', 'restaurantes'),
      // (26, '2017-08-04', '4.80', '0.10', 'Papito', 'restaurantes'),
      // (27, '2017-08-08', '5.50', '0.10', 'Cafetería', 'restaurantes'),
      // (28, '2017-08-09', '2.50', '0.10', 'Cafetería', 'restaurantes'),
      // (29, '2017-08-10', '4.00', '0.10', 'Cafetería 2 tickets', 'restaurantes'),
      // (30, '2017-08-11', '42.25', '0.21', 'Vodafone', 'servicios'),
      // (31, '2017-08-16', '16.49', '0.21', 'Amazon Prime', 'servicios'),
      // (32, '2017-08-17', '4.80', '0.10', 'Cafetería 2 tickets', 'restaurantes'),
      // (33, '2017-08-18', '6.70', '0.10', 'Cafetería 2 tickets', 'restaurantes'),
      // (34, '2017-08-21', '2.68', '0.10', 'Consum', 'restaurantes'),
      // (35, '2017-08-22', '4.50', '0.10', 'Chivito', 'restaurantes'),
      // (36, '2017-08-23', '2.25', '0.10', 'Cafetería', 'restaurantes'),
      // (37, '2017-08-24', '2.25', '0.10', 'Cafetería', 'restaurantes'),
      // (38, '2017-08-25', '10.00', '0.10', 'Aoyama', 'restaurantes'),
      // (39, '2017-08-25', '1.30', '0.10', 'Chivito', 'restaurantes'),
      // (40, '2017-08-26', '6.00', '0.10', 'Taxi', 'servicios'),
      // (41, '2017-08-28', '2.50', '0.10', 'Cafetería', 'restaurantes'),
      // (42, '2017-08-29', '2.70', '0.10', 'Cafetería', 'restaurantes'),
      // (43, '2017-08-30', '3.20', '0.10', 'Cafetería', 'restaurantes'),
      // (44, '2017-08-31', '5.20', '0.10', 'Cafetería', 'restaurantes'),
      // (45, '2017-09-01', '2.00', '0.10', 'Desayuno', 'restaurantes'),
      // (46, '2017-09-01', '4.50', '0.10', 'Chivito', 'restaurantes'),
      // (47, '2017-09-01', '24.50', '0.21', 'Yoigo', 'servicios'),
      // (48, '2017-09-13', '5.10', '0.10', 'Cafetería', 'restaurantes'),
      // (49, '2017-09-13', '5.10', '0.10', 'Merienda', 'restaurantes'),
      // (50, '2017-09-14', '5.40', '0.10', 'Cafetería', 'restaurantes'),
      // (51, '2017-09-14', '3.00', '0.10', 'Cafetería', 'restaurantes'),
      // (52, '2017-09-15', '4.80', '0.10', 'Chivito', 'restaurantes'),
      // (53, '2017-09-12', '2.60', '0.10', 'Cafetería', 'restaurantes'),
      // (54, '2017-09-06', '3.40', '0.10', 'Desayuno', 'restaurantes'),
      // (55, '2017-09-06', '2.50', '0.10', 'Cafetería', 'restaurantes'),
      // (56, '2017-09-05', '3.90', '0.10', 'Cafetería', 'restaurantes'),
      // (57, '2017-09-04', '2.70', '0.10', 'Cafetería', 'restaurantes'),
      // (58, '2017-09-11', '2.60', '0.10', 'Cafetería', 'restaurantes'),
      // (59, '2017-09-18', '2.70', '0.10', 'Cafetería', 'restaurantes'),
      // (60, '2017-09-19', '2.70', '0.10', 'Cafetería', 'restaurantes'),
      // (61, '2017-09-20', '5.50', '0.10', 'Cafetería', 'restaurantes'),
      // (62, '2017-09-20', '250.00', '0.21', 'Osteopatía', 'baile'),
      // (63, '2017-09-21', '2.70', '0.10', 'Cafetería', 'restaurantes'),
      // (64, '2017-09-22', '3.00', '0.10', 'Chivito', 'restaurantes'),
      // (65, '2017-09-25', '2.70', '0.10', 'Cafetería', 'restaurantes'),
      // (66, '2017-09-26', '2.70', '0.10', 'Cafetería', 'restaurantes'),
      // (67, '2017-09-27', '2.70', '0.10', 'Cafetería', 'restaurantes'),
      // (68, '2017-09-27', '42.50', '0.10', 'Clases', 'baile'),
      // (69, '2017-09-28', '2.50', '0.10', 'Cafetería', 'restaurantes'),
      // (70, '2017-09-29', '4.50', '0.10', 'Chivito', 'restaurantes'),
      // (71, '2017-10-01', '12.70', '0.10', 'Mas de Barberans', 'restaurantes'),
      // (72, '2017-10-03', '3.00', '0.10', 'Cafetería', 'restaurantes'),
      // (73, '2017-10-03', '3.50', '0.10', 'Chivito', 'restaurantes'),
      // (74, '2017-10-04', '3.00', '0.10', 'Cafetería', 'restaurantes'),
      // (75, '2017-10-04', '6.59', '0.10', 'Comida consum', 'restaurantes'),
      // (76, '2017-10-05', '2.70', '0.10', 'Cafetería', 'restaurantes'),
      // (77, '2017-10-06', '9.30', '0.10', 'Chivito', 'restaurantes'),
      // (78, '2017-10-10', '2.50', '0.10', 'Cafetería', 'restaurantes'),
      // (79, '2017-10-11', '1.50', '0.10', 'Cafetería', 'restaurantes'),
      // (80, '2017-10-13', '4.50', '0.10', 'Chivito', 'restaurantes'),
      // (81, '2017-10-14', '14.10', '0.10', 'Comida ZGZ', 'restaurantes'),
      // (82, '2017-10-14', '14.00', '0.10', 'Comida ZGZ', 'restaurantes'),
      // (83, '2017-10-15', '4.00', '0.10', 'Comida MUV', 'restaurantes'),
      // (84, '2017-10-15', '10.00', '0.10', 'Comida MUV', 'restaurantes'),
      // (85, '2017-10-15', '5.00', '0.10', 'Comida MUV', 'restaurantes'),
      // (86, '2017-10-16', '2.50', '0.10', 'Cafetería', 'restaurantes'),
      // (87, '2017-10-17', '3.00', '0.10', 'Cafetería', 'restaurantes'),
      // (88, '2017-10-18', '2.70', '0.10', 'Cafetería', 'restaurantes'),
      // (89, '2017-10-19', '2.50', '0.10', 'Cafetería', 'restaurantes'),
      // (90, '2017-10-20', '2.35', '0.10', 'Merienda', 'restaurantes'),
      // (91, '2017-10-20', '4.50', '0.10', 'Chivito', 'restaurantes'),
      // (92, '2017-10-23', '2.50', '0.10', 'Cafetería', 'restaurantes'),
      // (93, '2017-10-25', '7.74', '0.10', 'Comida consum', 'restaurantes'),
      // (94, '2017-10-26', '3.00', '0.10', 'Cafetería', 'restaurantes'),
      // (95, '2017-10-30', '3.70', '0.10', 'Cafetería', 'restaurantes'),
      // (96, '2017-10-31', '3.50', '0.10', 'Chivito', 'restaurantes'),
      // (97, '2017-11-02', '3.70', '0.10', 'Cafetería', 'restaurantes'),
      // (98, '2017-11-03', '3.00', '0.10', 'Cafetería', 'restaurantes'),
      // (99, '2017-11-03', '25.00', '0.21', '5 Aniversario BB', 'baile'),
      // (100, '2017-11-06', '1.50', '0.10', 'Cafetería', 'restaurantes'),
      // (101, '2017-11-07', '1.00', '0.10', 'Cafetería', 'restaurantes'),
      // (102, '2017-11-07', '1.50', '0.10', 'Cafetería', 'restaurantes'),
      // (103, '2017-11-08', '1.50', '0.10', 'Cafetería', 'restaurantes'),
      // (104, '2017-11-08', '4.40', '0.10', 'Merienda Riba-Roja', 'restaurantes'),
      // (105, '2017-11-10', '2.20', '0.10', 'Cafetería', 'restaurantes'),
      // (106, '2017-11-13', '4.92', '0.10', 'Consum', 'restaurantes'),
      // (107, '2017-11-14', '3.20', '0.10', 'Cafetería', 'restaurantes'),
      // (108, '2017-11-15', '5.70', '0.10', 'Cafetería', 'restaurantes'),
      // (109, '2017-11-16', '7.50', '0.10', 'Cafetería', 'restaurantes'),
      // (110, '2017-11-16', '11.50', '0.10', 'Goiko', 'restaurantes'),
      // (112, '2017-11-20', '100.74', '0.21', 'Pantalla Benq', 'hardware'),
      // (115, '2017-11-21', '2.70', '0.10', 'Cafetería', 'restaurantes'),
      // (116, '2017-11-29', '27.65', '0.21', 'Arreglo bicicleta', 'servicios'),
      // (117, '2017-11-20', '10.90', '0.21', 'Envío del teléfono a reparación', 'servicios'),
      // (118, '2017-11-22', '4.70', '0.10', 'Cafetería', 'restaurantes'),
      // (119, '2017-11-23', '26.67', '0.10', 'Dominos pizza', 'restaurantes'),
      // (120, '2017-11-24', '9.00', '0.10', 'Chivito', 'restaurantes'),
      // (121, '2017-11-28', '5.00', '0.10', 'Cafetería', 'restaurantes'),
      // (122, '2017-11-29', '5.60', '0.10', 'Cafetería x2', 'restaurantes'),
      // (123, '2017-12-01', '4.50', '0.10', 'Papito Zipi Zape', 'restaurantes'),
      // (125, '2017-12-04', '4.60', '0.10', 'Papito', 'restaurantes'),
      // (126, '2017-12-05', '2.70', '0.10', 'Cafetería', 'restaurantes'),
      // (128, '2017-12-12', '4.50', '0.10', 'Zipi zape', 'restaurantes'),
      // (129, '2017-12-07', '6.20', '0.10', 'Cafetería', 'restaurantes'),
      // (130, '2017-12-06', '4.50', '0.10', 'Montaditos', 'restaurantes'),
      // (131, '2017-12-15', '4.50', '0.10', 'Papito', 'restaurantes'),
      // (132, '2017-12-01', '4.80', '0.10', 'Cafetería estrella', 'restaurantes'),
      // (136, '2017-12-08', '19.00', '0.10', 'Wok bonaire', 'restaurantes'),
      // (137, '2017-12-10', '20.00', '0.10', 'Bodega', 'restaurantes'),
      // (138, '2017-12-11', '4.70', '0.10', 'Cafetería', 'restaurantes'),
      // (139, '2017-12-12', '2.50', '0.10', 'Cafetería', 'restaurantes'),
      // (140, '2017-12-13', '2.50', '0.10', 'Cafetería', 'restaurantes'),
      // (142, '2017-12-16', '6.00', '0.10', 'Cafetería estrella', 'restaurantes'),
      // (143, '2017-12-13', '9.00', '0.10', 'Poppins', 'restaurantes'),
      // (144, '2017-12-14', '11.50', '0.10', 'Goiko', 'restaurantes'),
      // (145, '2017-12-17', '15.00', '0.10', 'Colala', 'restaurantes'),
      // (146, '2017-12-20', '4.50', '0.10', 'Cafetería', 'restaurantes'),
      // (147, '2017-12-18', '2.50', '0.10', 'Cafetería', 'restaurantes'),
      // (148, '2017-12-22', '4.50', '0.10', 'Papito', 'restaurantes'),
      // (149, '2017-12-20', '5.00', '0.10', 'Bluebell', 'restaurantes'),
      // (150, '2017-12-27', '20.00', '0.10', 'Cafe y cena', 'restaurantes'),
      // (151, '2017-12-29', '1.80', '0.10', 'Cafetería', 'restaurantes'),
      // (152, '2017-11-06', '63.00', '0.21', 'Fuente alimentacion', 'hardware'),
      // (153, '2017-12-07', '9.67', '0.21', 'Dominio andreugarcia.com', 'servicios'),

    }
}

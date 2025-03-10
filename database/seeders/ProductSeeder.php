<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Limpiar la tabla antes de insertar nuevos datos
        DB::table('products')->truncate();

        // Insertar 20 productos de prueba
        $products = [
            ['name' => 'Smartphone Samsung Galaxy S22', 'price' => 799.99],
            ['name' => 'Laptop Dell XPS 13', 'price' => 1299.99],
            ['name' => 'Monitor LG Ultrawide 34"', 'price' => 499.99],
            ['name' => 'Teclado Mecánico Redragon', 'price' => 89.99],
            ['name' => 'Mouse Logitech MX Master 3', 'price' => 99.99],
            ['name' => 'Audífonos Sony WH-1000XM4', 'price' => 349.99],
            ['name' => 'Tablet iPad Air 2022', 'price' => 599.99],
            ['name' => 'Impresora HP LaserJet Pro', 'price' => 199.99],
            ['name' => 'Silla Gamer Razer Iskur', 'price' => 499.99],
            ['name' => 'Disco Duro Externo WD 2TB', 'price' => 79.99],
            ['name' => 'Cámara Canon EOS M50', 'price' => 649.99],
            ['name' => 'Smartwatch Apple Watch Series 8', 'price' => 399.99],
            ['name' => 'Microondas Samsung 30L', 'price' => 159.99],
            ['name' => 'Refrigerador LG Inverter', 'price' => 1099.99],
            ['name' => 'Licuadora Oster 600W', 'price' => 49.99],
            ['name' => 'Cafetera Nespresso Vertuo', 'price' => 129.99],
            ['name' => 'Aspiradora Dyson V11', 'price' => 599.99],
            ['name' => 'Router TP-Link Archer AX73', 'price' => 149.99],
            ['name' => 'Memoria RAM Corsair 16GB DDR4', 'price' => 79.99],
            ['name' => 'Procesador AMD Ryzen 7 5800X', 'price' => 339.99],
        ];

        // Insertar productos en la base de datos
        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

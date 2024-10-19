<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        DB::table('users')->insert([
            [
                'name' => 'usuario',
                'apellido' => 'usuario',
                'cedula' => '313455430',
                'telefono' => '0987654321',
                'direccion' => 'direccion',
                'email' => 'usuario@example.com',
                'password' => bcrypt('password'),
                'usertype' => 'user',
            ],
            [
                'name' => 'admin',
                'apellido' => 'admin',
                'cedula' => '123456789',
                'telefono' => '1234567890',
                'direccion' => 'direccion admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'usertype' => 'admin',
            ]
        ]);

        DB::table('farmacias')->insert([
            [
                'id_farmacia' => 1,
                'nombre_razon_social' => 'Farmacia Central',
                'rif' => '123456789',
                'ubicacion' => DB::raw("ST_GeomFromText('POINT(10.681213617869739 -71.6657819411312)')"),
                'imagen' => 'ENxBEvCMceQXP9TyyPGZlZXUqGOCqk7ioPUL3sqj.jpg'
            ],
            [
                'id_farmacia' => 2,
                'nombre_razon_social' => 'Farmacia Maraplus',
                'rif' => 'J-12345678-9',
                'ubicacion' => DB::raw("ST_GeomFromText('POINT(10.654964322126983 -71.65899062222076)')"),
                'imagen' => 'ENxBEvCMceQXP9TyyPGZlZXUqGOCqk7ioPUL3sqj.jpg'
            ]
        ]);

        DB::table('medicamentos')->insert([
            [
                'id_medicamento' => 1,
                'nombre' => 'Aspirina',
                'precio' => 50.00,
                'fabricante' => 'Laboratorio XYZ',
                'descripcion' => 'Medicamento para el dolor y fiebre.',
                'pais_fabricacion' => 'España',
                'categoria' => 'Analgésico',
                'Foto' => 'build/assets/images/medicamentos/aspirina.jpg',
                'id_farmacia' => 1,
            ],
            [
                'id_medicamento' => 7,
                'nombre' => 'Teragrip',
                'precio' => 15.50,
                'fabricante' => 'Fabricante A',
                'descripcion' => 'Descripción A',
                'pais_fabricacion' => 'País A',
                'categoria' => 'Categoría A',
                'Foto' => 'build/assets/images/medicamentos/teragrip.png',
                'id_farmacia' => 1,
            ],
            [
                'id_medicamento' => 8,
                'nombre' => 'Acetaminofen',
                'precio' => 22.75,
                'fabricante' => 'Fabricante B',
                'descripcion' => 'Descripción B',
                'pais_fabricacion' => 'País B',
                'categoria' => 'Categoría B',
                'Foto' => 'build/assets/images/medicamentos/acetaminofen.jpg',
                'id_farmacia' => 1,
            ],
            [
                'id_medicamento' => 9,
                'nombre' => 'Clorace',
                'precio' => 8.99,
                'fabricante' => 'Fabricante C',
                'descripcion' => 'Descripción C',
                'pais_fabricacion' => 'País C',
                'categoria' => 'Categoría C',
                'Foto' => 'build/assets/images/medicamentos/clorace.webp',
                'id_farmacia' => 3,
            ],
            [
                'id_medicamento' => 10,
                'nombre' => 'Levotiroxina',
                'precio' => 12.40,
                'fabricante' => 'Fabricante D',
                'descripcion' => 'Descripción D',
                'pais_fabricacion' => 'País D',
                'categoria' => 'Categoría D',
                'Foto' => 'build/assets/images/medicamentos/levotiroxina.jpg',
                'id_farmacia' => 3,
            ],
            [
                'id_medicamento' => 11,
                'nombre' => 'Diclofenac',
                'precio' => 5.25,
                'fabricante' => 'Fabricante E',
                'descripcion' => 'Descripción E',
                'pais_fabricacion' => 'País E',
                'categoria' => 'Categoría E',
                'Foto' => 'build/assets/images/medicamentos/diclofenac.jpg',
                'id_farmacia' => 1,
            ],
            [
                'id_medicamento' => 12,
                'nombre' => 'Ibuprofeno',
                'precio' => 10.99,
                "fabricante" => 'Fabricante F',
                "descripcion" => 'Medicamento antiinflamatorio y analgésico.',
                "pais_fabricacion" => 'España',
                "categoria" => 'Analgesicos',
                "Foto" => 'build/assets/images/medicamentos/ibuprofeno.jpg',
                "id_farmacia" => '1'
            ],
            [
                "id_medicamento" => '13',
                "nombre" => 'Amoxicilina',
                "precio" => '25.00',
                "fabricante" => 'Fabricante G',
                "descripcion" => 'Antibiótico utilizado para tratar infecciones.',
                "pais_fabricacion" => 'España',
                "categoria" => 'Antibioticos',
                "Foto" => 'build/assets/images/medicamentos/amoxicilina.jpg',
                "id_farmacia" => '1'
            ]
        ]);

        DB::table('inventarios')->insert([
            [
                'id_inventario' => 1,
                'id_medicamento' => 1,
                'id_farmacia' => 1,
                'numero_lote' => 'Lote001',
                'cantidad_disponible' => 88,
                'fecha_vencimiento' => '2024-09-15',
                'created_at' => '2024-08-17 02:58:48',
                'updated_at' => '2024-10-02 00:21:15',
            ],
            [
                'id_inventario' => 2,
                'id_medicamento' => 1,
                'id_farmacia' => 1,
                'numero_lote' => 'Lote002',
                'cantidad_disponible' => 50,
                'fecha_vencimiento' => '2024-10-01',
                'created_at' => '2024-08-17 02:58:48',
                'updated_at' => '2024-08-17 02:58:48',
            ],
            [
                'id_inventario' => 3,
                'id_medicamento' => 7,
                'id_farmacia' => 1,
                'numero_lote' => 'Lote003',
                'cantidad_disponible' => 186,
                'fecha_vencimiento' => '2024-08-30',
                'created_at' => '2024-08-17 02:58:48',
                'updated_at' => '2024-10-02 00:21:15',
            ],
            [
                'id_inventario' => 4,
                'id_medicamento' => 7,
                'id_farmacia' => 1,
                'numero_lote' => 'Lote004',
                'cantidad_disponible' => 150,
                'fecha_vencimiento' => '2024-11-05',
                'created_at' => '2024-08-17 02:58:48',
                'updated_at' => '2024-08-17 02:58:48',
            ],
            [
                'id_inventario' => 5,
                'id_medicamento' => 8,
                'id_farmacia' => 3,
                'numero_lote' => 'Lote005',
                'cantidad_disponible' => 147,
                'fecha_vencimiento' => '2024-11-05',
                'created_at' => '2024-09-26 12:50:02',
                'updated_at' => '2024-10-02 01:57:41',
            ],
        ]);
    }
}

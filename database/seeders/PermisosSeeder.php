<?php

namespace Database\Seeders;

use App\Models\Permisos;
use Illuminate\Database\Seeder;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Eliminar permisos existentes
        Permisos::truncate();

        // Insertar nuevos permisos
        Permisos::insert([
                [
                    'id' => '1',
                    'profile_id' => '1',
                    'menu_id' => '1',
                    'submenu_id' => '1',
                    'lee' => '1',
                    'graba' => '1',
                    'borra' => '1',
                    'estado' => '1',
                ],
                [
                    'id' => '2',
                    'profile_id' => '1',
                    'menu_id' => '1',
                    'submenu_id' => '2',
                    'lee' => '1',
                    'graba' => '1',
                    'borra' => '1',
                    'estado' => '1',
                ],
                [
                    'id' => '3',
                    'profile_id' => '1',
                    'menu_id' => '1',
                    'submenu_id' => '3',
                    'lee' => '1',
                    'graba' => '1',
                    'borra' => '1',
                    'estado' => '1',
                ],
                [
                    'id' => '4',
                    'profile_id' => '1',
                    'menu_id' => '2',
                    'submenu_id' => '4',
                    'lee' => '1',
                    'graba' => '1',
                    'borra' => '1',
                    'estado' => '1',
                ]
                // Agregar otros permisos según sea necesario
            ]);
        }
    }


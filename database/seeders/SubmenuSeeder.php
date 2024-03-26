<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Submenu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubmenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Desactivar claves foráneas temporalmente (solo si es necesario)
        // DB::statement('SET foreign_key_checks=0');

        // Obtener menús hijos
        $menuHijo = Menu::where('hijo', '=', 1)->first();

        if ($menuHijo) {
            // Eliminar submenús existentes
            Submenu::where('estado', '=', 1)->delete();

            // Insertar nuevos submenús
            Submenu::insert([
                [
                    'menu_id' => 1,
                    'descripcion' => 'Mantenimiento Usuarios',
                    'ruta' => 'user',
                    'orden' => 1,
                    'icono' => 'nav-icon fas fa-sharp fa-light fa-circle',
                ],
                [
                    'menu_id' => 1,
                    'descripcion' => 'Perfil Usuario',
                    'ruta' => 'profile',
                    'orden' => 2,
                    'icono' => 'nav-icon fas fa-sharp fa-light fa-circle',
                ],
                [
                    'menu_id' => 1,
                    'descripcion' => 'Permisos',
                    'ruta' => 'permisos',   
                    'orden' => 3,
                    'icono' => 'nav-icon fas fa-sharp fa-light fa-circle',
                ],
                [
                    'menu_id' => 2,
                    'descripcion' => 'Contratos',
                    'ruta' => 'contratoss',   
                    'orden' => 1,
                    'icono' => 'nav-icon fas fa-sharp fa-light fa-circle',
                ],
                [
                    'menu_id' => 3,
                    'descripcion' => 'Configuración',
                    'ruta' => 'configuracion',   
                    'orden' => 1,
                    'icono' => 'nav-icon fas fa-sharp fa-light fa-circle',
                ],
                [
                    'menu_id' => 3,
                    'descripcion' => 'Ejecutivos',
                    'ruta' => 'ejecutivos',   
                    'orden' => 2,
                    'icono' => 'nav-icon fas fa-sharp fa-light fa-circle',
                ]
            ]);
        }

        // Reactivar claves foráneas (solo si se desactivaron anteriormente)
        // DB::statement('SET foreign_key_checks=1');
    }
}

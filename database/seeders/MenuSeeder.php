<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Verificar si el usuario administrador existe
        $userAdmin = User::where('email', 'enrique.guzman.magna@gmail.com')->first();

        // Si el usuario administrador no existe, crearlo
        if (!$userAdmin) {
            $userAdmin = User::create([
                'id' => '1',
                'name' => 'Enrique Guzmán Magna',
                'email' => 'enrique.guzman.magna@gmail.com',
                'password' => bcrypt('admin'),
                'tipo_documento' => 'CDI',
                'num_documento' => '137316218',
                'email_verified_at' => '2021-10-25 10:58:15',
                'estado' => '1',
                'profile_id' => '1',
                'created_at' => '2021-10-25 11:42:09',
                // Otros campos del usuario
            ]);
        }

        // Eliminar todos los menús existentes
        Menu::truncate();

        // Crear nuevos menús
        Menu::insert([
            [
                'id' => 1,
                'descripcion' => 'Administración Usuarios',
                'orden' => 1,
                'icono' => 'nav-icon fas fa-user',
                'hijo' => 1,
                'ruta' => 'user',
            ],
            [
                'id' => 2,
                'descripcion' => 'Mantenedor',
                'orden' => 2,
                'icono' => 'nav-icon fas fa-wrench',
                'hijo' => 1,
                'ruta' => 'mantenedor',
            ]
        ]);
    }
}

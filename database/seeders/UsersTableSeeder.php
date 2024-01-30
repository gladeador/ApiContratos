<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use DB;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate tables postgres
        Profile::truncate();
        User::truncate();

        DB::table('profiles')->insert(array(
            [
                'id' => '1',
                'nombre' => 'Administrador',
                'descripcion' => 'Administrador',
            ],
            [
                'id' => '2',
                'nombre' => 'Operador',
                'descripcion' => 'Operador',
            ],
            [
                'id' => '3',
                'nombre' => 'Cliente',
                'descripcion' => 'Cliente',
            ]));

        DB::table('users')->insert(array(
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
        ));
    }
}

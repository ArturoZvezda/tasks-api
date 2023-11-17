<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;


class UsersSeeder extends Seeder
{
    public function run()
    {
        $model = new UserModel();

        // Datos de prueba para usuarios
        $data = [
            [
                'username' => 'usuario1',
                'email' => 'usuario1@example.com',
                'password' => 'password1', // La función hashPassword en UserModel se encargará de hashear la contraseña
                'status' => 'A', // Activo
            ],
            [
                'username' => 'usuario2',
                'email' => 'usuario2@example.com',
                'password' => 'password2',
                'status' => 'A',
            ],
            // Recordar que el campo status es obligatorio y el email debe ser único
            // Puedes agregar mas tomando en cuenta lo anterior
        ];

        foreach ($data as $user) {
            $model->insert($user);
        }
    }
}

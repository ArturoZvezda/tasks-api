<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use Firebase\JWT\JWT;

class AuthController extends BaseController
{
    use ResponseTrait;

    public function register()
    {
        // Recibe los datos del usuario desde la solicitud POST
        $userData = $this->request->getJSON(true);

        // Valida los datos recibidos
        if (empty($userData['username']) || empty($userData['password']) || empty($userData['email'])) {
            return $this->fail('Todos los campos son obligatorios', 400);
        }

        // Verifica si el usuario ya existe
        $userModel = new UserModel();
        $existingUser = $userModel->where('email', $userData['email'])->first();
        if (!empty($existingUser)) {
            return $this->fail('El usuario ya está registrado', 400);
        }

        // Hash de la contraseña antes de almacenarla en la base de datos
        $userData['status'] = 'A'; // Activo	

        // Inserta el nuevo usuario en la base de datos
        $userModel->insert($userData);

        return $this->respondCreated(['message' => 'Usuario registrado exitosamente']);
    }

    public function login()
    {
        // Recibe los datos del usuario desde la solicitud POST
        $userData = $this->request->getJSON(true);

        // Valida los datos recibidos
        if (empty($userData['password']) || empty($userData['email'])) {
            return $this->fail('El correo electrónico y la contraseña son obligatorios', 400);
        }

        // Busca al usuario en la base de datos por su correo electrónico
        $userModel = new UserModel();
        $user = $userModel->where('email', $userData['email'])->first();

        // Verifica si el usuario existe y la contraseña es correcta
        if (!empty($user) && password_verify($userData['password'], $user['password'])) {
            // Genera un token JWT
            $token = $this->generateJWT($user['id']);

            // Devuelve el token como respuesta
            return $this->respond(['token' => $token]);
        } else {
            return $this->failUnauthorized('Credenciales no válidas');
        }
    }

    // Genera un token JWT
    private function generateJWT($userId)
    {
        $jwtSecret = config('App')->jwtSecret;
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600; // Token válido por 1 hora

        $data = [
            'user_id' => $userId,
            'iat' => $issuedAt,
            'exp' => $expirationTime
        ];

        return JWT::encode($data, $jwtSecret, 'HS256');
    }
}

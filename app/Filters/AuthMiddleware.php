<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class AuthMiddleware implements FilterInterface
{
    public function before(\CodeIgniter\HTTP\RequestInterface $request, $arguments = null)
    {
        $jwtSecret = config('App')->jwtSecret;

        // Verifica si se ha proporcionado un token en la cabecera Authorization
        $token = $request->getHeaderLine('Authorization');

        if (empty($token)) {
            return service('response')
            ->setStatusCode(401)
            ->setJSON(['error' => 'Token no proporcionado']);
        }

        // Extrae el token del encabezado
        $token = str_replace('Bearer ', '', $token);

        try {
            // Verifica y decodifica el token
            $decodedToken = JWT::decode($token, new Key($jwtSecret, 'HS256'));
            $userId = $decodedToken->user_id;
            // Puedes agregar el user_id a la solicitud para su uso posterior
            $request->user_id = $userId;

            return $request;
        } catch (\Exception $e) {return service('response')
            ->setStatusCode(401)
            ->setJSON(['error' => 'Token no válido']);
        }
    }

    public function after(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, $arguments = null)
    {
        // Lógica después de la ejecución del controlador
    }
}

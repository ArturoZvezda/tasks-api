<?php

use CodeIgniter\Test\FeatureTestCase;
use CodeIgniter\Test\DatabaseTestTrait;


class AuthControllerTest extends FeatureTestCase
{
    use DatabaseTestTrait;

    // For Migrations
    protected $migrate     = true;
    protected $migrateOnce = true;

    public function testRegisterAndLogin()
    {
        // Simula el proceso de registro y obtención del token JWT
        $authToken = $this->simulateUserRegistration();

        // Simula el proceso de inicio de sesión utilizando el token obtenido
        $this->simulateUserLogin($authToken);
    }

    private function simulateUserRegistration()
    {
        // Datos de usuario para la prueba de registro
        $userData = [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'testpassword'
        ];

        // Realiza la solicitud de registro
        $headers = ['Content-Type' => 'application/json'];
        $result = $this->withHeaders($headers)->withBody(json_encode($userData))->post('/api/register');

        // Verifica que la respuesta sea exitosa
        $result->assertStatus(201);
        $resultArray = json_decode($result->getBody(), true);

        // Verifica que la respuesta contenga el mensaje esperado
        dd($result->getBody());
        $this->assertEquals('Usuario registrado exitosamente', $resultArray['message']);

        // Devuelve el token JWT obtenido en el registro
        return $this->getUserToken($userData['email'], $userData['password']);
    }

    private function simulateUserLogin($authToken)
    {
        // Datos de usuario para la prueba de inicio de sesión
        $userData = [
            'email' => 'test@example.com',
            'password' => 'testpassword'
        ];

        // Realiza la solicitud de inicio de sesión con el token obtenido en el registro
        $result = $this->post('/api/login', json_encode($userData), [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $authToken
        ]);

        // Verifica que la respuesta sea exitosa
        $result->assertStatus(200);
        $resultArray = json_decode($result->getBody(), true);

        // Verifica que la respuesta contenga el token JWT esperado
        $this->assertArrayHasKey('token', $resultArray);
        $this->assertNotEmpty($resultArray['token']);
    }

    // Función para obtener el token JWT después del registro
    private function getUserToken($email, $password)
    {
        // Realiza la solicitud de inicio de sesión para obtener el token
        $loginData = ['email' => $email, 'password' => $password];
        $result = $this->post('/api/login', json_encode($loginData), ['Content-Type' => 'application/json']);

        // Verifica que la respuesta sea exitosa
        $result->assertStatus(200);
        $resultArray = json_decode($result->getBody(), true);

        // Devuelve el token JWT obtenido en el inicio de sesión
        return $resultArray['token'];
    }
}

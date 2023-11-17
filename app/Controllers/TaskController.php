<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;

class TaskController extends Controller
{

    use ResponseTrait;

    public function create()
    {
        // Obtén los datos de la solicitud POST
        $title = $this->request->getPost('title');
        $description = $this->request->getPost('description');

        // Validación simple de datos (ajusta según tus necesidades)
        if (empty($title) || empty($description)) {
            return $this->fail('Todos los campos son obligatorios', 400);
        }

        // Inserta la tarea en la base de datos
        $model = new \App\Models\TaskModel();
        $data = [
            'title' => $title,
            'description' => $description,
            'status' => 'P',
            'user_id' => $this->request->user_id, // El id del usuario se obtiene del token validado en AuthMiddleware
        ];
        $model->insert($data);

        // Responde con un mensaje de éxito
        return $this->respondCreated(['message' => 'Tarea creada exitosamente']);
    }
}

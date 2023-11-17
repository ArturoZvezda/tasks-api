<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class TaskController extends Controller
{

    use ResponseTrait;

    public function createTask()
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
            'user_id' => 1
        ];
        $model->insert($data);

        // Responde con un mensaje de éxito
        return $this->respondCreated(['message' => 'Tarea creada exitosamente']);
    }
}

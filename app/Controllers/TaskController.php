<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;

/**
 * Crea una nueva tarea en la base de datos usando valores recibidos desde una solicitud POST
 * 
 * Valida al usuario usando el middleware AuthMiddleware
 * 
 * Sus rutas son accesibles desde /api/task
 * 
 * @property \CodeIgniter\HTTP\RequestInterface $request
 */
class TaskController extends Controller
{

    use ResponseTrait;

    public function create()
    {
        $title = $this->request->getPost('title');
        $description = $this->request->getPost('description');

        // Validación simple de datos
        if (empty($title) || empty($description)) {
            return $this->fail('Todos los campos son obligatorios', 400);
        }

        // Inserta la tarea en la base de datos
        $model = new \App\Models\TaskModel();
        $data = [
            'title' => $title,
            'description' => $description,
            'status' => 'P',
            'user_id' => $this->request->user_id, // El id del usuario (@see AuthMiddleware)
        ];
        $model->insert($data);

        return $this->respondCreated(['message' => 'Tarea creada exitosamente']);
    }
}

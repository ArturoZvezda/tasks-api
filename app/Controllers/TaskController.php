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

    public function index()
    {
        // Lista todas las tareas
        $model = new \App\Models\TaskModel();
        $tasks = $model->findAll();

        return $this->respond($tasks);
    }

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

        return $this->respondCreated(['message' => 'Tarea creada exitosamente'], 201);
    }

    public function update($id)
    {

        $model = new \App\Models\TaskModel();

        $task = $model->find($id);

        if (!$task) {
            return $this->failNotFound('Tarea no encontrada');
        }

        $title = $this->request->getPost('title');
        $description = $this->request->getPost('description');
        
        // Validación simple de datos
        if (empty($title) || empty($description)) {
            return $this->fail('Todos los campos son obligatorios', 400);
        }


        $data = [
            'title' => $title,
            'description' => $description,
        ];

        if ($model->update($id, $data)) {
            return $this->respondUpdated(['message' => 'Tarea actualizada exitosamente'], 200);
        } else {
            return $this->fail('No se pudo actualizar la tarea');
        }
    }

    public function delete($id)
    {
        // Elimina una tarea
        $model = new \App\Models\TaskModel();

        $task = $model->find($id);

        if (!$task) {
            return $this->failNotFound('Tarea no encontrada');
        }


        if ($model->delete($id)) {
            return $this->respondDeleted(['message' => 'Tarea eliminada exitosamente'], 200);
        } else {
            return $this->fail('No se pudo eliminar la tarea');
        }
    }   
}

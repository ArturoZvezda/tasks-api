<?php

use CodeIgniter\Test\FeatureTestCase;

class TaskControllerTest extends FeatureTestCase
{
    // Métodos de prueba van aquí

    public function testIndex()
    {
        $result = $this->get('/api/task'); // Ajusta la ruta según tu configuración de rutas

        $result->assertStatus(200);
        $result->assertJSON([]); // Ajusta esto según lo que esperas en tu base de datos de prueba
    }
    
    public function testCreate()
    {
        $data = [
            'title' => 'Nueva tarea',
            'description' => 'Descripción de la nueva tarea',
        ];
    
        $result = $this->post('/api/task', $data); // Ajusta la ruta según tu configuración de rutas
    
        $result->assertStatus(201);
        $result->assertJSON(['message' => 'Tarea creada exitosamente']); // Ajusta esto según el mensaje de éxito esperado
    }
    
    public function testUpdate()
{
    // Supongamos que tienes una tarea en la base de datos con ID 1
    $taskId = 1;
    
    $data = [
        'title' => 'Título actualizado',
        'description' => 'Descripción actualizada',
    ];

    $result = $this->post("/api/task/$taskId", $data); // Ajusta la ruta según tu configuración de rutas

    $result->assertStatus(200);
    $result->assertJSON(['message' => 'Tarea actualizada exitosamente']); // Ajusta esto según el mensaje de éxito esperado
}
public function testDelete()
{
    // Supongamos que tienes una tarea en la base de datos con ID 1
    $taskId = 1;

    $result = $this->delete("/api/task/$taskId"); // Ajusta la ruta según tu configuración de rutas

    $result->assertStatus(200);
    $result->assertJSON(['message' => 'Tarea eliminada exitosamente']); // Ajusta esto según el mensaje de éxito esperado
}

}

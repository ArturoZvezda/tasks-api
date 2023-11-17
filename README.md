# API de Gestión de Tareas

Esta API proporciona un conjunto de endpoints para la gestión de tareas, permitiendo a los usuarios crear, leer, actualizar y eliminar tareas en una base de datos.
Utiliza autenticacion mediante token estandar JWT generado utilizando una libreria de facto.

## Características

- Crear una tarea.
- Listar las tareas.
- Actualizar una tarea.
- Eliminar una tarea.

## Instalación

Se trata de una aplicacion en CodeIgniter 4, configurada originalmente para conectarse a una base de datos SQLSVR pero puede 
funcionar con otra si se cambia la configuracion en el archivo correspondiente.

1. Clona este repositorio en tu máquina local:

   ```bash
   git clone https://github.com/ArturoZvezda/tasks-api.git
   cd api-gestion-tareas
2. Instala las dependencias

   ```bash
   composer install

3. Configura el acceso a base de datos y ejecuta las migraciones


   ```bash
   php spark migrate

4. Ejecuta el seeder de usuarios


   ```bash
   php spark db:seed UsersSeeder

5. Para probar el API puedes usar el archivo ubicado en la carpeta /postman 

   

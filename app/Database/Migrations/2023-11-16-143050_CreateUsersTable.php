<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '120',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'unique' => true, // Esto hace que el campo sea único
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255', // Utilizamos 255 para almacenar el hash de la contraseña
            ],
            'status' => [
                'type' => 'CHAR',
                'constraint' => '1',
            ],
            'created_at datetime default current_timestamp'
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('users');
    }

    public function down()
    {
        //
        $this->forge->dropTable('users');
    }
}

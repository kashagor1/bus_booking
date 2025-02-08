<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNusers extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [ // It's good practice to have an 'id' primary key
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'unique' => true, // Add unique constraint for username
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'role_id' => [
                'type'       => 'varchar',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'fullname' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'unique' => true, // Add unique constraint for email
            ],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true); // Make 'id' the primary key
        $this->forge->createTable('nusers',true);
    }

    public function down()
    {
        $this->forge->dropTable('nusers');
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $forge = \Config\Database::forge();

        $fields = [
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
                'unique' => true, // Enforce unique usernames
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
        ];

        $forge->addField($fields);
        $forge->addKey('id', true);  // Primary key on 'id'
        $forge->createTable('users');
    }

    public function down()
    {
        $forge = \Config\Database::forge();
        $forge->dropTable('users');
    }
}
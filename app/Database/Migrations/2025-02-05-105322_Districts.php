<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Districts extends Migration
{
    public function up()
    {
        
        $forge = \Config\Database::forge();

        $fields = [
            'district_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'district_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
                'unique' => true, // Enforce unique usernames
            ]
        ];

        $forge->addField($fields);
        $forge->addKey('district_id', true);  // Primary key on 'id'
        $forge->createTable('district');
    }

    public function down()
    {
        $forge = \Config\Database::forge();
        $forge->dropTable('district');
    }
}

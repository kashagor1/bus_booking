<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRoutesTable extends Migration
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
            'route_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'company_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'or_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'route_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'fare' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'point_type' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
        ];

        $forge->addField($fields);
        $forge->addKey('id', true); // Primary key on 'id'
        $forge->addKey('company_id'); // Index on 'company_id'

        $forge->createTable('routes');
    }

    public function down()
    {
        $forge = \Config\Database::forge();
        $forge->dropTable('routes');
    }
}
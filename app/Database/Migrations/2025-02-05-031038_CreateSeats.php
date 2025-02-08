<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSeatsTable extends Migration
{
    public function up()
    {
        $forge = \Config\Database::forge();

        $fields = [
            'seat_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'coach_id' => [ // Foreign key to the coaches table
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'seat_no' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'status' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default' => 0, // 0 for available, 1 for booked, etc.
            ],
        ];

        $forge->addField($fields);
        $forge->addKey('seat_id', true);
        // Add foreign key constraint (important for relational integrity)

        $forge->createTable('seats');
    }

    public function down()
    {
        $forge = \Config\Database::forge();
        // Remove foreign key constraint before dropping the table (important!)
        $forge->dropTable('seats');
    }
}
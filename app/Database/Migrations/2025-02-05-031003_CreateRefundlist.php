<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRefundlistTable extends Migration
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
            'pnr' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'trip_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'seats' => [
                'type' => 'TEXT',
            ],
            'amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'origin' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'destination' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'j_date' => [
                'type' => 'DATE',
            ],
            'status' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default' => 0, // Set default value to 0
            ],
            'bkash' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null' => true,  // Allow NULL for bkash
            ],
        ];

        $forge->addField($fields);
        $forge->addKey('id', true);
        $forge->createTable('refundlist'); // Table name is "refundlist"
    }

    public function down()
    {
        $forge = \Config\Database::forge();
        $forge->dropTable('refundlist');
    }
}
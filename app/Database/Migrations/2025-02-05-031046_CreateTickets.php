<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTicketsTable extends Migration
{
    public function up()
    {
        $forge = \Config\Database::forge();

        $fields = [
            'id' => [ // Add an 'id' primary key (good practice)
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'pnr' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'unique' => true, // PNR should be unique
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'trip_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null' => true, // Allow trip_id to be NULL (if applicable)
            ],
            'source' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'destination' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'phone_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'seat_no' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'b_date' => [
                'type' => 'DATE',
            ],
            'fare' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
        ];

        $forge->addField($fields);
        $forge->addKey('id', true); // Primary key on 'id'
        $forge->createTable('tickets'); // Table name is "tickets"
    }

    public function down()
    {
        $forge = \Config\Database::forge();
        $forge->dropTable('tickets');
    }
}
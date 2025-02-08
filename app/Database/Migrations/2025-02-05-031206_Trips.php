<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTripsTable extends Migration
{
    public function up()
    {
        $forge = \Config\Database::forge();

        $fields = [
            'id' => [ // Primary key (good practice)
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'trip_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unique' => true, // Trip IDs should usually be unique
            ],
            'coach_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'departure_date' => [
                'type' => 'DATE',
            ],
            'trip_status' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default' => 0, // 0: Scheduled, 1: In Progress, 2: Completed, etc.
            ],
        ];

        $forge->addField($fields);
        $forge->addKey('id', true); // Primary key on 'id'

        $forge->createTable('trips');
    }

    public function down()
    {
        $forge = \Config\Database::forge();
        $forge->dropTable('trips');
    }
}
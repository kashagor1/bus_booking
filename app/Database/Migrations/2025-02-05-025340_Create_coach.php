<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Create_coach extends Migration
{
    public function up()
    {
        $fields = array(
            'coach_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'route_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE // Allow NULL values
            ),
            'coach_type' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ),
            'seat_row' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ),
            'seat_column' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ),
            'vehicle_number' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ),
            'supervisor_no' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ),
            'seat_layout' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ),
            'departure' => array(
                'type' => 'TIME',
                'null' => TRUE
            ),
            'arrival' => array(
                'type' => 'TIME',
                'null' => TRUE
            ),
            'main_boarding' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ),
            'final_destination' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ),
            'total_fare' => array(
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => TRUE
            )
        );
        $this->forge->addField($fields);
        $this->forge->addKey('coach_id', TRUE); // Make coach_id the primary key
        $this->forge->createTable('Coach', TRUE); // Create the table, IF NOT EXISTS
    }

    public function down()
    {
        $this->forge->dropTable('Coach', true);
    }
}

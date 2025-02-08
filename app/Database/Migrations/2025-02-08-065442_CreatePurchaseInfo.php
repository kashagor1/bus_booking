<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePurchaseInfo extends Migration
{
    public function up()
    {
          $fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'username' => array(
                'type' => 'varchar',
                'constraint' => '255',
            ),
            'pnr' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'booking_date' => array(
                'type' => 'DATE',
            ),
            'issue_date' => array(
                'type' => 'DATE',
            ));
        $this->forge->addField($fields);
        $this->forge->addKey('id', TRUE); // Make coach_id the primary key
        $this->forge->createTable('purchase_info', TRUE); // Create the table, IF NOT EXISTS
    }

    public function down()
    {
        $this->forge->dropTable('purchase_info', TRUE); // Drop the table, IF EXISTS
    }
}

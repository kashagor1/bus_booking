<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCompany extends Migration
{
    public function up()
    {
       
        $fields = [
            'company_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'company_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'company_phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'company_address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('company_id', true);  // Set company_id as primary key
        $this->forge->createTable('company',true); // Create the table named "companies"
    }

    public function down()
    {
        $this->forge->dropTable('company',true); // Drop the table
    }
}



<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CompanyUsers extends Migration
{
    public function up()
    {
        $fields = array(
            'company_user_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'company_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ),
            'user_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ),
            'role' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ),
            'created_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE
            ),
            'updated_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE
            )
        );

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('company_user_id'); // Alternative way of adding primary key
        $this->forge->createTable('company_users', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('company_users', TRUE);
    }
}

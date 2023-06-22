<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Applicants extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 30,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'vacancy_id' => [
                'type'           => 'INT',
                'constraint'     => 30,
                'unsigned'       => true,
            ],
            'first_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
            ],
            'middle_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
            ],
            'last_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
            ],
            'contact' => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
            ],
            'address' => [
                'type'       => 'TEXT',
            ],
            'status' => [
                'type'       => 'TINYINT',
                'constraint'       => '1',
                'default'       => 0,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('vacancy_id');
        $this->forge->addForeignKey('vacancy_id', 'vacancies','id', 'CASCADE', "NO ACTION");
        $this->forge->createTable('applicants');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('applicants');
    }
}

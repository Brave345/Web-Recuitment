<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Vacancies extends Migration
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
            'department_id' => [
                'type'           => 'INT',
                'constraint'     => 30,
                'unsigned'       => true,
            ],
            'position' => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
            ],
            'description' => [
                'type'       => 'TEXT',
            ],
            'slot' => [
                'type'       => 'INT',
                'constraint'       => '12',
                'default'       => 0,
            ],
            'salary_from' => [
                'type'       => 'FLOAT',
                'constraint'       => '12,2',
                'default'       => 0,
            ],
            'salary_to' => [
                'type'       => 'FLOAT',
                'constraint'       => '12,2',
                'default'       => 0,
            ],
            'status' => [
                'type'       => 'TINYINT',
                'constraint'       => '1',
                'default'       => 1,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('department_id');
        $this->forge->addForeignKey('department_id', 'departments','id', 'CASCADE', "NO ACTION");
        $this->forge->createTable('vacancies');
        $this->db->enableForeignKeyChecks();

    }

    public function down()
    {
        $this->forge->dropTable('vacancies');
    }
}

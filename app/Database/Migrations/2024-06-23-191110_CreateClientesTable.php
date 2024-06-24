<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClientesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'cpf_cnpj' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'nome_razao_social' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('clientes');

        $db = \Config\Database::connect();
        $builder = $db->table('clientes');

        $data = [
            'cpf_cnpj' => '12345678901',
            'nome_razao_social' => 'Admin',
            'password' => password_hash('Admin@123', PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $builder->insert($data);
    }

    public function down()
    {
        $this->forge->dropTable('clientes');
    }
}

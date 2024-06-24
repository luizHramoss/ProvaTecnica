<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePedidoItensTable extends Migration
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
            'pedido_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'produto_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'quantidade' => [
                'type' => 'INT',
                'constraint' => 5,
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
        $this->forge->addForeignKey('pedido_id', 'pedidos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('produto_id', 'produtos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pedido_itens');
    }

    public function down()
    {
        $this->forge->dropTable('pedido_itens');
    }
}


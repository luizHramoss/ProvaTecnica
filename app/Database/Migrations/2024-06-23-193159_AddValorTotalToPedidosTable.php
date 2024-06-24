<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddValorTotalToPedidosTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pedidos', [
            'valor_total' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pedidos', 'valor_total');
    }
}

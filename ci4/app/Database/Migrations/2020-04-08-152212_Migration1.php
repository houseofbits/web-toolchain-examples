<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration1 extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'product_type' => [
                'type'           => 'INT',
                'null'           => TRUE,
            ],
            'name' => [
                'type'           => 'TEXT',
                'null'           => TRUE,
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null'           => TRUE,
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
                'null'           => TRUE,
            ],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('product');
    }

    public function down()
    {
        $this->forge->dropTable('product');
    }
}

<?php namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class Services extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_layanan'   => ['type' => 'VARCHAR', 'constraint' => '100'],
            'deskripsi'      => ['type' => 'TEXT', 'null' => true],
            'harga'          => ['type' => 'INT', 'constraint' => 11],
            'estimasi_waktu' => ['type' => 'INT', 'constraint' => 11],
            'foto'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('services');
    }

    public function down()
    {
        $this->forge->dropTable('services');
    }
}
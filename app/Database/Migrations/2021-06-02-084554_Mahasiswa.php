<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Mahasiswa extends Migration
{
	public function up()
	{
		$this->forge->addField([
				
            'id'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'random'        => ['type' => 'varchar', 'constraint' => 40],
            'nim'           => ['type' => 'varchar', 'constraint' => 255],
            'nama'          => ['type' => 'varchar', 'constraint' => 255],
            'angkatan'      => ['type' => 'varchar', 'constraint' => 255],
            'prodi'         => ['type' => 'varchar', 'constraint' => 255],
            'fakultas'      => ['type' => 'varchar', 'constraint' => 255],
            'nim'           => ['type' => 'varchar', 'constraint' => 255],
            'created_at'    => ['type' => 'datetime', 'null' => true],
            'updated_at'    => ['type' => 'datetime', 'null' => true],
            'deleted_at'    => ['type' => 'datetime', 'null' => true],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('mahasiswa');
	}

	public function down()
	{
		//
		$this->forge->dropTable('mahasiswa');
	}
}

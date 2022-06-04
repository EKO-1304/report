<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JenisKelamin extends Migration
{
	public function up()
	{
		//
		$this->forge->addField([
				
            'id'               => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true],
            'random'           => ['type' => 'varchar', 'constraint' => 40],
            'jenis_kelamin'    => ['type' => 'varchar', 'constraint' => 255],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('jenis_kelamin');
	}

	public function down()
	{
		$this->forge->dropTable('jenis_kelamin');
	}
}

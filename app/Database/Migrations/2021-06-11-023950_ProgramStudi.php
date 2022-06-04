<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProgramStudi extends Migration
{
	public function up()
	{
		$this->forge->addField([
				
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'random'           => ['type' => 'varchar', 'constraint' => 40],
            'slug_prodi'       => ['type' => 'varchar', 'constraint' => 50],
            'nama_prodi'       => ['type' => 'varchar', 'constraint' => 50],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('program_studi');
	}

	public function down()
	{
		//
		$this->forge->dropTable('program_studi');
	}
}

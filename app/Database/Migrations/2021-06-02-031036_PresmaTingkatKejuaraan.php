<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PresmaTingkatKejuaraan extends Migration
{
	public function up()
	{
		$this->forge->addField([
				
            'id'               		   => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'random'           		   => ['type' => 'varchar', 'constraint' => 40],
            'slug_tingkat'       => ['type' => 'varchar', 'constraint' => 255],
            'nama_tingkat'       => ['type' => 'varchar', 'constraint' => 255],
            'draf'    	   	   		   => ['type' => 'int', 'constraint' => 5],
            'id_user'    	   		   => ['type' => 'varchar', 'constraint' => 11],
            'created_at'       		   => ['type' => 'datetime', 'null' => true],
            'updated_at'       		   => ['type' => 'datetime', 'null' => true],
            'deleted_at'       		   => ['type' => 'datetime', 'null' => true],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('presma_tingkat_kejuaraan');
	}

	public function down()
	{
		//
		$this->forge->dropTable('presma_tingkat_kejuaraan');
	}
}

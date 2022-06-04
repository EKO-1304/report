<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PresmaPkmReward extends Migration
{
	public function up()
	{
		$this->forge->addField([
				
            'id'               		   => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'random'           		   => ['type' => 'varchar', 'constraint' => 40],
            'prestasi'       		=> ['type' => 'varchar', 'constraint' => 50],
            'insentif'       			=> ['type' => 'varchar', 'constraint' => 11],
            'draf'    	   	   		   => ['type' => 'int', 'constraint' => 5],
            'id_user'    	   		   => ['type' => 'varchar', 'constraint' => 11],
            'created_at'       		   => ['type' => 'datetime', 'null' => true],
            'updated_at'       		   => ['type' => 'datetime', 'null' => true],
            'deleted_at'       		   => ['type' => 'datetime', 'null' => true],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('presma_pkm_reward');
	}

	public function down()
	{
		//
		$this->forge->dropTable('presma_pkm_reward');
	}
}

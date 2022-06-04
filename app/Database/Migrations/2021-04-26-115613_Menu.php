<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Menu extends Migration
{
	public function up()
	{
		//
		$this->forge->addField([
				
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'random'           => ['type' => 'varchar', 'constraint' => 40],
            'slug_menu'        => ['type' => 'varchar', 'constraint' => 255],
            'nama_menu'        => ['type' => 'varchar', 'constraint' => 255],
            'link_menu'     => ['type' => 'longtext'],
            'no_urut'      => ['type' => 'varchar', 'constraint' => 5],
            'status'    	   => ['type' => 'int', 'constraint' => 1],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('menu');
	}

	public function down()
	{
		//
		$this->forge->dropTable('menu');
	}
}

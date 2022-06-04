<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Content extends Migration
{
	public function up()
	{
		$this->forge->addField([
				
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'random'           => ['type' => 'varchar', 'constraint' => 40],
            'slug_content'     => ['type' => 'varchar', 'constraint' => 255],
            'nama_content'     => ['type' => 'varchar', 'constraint' => 255],
            'content'     	   => ['type' => 'longtext'],
            'id_user'    	   => ['type' => 'varchar', 'constraint' => 11],
            'thumbnail'    	   => ['type' => 'varchar', 'constraint' => 150],
            'draf'    	   	   => ['type' => 'int', 'constraint' => 5],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('content');
	}

	public function down()
	{
		//
		$this->forge->dropTable('content');
	}
}

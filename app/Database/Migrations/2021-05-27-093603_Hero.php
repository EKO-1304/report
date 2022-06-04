<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Hero extends Migration
{
	public function up()
	{
		///
		$this->forge->addField([
				
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'random'           => ['type' => 'varchar', 'constraint' => 40],
            'slug_hero'        => ['type' => 'varchar', 'constraint' => 255],
            'judul_hero'       => ['type' => 'varchar', 'constraint' => 255],
            'keterangan_hero'  => ['type' => 'varchar', 'constraint' => 255],
            'link_hero'    	   => ['type' => 'varchar', 'constraint' => 255],
            'url_youtube'  	   => ['type' => 'varchar', 'constraint' => 255],
            'id_user'    	   => ['type' => 'varchar', 'constraint' => 11],
            'image_hero'       => ['type' => 'varchar', 'constraint' => 255],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('hero');
	}

	public function down()
	{
		//
		$this->forge->dropTable('hero');
	}
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Blog extends Migration
{
	public function up()
	{
		//
		$this->forge->addField([
				
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'random'           => ['type' => 'varchar', 'constraint' => 40],
            'slug_blog'        => ['type' => 'varchar', 'constraint' => 255],
            'nama_blog'        => ['type' => 'varchar', 'constraint' => 255],
            'content_blog'     => ['type' => 'longtext'],
            'id_kategori'      => ['type' => 'varchar', 'constraint' => 255],
            'id_tags'    	   => ['type' => 'varchar', 'constraint' => 255],
            'id_user'    	   => ['type' => 'varchar', 'constraint' => 11],
            'thumbnail'    	   => ['type' => 'varchar', 'constraint' => 150],
            'draf'    	   	   => ['type' => 'int', 'constraint' => 5],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('blog');
	}

	public function down()
	{
		//
		$this->forge->dropTable('blog');
	}
}

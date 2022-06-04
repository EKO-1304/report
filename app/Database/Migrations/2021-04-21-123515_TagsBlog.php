<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TagsBlog extends Migration
{
	public function up()
	{
		//
		$this->forge->addField([
				
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'random'           => ['type' => 'varchar', 'constraint' => 40],
            'slug_tags'    => ['type' => 'varchar', 'constraint' => 255],
            'nama_tags'    => ['type' => 'varchar', 'constraint' => 255],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('tags_blog');
	}

	public function down()
	{
		//
		$this->forge->dropTable('tags_blog');
	}
}

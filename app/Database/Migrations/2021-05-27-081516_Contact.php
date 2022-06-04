<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Contact extends Migration
{
	public function up()
	{
		///
		$this->forge->addField([
				
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'random'           => ['type' => 'varchar', 'constraint' => 40],
            'slug_company'     => ['type' => 'varchar', 'constraint' => 255],
            'nama_company'     => ['type' => 'varchar', 'constraint' => 255],
            'alamat'    	   => ['type' => 'varchar', 'constraint' => 255],
            'email'    	   	   => ['type' => 'varchar', 'constraint' => 150],
            'google_maps'  	   => ['type' => 'varchar', 'constraint' => 150],
            'no_telp'    	   => ['type' => 'varchar', 'constraint' => 150],
            'id_user'    	   => ['type' => 'varchar', 'constraint' => 11],
            'logo_company'    	   => ['type' => 'varchar', 'constraint' => 150],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('contact');
	}

	public function down()
	{
		//
		$this->forge->dropTable('contact');
	}
}

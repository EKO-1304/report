<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProfileUser extends Migration
{

	public function up()
	{
			

		$this->forge->addField([
				
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'random'           => ['type' => 'varchar', 'constraint' => 40],
            'no_telp'          => ['type' => 'varchar', 'constraint' => 255],
            'jenis_kelamin'    => ['type' => 'varchar', 'constraint' => 2, 'null' => true],
            'tanggal_lahir'    => ['type' => 'date', 'null' => true],
            'alamat'           => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'kota'             => ['type' => 'varchar', 'constraint' => 255],
            'kode_kota'        => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'negara'           => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('profile_user');
	}

	public function down()
	{
		$this->forge->dropTable('profile_user');
	}
}

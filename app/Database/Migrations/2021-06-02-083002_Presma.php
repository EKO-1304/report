<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Presma extends Migration
{
	public function up()
	{
		$this->forge->addField([
				
            'id'               		   => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'random'           		   => ['type' => 'varchar', 'constraint' => 40],
            'nim'       			   => ['type' => 'varchar', 'constraint' => 50],
            'nama_kegiatan'       	   => ['type' => 'varchar', 'constraint' => 50],
            'kategori'                 => ['type' => 'varchar', 'constraint' => 225],
            'tanggal_kegiatan'         => ['type' => 'date'],
            'tingkat'			       => ['type' => 'varchar', 'constraint' => 11],
            'bidang'                   => ['type' => 'varchar', 'constraint' => 225],
            'pembimbing'               => ['type' => 'varchar', 'constraint' => 225],
            'penyelenggara'            => ['type' => 'varchar', 'constraint' => 225],
            'tempat'                   => ['type' => 'varchar', 'constraint' => 225],
            'jumlah_peserta'           => ['type' => 'varchar', 'constraint' => 11],
            'jumlah_pt'                => ['type' => 'varchar', 'constraint' => 11],
            'jumlah_negara'            => ['type' => 'varchar', 'constraint' => 11],
            'url'                      => ['type' => 'varchar', 'constraint' => 225],
            'deskripsi_kegiatan'       => ['type' => 'text'],
            'verifikasi'    	   	   => ['type' => 'int', 'constraint' => 5],
            'id_user'    	   		   => ['type' => 'varchar', 'constraint' => 11],
            'created_at'       		   => ['type' => 'datetime', 'null' => true],
            'updated_at'       		   => ['type' => 'datetime', 'null' => true],
            'deleted_at'       		   => ['type' => 'datetime', 'null' => true],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('presma');
	}

	public function down()
	{
		//
		$this->forge->dropTable('presma');
	}
}

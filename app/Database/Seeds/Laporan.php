<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class Laporan extends Seeder
{
	public function run()
	{
		
		$faker = \Faker\Factory::create('id_ID');


		for($i=1;$i < 1000;$i++){

			$rand = rand(1,3);

			if($rand == 1){
				$iduse = 167;				
			}elseif($rand == 2){
				$iduse = 168;
			}else{
				$iduse = 169;
			}
			
			$data = [
				'random'        => sha1($i.time().rand(00000,99999)),
				'broker'      => $faker->name,
				'pendamping'      => $faker->name,
				'namanasabah'      => $faker->name,
				'pekerjaan'      => $faker->jobTitle,
				'alamat'      => $faker->address,
				'hasil'      => $faker->text($maxNbChars = 200),
				'tanggal'	=> $faker->date($format = 'Y-m-d', $max = 'now'),
				'iduser'      => $iduse,
				'created_at'    => Time::createFromTimestamp($faker->unixTime()),
			];
			// Using Query Builder Insert
			$this->db->table('x_laporan')->insert($data);

			// Using Query Builder Update
			// $builder = $this->db->table('profile_user');
			// $builder->where('id',9);
			// $builder->update($data);
		}
	}
}

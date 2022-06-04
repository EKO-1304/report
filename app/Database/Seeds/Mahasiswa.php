<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class Mahasiswa extends Seeder
{
	public function run()
	{
		
		$faker = \Faker\Factory::create('id_ID');

		for($i=1;$i < 200;$i++){
			
			$data = [
				'random'        => sha1(time().rand(00000,99999)),
				'nim'      => $faker->isbn10,
				'nama'      => $faker->name,
				'angkatan'         => $faker->year($max = 'now'),
				'created_at'    => Time::createFromTimestamp($faker->unixTime()),
			];
			// Using Query Builder Insert
			$this->db->table('mahasiswa')->insert($data);

			// Using Query Builder Update
			// $builder = $this->db->table('profile_user');
			// $builder->where('id',9);
			// $builder->update($data);
		}
	}
}

<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class Presma extends Seeder
{
	public function run()
	{
		$db = \Config\Database::connect();
		$faker = \Faker\Factory::create('id_ID');

		
		$db = \Config\Database::connect();
		
		for($i=1;$i < 2000;$i++){

			$db->table('menu_group')
			->insert([
				'random'    => sha1(time().rand(00000,99999)),
				'nama_group' => $faker->name,
				'slug_group' => title(strtolower($faker->name)),
				'status' 	=> rand(0,1),
				'no_urut' 	=> $i,
				'created_at'=> date('Y-m-d h:i:s'),
			]);	

		}
	
	}
}

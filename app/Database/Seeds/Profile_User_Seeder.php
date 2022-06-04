<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class Profile_User_Seeder extends Seeder
{

        public function run()
        {
            $faker = \Faker\Factory::create('id_ID');

            for($i=2;$i < 100;$i++){
                
                $data = [
                        'id'            => $i,
                        'random'        => sha1(time().rand(00000,99999)),
                        'no_telp'       => $faker->e164PhoneNumber,
                        'jenis_kelamin' => '1',
                        'tanggal_lahir' => $faker->date(),
                        'alamat'        => $faker->address,
                        'kota'          => $faker->city,
                        'kode_kota'     => $faker->postcode,
                        'negara'        => $faker->country,
                        'created_at'    => Time::createFromTimestamp($faker->unixTime()),
                ];

                // Using Query Builder Insert
                $this->db->table('profile_user')->insert($data);

                // Using Query Builder Update
                // $builder = $this->db->table('profile_user');
                // $builder->where('id',9);
                // $builder->update($data);
            }

        }
}
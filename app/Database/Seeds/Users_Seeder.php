<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class Users_Seeder extends Seeder
{

        public function run()
        {
            $faker = \Faker\Factory::create('id_ID');

            for($i=1;$i < 2;$i++){
                
                $data = [
                    'random'        => sha1(time().rand(00000,99999)),
                    'email'         => $faker->email,
                    'username'      => $faker->username,
                    'fullname'      => $faker->name,
                    'user_image'    => 'default.jpg',
                    'password_hash' => password_hash("passwordsalah", PASSWORD_DEFAULT, ['cost' => 10]),
                    'active'        => 1,
                    'created_at'    => Time::createFromTimestamp($faker->unixTime()),
                    'update_at'     => Time::createFromTimestamp($faker->unixTime()),
                ];
                // Using Query Builder Insert
                $this->db->table('users')->insert($data);

                // Using Query Builder Update
                // $builder = $this->db->table('profile_user');
                // $builder->where('id',9);
                // $builder->update($data);
            }

        }
}
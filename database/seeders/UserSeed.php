<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Factory::create();

        for($i = 1; $i <= 22; $i ++){
            DB::table('users')->insert([
                'name' => $faker->name(),
                'email' => $faker->email(),
                'password' => bcrypt('futezada@123'),
                'telefone' => $faker->numberBetween($min = 10, $max = 99) . $faker->numberBetween($min = 10, $max = 99) .$faker->numberBetween($min = 10000, $max = 99999) . $faker->numberBetween($min = 1000, $max = 9999),
                'user_name' => '@futezada_'.$i,
                'foto' => '',
                'visibilidade' => true,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}

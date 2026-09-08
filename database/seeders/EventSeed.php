<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory;

class EventSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        //FUNÇÃO DE GERAÇÃO DE CATEGORIA
        function generateCategory($modality){
            $faker = Factory::create();
            switch ($modality) {
                case 'Football':
                    return $faker->randomElement(['Futebol','Fut7','Futsal']);
                case 'Volleyball':
                    return $faker->randomElement(['Volei','Volei de praia','Fut Volei']);
                case 'Basketball':
                    return $faker->randomElement(['Basquete','Streetball']);
            }
        }
        
        //FUNÇÃO DE GERAÇÃO DE CONFIGURAÇÕES
        function generateConfig($modality){
            $faker = Factory::create();
            switch ($modality) {
                case 'Football':
                    return [
                        "hasTwoHalves" => $faker->boolean,
                        "hasExtraTime" => $faker->boolean,
                        "hasPenalty" => $faker->boolean,
                        "hasGoalLimit" => $faker->boolean,
                        "hasRefereer" => $faker->boolean,
                        "extraTime" => $faker->numberBetween(0, 10),
                        "goalLimit" => $faker->numberBetween(0, 10),
                    ];
                case 'Voleyball':
                    return [
                        "sets" => $faker->numberBetween(0, 3),
                        "hasPointsLimit" => $faker->boolean,
                        "points" => $faker->numberBetween(0, 25),
                        "hasTieBreak" => $faker->boolean,
                        "tieBreakPoints" => $faker->numberBetween(0, 15),
                    ];
                case 'Basketball':
                    return [
                        "quarters" => $faker->numberBetween(0, 4),
                        "hasExtraTime" => $faker->numberBetween(0, 4),
                        "extraTime" => $faker->numberBetween(0, 4),
                        "hasPointsLimit" => $faker->boolean,
                        "points" => $faker->numberBetween(0, 10),
                    ];
            }
        }

        //FUNÇÃO DE DEFINIÇÃO DE DATA
        function getDate(){
            $week = ['dom','seg','ter','qua','qui','sex','sab'];
            $faker = Factory::create();
            $count = $faker->numberBetween(0, 6);
            $arr = [];
            for ($i = 0; $i <= $count; $i++) { 
                $arr[] = $week[$i];
            } 
            return json_encode($arr);
        }

        // Fotos de eventos por modalidade do Unsplash
        $eventPhotos = [
            'Football' => [
                'https://images.unsplash.com/photo-1575361204480-aadea25e6e68?w=640&h=400&fit=crop&q=80',
                'https://images.unsplash.com/photo-1517649763962-0c623066013b?w=640&h=400&fit=crop&q=80',
                'https://images.unsplash.com/photo-1579952363873-27f3bade9f55?w=640&h=400&fit=crop&q=80',
                'https://images.unsplash.com/photo-1540747913346-19c4323153af?w=640&h=400&fit=crop&q=80',
                'https://images.unsplash.com/photo-1560272564-d037ef0e2dc1?w=640&h=400&fit=crop&q=80',
                'https://images.unsplash.com/photo-1553778263-73a83bab9b0c?w=640&h=400&fit=crop&q=80',
            ],
            'Basketball' => [
                'https://images.unsplash.com/photo-1546519638405-a2d03ae8ef09?w=640&h=400&fit=crop&q=80',
                'https://images.unsplash.com/photo-1489944440615-453fc2b6a9a9?w=640&h=400&fit=crop&q=80',
                'https://images.unsplash.com/photo-1504450758481-7338eba7524a?w=640&h=400&fit=crop&q=80',
                'https://images.unsplash.com/photo-1518063319789-7217e6706b04?w=640&h=400&fit=crop&q=80',
            ],
            'Volleyball' => [
                'https://images.unsplash.com/photo-1552674605-db6ffd4facb5?w=640&h=400&fit=crop&q=80',
                'https://images.unsplash.com/photo-1612872087720-bb876e2e67d1?w=640&h=400&fit=crop&q=80',
                'https://images.unsplash.com/photo-1625929088-f4e5bf0b4723?w=640&h=400&fit=crop&q=80',
                'https://images.unsplash.com/photo-1547347298-4074fc3086f0?w=640&h=400&fit=crop&q=80',
            ],
        ];

        for($i = 1; $i <= 50; $i ++){
            //GERAR MODALIDADE DO EVENTO
            $modality = $faker->randomElement(['Football','Volleyball','Basketball']);
            //SORTEAR FOTO DA MODALIDADE
            $modalityPhotos = $eventPhotos[$modality];
            $eventPhoto = $modalityPhotos[array_rand($modalityPhotos)];
            //GERAR EVENTO
            DB::table('events')->insert([
                "uuid" => (string) Str::uuid(),
                'title' => $faker->jobTitle,
                'bio' => $faker->text($faker->numberBetween(100, 255)),
                'date' => getDate(),
                'start_time' => $faker->dateTimeBetween("15:00", "19:00")->format("H:i"),
                'end_time' => $faker->dateTimeBetween("19:00", "23:00")->format("H:i"),
                'modality' => $modality,
                'collaborators' => $faker->boolean,
                'photo' => $eventPhoto,
                'privacy' => $faker->boolean,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
            //GERAR CONFIGURAÇÕES DE PARTIDA DO EVENTO
            DB::table('game_configs')->insert([
                "event_id" => $i,
                "category" => generateCategory($modality),
                "duration" => $faker->numberBetween(5, 45),
                "players_per_team" => $faker->numberBetween(4, 11),
                "config" => json_encode(generateConfig($modality)),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}

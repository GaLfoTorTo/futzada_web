<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Factory::create();
        $modalityes = ["Football", "Basketball", "Volleyball"];
        $roles = ["Organizator", "Colaborator", "Refereer", "Player", "Manager"];

        function getModalities(){
            $faker = Factory::create();
            $modalityes = ["Football", "Basketball", "Volleyball"];
            $count = $faker->numberBetween(0, 2);
            $arr = [];
            for ($i = 0; $i <= $count; $i++) { 
                $arr[] = $modalityes[$i];
            } 
        }

        // Fotos de perfil reais do Unsplash
        $userPhotos = [
            'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1527980965255-d3b416303d12?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1519345182560-3f2917c472ef?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1463453091185-61582044d556?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1547425260-76bcadfb4f2c?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1552058544-f2b08422138a?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1489424731084-a5d8b219a5bb?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1499952127939-9bbf5af6c51c?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1542909168-82c3e7fdca5c?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1554151228-14d9def656e4?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1590086782792-42dd2350140d?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1601412436009-d964bd02edbc?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1521119989659-a83eee488004?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1548142813-c348350df52b?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1546961342-ea5f62d5a27b?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1525735765456-7f67dc8eabbb?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1603415526960-f7e0328c63b1?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1511485977113-f34c92461ad9?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1540569014015-19a7be504e3a?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1568602471122-7832951cc4c5?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1556157382-97eda2f9e2bf?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1623582854588-d60de57fa33f?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1614283233556-f35b0c801ef1?w=200&h=200&fit=crop&q=80',
            'https://images.unsplash.com/photo-1628157588553-5eeea00af15c?w=200&h=200&fit=crop&q=80',
        ];

        $formations = [
            'Futebol' => [
            '4-3-3',
            '4-1-2-3',
            '4-2-1-3',
            '4-2-3-1',
            '4-4-2',
            '3-4-3',
            '3-2-4-1',
            '3-4-2-1',
            '5-3-2',
            '5-4-1',
            ],
            'Fut7' => [
            '3-1-2',
            '3-2-1',
            '3-0-3',
            '2-1-3',
            '2-1-2-1',
            '2-2-2',
            '2-3-1',
            '1-4-1',
            '1-3-2',
            '1-2-3',
            ],
            'Futsal' => [
            '2-0-2',
            '2-1-1',
            '1-2-1',
            '1-3',
            '1-1-2',
            ],
            'Basquete' => [
            '2-3',
            '3-2',
            '1-3-1',
            '2-1-2',
            '1-2-2',
            '2-2-1',
            ],
            'Streetball' => [
            '1-1',
            '2-1',
            '1-2',
            ],
            'Volei' => [
            '3-3',
            '2-2-2',
            '1-4-1',
            '2-3-1',
            '3-2-1',
            ],
            'Volei de praia' => [
            '1-1',
            '2-1',
            '1-2',
            ],
            'Fut Volei' => [
            '1-1',
            '2-1',
            '1-2',
            ],
        ];

        // Tarefas iniciais criadas para todo novo usuário ao cadastro
        $initialTaskIds = DB::table('tasks')
            ->whereIn('category', ['onboarding', 'player', 'manager', 'participation', 'organization', 'social'])
            ->pluck('id');

        $p = 0;
        $m = 0;

        for($i = 1; $i <= 100; $i ++){

            //GERAR IDS DO EVENTO
            $events = $faker->numberBetween(1, 10);
            $isPlayer = $faker->boolean;
            $isManager = $faker->boolean;
            $isParaticipant = $faker->boolean;

            //GERAR USUARIO
            DB::table("users")->insert([
                "uuid" => (string) Str::uuid(),
                "first_name" => $faker->firstName,
                "last_name" => $faker->lastName,
                "user_name" => $faker->name,
                "email" => $faker->email,
                "password" => bcrypt("esportly@123"),
                "born_date" => $faker->dateTimeBetween("-50 years", "-18 years")->format("Y-m-d"),
                "phone" => $faker->phoneNumber,
                "photo" => $userPhotos[array_rand($userPhotos)],
                "privacy" => $faker->boolean,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
            ]);
            //GERAR CONFIGURAÇÕES DE USUARIO
            DB::table('user_configs')->insert([
                "user_id" => $i,
                "main_modality" => $faker->randomElement($modalityes),
                "modalities" => getModalities()
            ]);
            //GERAR VINCULO DE LEVEL DO USUARIO
            DB::table('user_levels')->insert([
                "user_id" => $i,
                "level_id" => 1,
                "points" => 0,
            ]);
            //GERAR TASKS DO USUARIO
            DB::table('user_tasks')->insert($initialTaskIds->map(fn ($taskId) => [
                'user_id'      => $i,
                'task_id'      => $taskId,
                'completed'    => false,
                'completed_at' => null,
                'created_at'   => date("Y-m-d H:i:s"),
                'updated_at'   => date("Y-m-d H:i:s"),
            ])->values()->all());
            
            //GERAR ACHIVMENTS DO USUARIO
            for ($a = 1; $a <= $faker->numberBetween(1, 10); $a++) { 
                DB::table('user_achievements')->insert([
                    'user_id' => $i,
                    'achievement_id' => $a,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ]);
            }

            //GERAR DADOS DE PLAYER DO USUARIO
            if($isPlayer){
                //INCREMENTAR ID DO PLAYER
                $p ++;
                //CRIAR PLAYER
                DB::table('players')->insert([
                    "user_id" => $i,
                    "number" => $faker->numberBetween(1, 99),
                    "best_side" => $faker->boolean() ? "right" : "left",
                    "type" => $faker->company,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ]);
                $player = DB::table('players')->where('id', $p)->first();
                if(!empty($player)){
                    $modalityPositionRanges = [
                        'Football'   => [1, 5],
                        'Volleyball' => [6, 10],
                        'Basketball' => [11, 15],
                    ];
                    foreach($modalityPositionRanges as $item){
                        $qtd = $faker->numberBetween($item[0], $item[1]);
                        for($pos = $item[0]; $pos <= $qtd; $pos++){
                            $main = $pos <= $item[0];
                            $playerModality = $faker->randomElement($modalityes);
                            [$minPos, $maxPos] = $modalityPositionRanges[$playerModality];
                            DB::table('player_positions')->insert([
                                "player_id" => $p,
                                "position_id" => $pos,
                                "main" => $main,
                                'created_at' => date("Y-m-d H:i:s"),
                                'updated_at' => date("Y-m-d H:i:s"),
                            ]);
                        }
                    }
                }
            }

            //GERAR DADOS DE MANAGER DO USUARIO
            if($isManager) {
                //INCREMENTAR MANAGER
                $m++;
                //CRIAR MANAGER
                DB::table('managers')->insert([
                    "user_id" => $i,
                    'team' => $faker->jobTitle,
                    'alias' => substr($faker->jobTitle, 0, 3),
                    'primary' => $faker->randomElement(["green_300","blue_500","red_300","yellow_300","orange_300","purple_300","dark_300","white"]),
                    'secondary' => $faker->randomElement(["green_300","blue_500","red_300","yellow_300","orange_300","purple_300","dark_300","white"]),
                    'emblem' => json_encode(
                        $faker->randomElement([
                            "emblema_1","emblema_2","emblema_3",
                            "emblema_4","emblema_5","emblema_6","emblema_7"
                        ])
                    ),
                    'uniform' => null,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ]);
            }
            
            //LOOP NOS EVENTOS
            for ($e = 1; $e <= $events ; $e++) {
                //PULAR CASO NÃO SEJA PARTICIPANT
                if($isParaticipant){
                    $pRoles = $faker->randomElements($roles, $faker->numberBetween(1, count($roles)));

                    //GERAR PARTICIPANT (EVENTS)
                    DB::table('participants')->insert([
                        'event_id' => $e,
                        'user_id' => $i,
                        'roles' => json_encode($pRoles),
                        'status' => $faker->randomElement(['Avaliable','Doubt','None','Out']),
                        'permissions' => null,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s"),
                    ]);
                    
                    //GERAR RATING DE JOGADOR NO EVENTO
                    if($isPlayer && in_array('Player', $pRoles)){
                        $player = DB::table('players')->where('id', $p)->first();
                        if(!empty($player)){
                            //GERAR RATING DE PLAYER (SE USUARIO FOR PLAYER)
                            DB::table('ratings')->insert([
                                'user_id' => $i,
                                'event_id' => $e,
                                'role' => 'Player',
                                'points' => $faker->randomFloat(2, 0, 25),
                                'avarage' => $faker->randomFloat(2, 0, 25),
                                'valuation' => $faker->randomFloat(2, 0, 25),
                                'price' => $faker->randomFloat(2, 0, 25),
                                'games' => $faker->numberBetween(0, 50),
                                'created_at' => date("Y-m-d H:i:s"),
                                'updated_at' => date("Y-m-d H:i:s"),
                            ]);
                        }
                    }

                    //GERAR RATING DE MANAGER NO EVENTO
                    if($isManager && in_array('Manager', $pRoles)){
                        $manager = DB::table('managers')->where('id', $m)->first();
                        if(!empty($manager)){
                            $config = DB::table('game_configs')->where('event_id', $e)->first();
                            
                            //GERAR RATING DE MANAGER (SE USUARIO FOR MANAGER)
                            DB::table('ratings')->insert([
                                'user_id' => $i,
                                'event_id' => $e,
                                'role' => 'Manager',
                                'points' => $faker->randomFloat(2, 0, 25),
                                'avarage' => $faker->randomFloat(2, 0, 25),
                                'valuation' => $faker->randomFloat(2, 0, 25),
                                'price' => $faker->randomFloat(2, 0, 25),
                                'games' => $faker->numberBetween(0, 50),
                                'created_at' => date("Y-m-d H:i:s"),
                                'updated_at' => date("Y-m-d H:i:s"),
                            ]);

                            //GERAR ECONOMY (MANAGER)
                            DB::table('economies')->insert([
                                'manager_id' => $manager->id,
                                'event_id' => $e,
                                'patrimony' => $faker->randomFloat(2, 0, 25),
                                'price' => $faker->randomFloat(2, 0, 25),
                                'price' => $faker->randomFloat(2, 0, 25),
                                'valuation' => $faker->randomFloat(2, 0, 25),
                                'points' => $faker->randomFloat(2, 0, 25),
                                'total_points' => $faker->randomFloat(2, 0, 25),
                                'created_at' => date("Y-m-d H:i:s"),
                                'updated_at' => date("Y-m-d H:i:s"),
                            ]);

                            //GERAR ECONOMY (MANAGER)
                            DB::table('escalations')->insert([
                                'manager_id' => $manager->id,
                                'event_id' => $e,
                                'formation' => $faker->randomElement($formations[$config->category]),
                                'starters' => json_encode([]),
                                'reserves' => json_encode([]),
                                'created_at' => date("Y-m-d H:i:s"),
                                'updated_at' => date("Y-m-d H:i:s"),
                            ]);
                        }
                    }
                }
            }
        }
    }
}
<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //ESTRUTURA
        $this->call(PositionSeed::class);
        $this->call(TaskSeed::class);
        $this->call(LevelSeed::class);
        $this->call(ActionSeed::class);
        $this->call(GameEvenTypeSeed::class);
        $this->call(EventNewsSeed::class);
        $this->call(AchievementSeed::class);
        //DADOS
        $this->call(EventSeed::class);
        $this->call(UserSeed::class);
        //$this->call(AddressSeed::class);
    }
}

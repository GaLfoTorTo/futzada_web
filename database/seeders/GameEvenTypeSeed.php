<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameEvenTypeSeed extends Seeder
{
    public function run(): void
    {
        // Resolve action IDs dynamicamente para não depender de ordem de inserção
        $actionId = fn(string $title): ?int => DB::table('actions')->where('title', $title)->value('id');

        DB::table('game_event_types')->insert([

            // ----------------------------------------------------------------
            // Eventos de controle de partida (sem pontuação)
            // ----------------------------------------------------------------
            ['title' => 'StartGame',       'action_id' => null],
            ['title' => 'EndGame',         'action_id' => null],
            ['title' => 'HalfTimeStart',   'action_id' => null],
            ['title' => 'HalfTimeEnd',     'action_id' => null],
            ['title' => 'ExtraTime',       'action_id' => null],
            ['title' => 'ExtraTimeStart',  'action_id' => null],
            ['title' => 'ExtraTimeEnd',    'action_id' => null],
            ['title' => 'Penalties',       'action_id' => null],
            ['title' => 'GoalKick',        'action_id' => null],
            ['title' => 'Substitution',    'action_id' => null],
            ['title' => 'Injury',          'action_id' => null],
            ['title' => 'VARCheck',        'action_id' => null],
            ['title' => 'Timeout',         'action_id' => null],
            ['title' => 'SetStart',        'action_id' => null],
            ['title' => 'SetEnd',          'action_id' => null],
            ['title' => 'QuarterStart',    'action_id' => null],
            ['title' => 'QuarterEnd',      'action_id' => null],

            // ----------------------------------------------------------------
            // Football — ataque
            // ----------------------------------------------------------------
            ['title' => 'Goal',            'action_id' => $actionId('Goal')],
            ['title' => 'Assist',          'action_id' => $actionId('Assist')],
            ['title' => 'ShotOnPost',      'action_id' => $actionId('ShotOnPost')],
            ['title' => 'ShotSaved',       'action_id' => $actionId('ShotSaved')],
            ['title' => 'ShotMissed',      'action_id' => $actionId('ShotMissed')],
            ['title' => 'FoulTaken',       'action_id' => $actionId('FoulTaken')],

            // ----------------------------------------------------------------
            // Football — defesa
            // ----------------------------------------------------------------
            ['title' => 'Defense',         'action_id' => $actionId('Defense')],
            ['title' => 'CleanSheet',      'action_id' => $actionId('CleanSheet')],
            ['title' => 'PenaltySave',     'action_id' => $actionId('PenaltySave')],
            ['title' => 'GoalkeeperSave',  'action_id' => $actionId('GoalkeeperSave')],
            ['title' => 'GoalkeeperFail',  'action_id' => $actionId('GoalkeeperFail')],

            // ----------------------------------------------------------------
            // Football — ações complementares
            // ----------------------------------------------------------------
            ['title' => 'Penalty',         'action_id' => $actionId('Penalty')],
            ['title' => 'PenaltyMissed',   'action_id' => $actionId('PenaltyMissed')],
            ['title' => 'FreeKick',        'action_id' => $actionId('FreeKick')],
            ['title' => 'Corner',          'action_id' => $actionId('Corner')],
            ['title' => 'Offside',         'action_id' => $actionId('Offside')],
            ['title' => 'Foul',            'action_id' => $actionId('Foul')],
            ['title' => 'WrongPass',       'action_id' => $actionId('WrongPass')],
            ['title' => 'OwnGoal',         'action_id' => $actionId('OwnGoal')],
            ['title' => 'RedCard',         'action_id' => $actionId('RedCard')],
            ['title' => 'YellowCard',      'action_id' => $actionId('YellowCard')],

            // ----------------------------------------------------------------
            // Basketball
            // ----------------------------------------------------------------
            ['title' => 'Point2',          'action_id' => $actionId('Point2')],
            ['title' => 'Point3',          'action_id' => $actionId('Point3')],
            ['title' => 'BasketAssist',    'action_id' => $actionId('BasketAssist')],
            ['title' => 'Rebound',         'action_id' => $actionId('Rebound')],
            ['title' => 'Steal',           'action_id' => $actionId('Steal')],
            ['title' => 'BlockShot',       'action_id' => $actionId('BlockShot')],
            ['title' => 'Turnover',        'action_id' => $actionId('Turnover')],
            ['title' => 'PersonalFoul',    'action_id' => $actionId('PersonalFoul')],

            // ----------------------------------------------------------------
            // Volleyball
            // ----------------------------------------------------------------
            ['title' => 'Ace',             'action_id' => $actionId('Ace')],
            ['title' => 'Point',           'action_id' => $actionId('Point')],
            ['title' => 'Block',           'action_id' => $actionId('Block')],
            ['title' => 'DefensiveSave',   'action_id' => $actionId('DefensiveSave')],
            ['title' => 'ServingError',    'action_id' => $actionId('ServingError')],
            ['title' => 'Fault',           'action_id' => $actionId('Fault')],
        ]);
    }
}

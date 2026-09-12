<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Uma imagem por tier, do mais iniciante ao mais alto
        $tierImages = [
            'Iniciante'  => 'https://images.unsplash.com/photo-1526676037777-05a232554f77?w=200&h=200&fit=crop&q=80',
            'Peladeiro'  => 'https://images.unsplash.com/photo-1431324155629-1a6deb1dec8d?w=200&h=200&fit=crop&q=80',
            'Várzea'     => 'https://images.unsplash.com/photo-1529900748604-07564a03e7a6?w=200&h=200&fit=crop&q=80',
            'Amador'     => 'https://images.unsplash.com/photo-1575361204480-aadea25e6e68?w=200&h=200&fit=crop&q=80',
            'Semi-Pro'   => 'https://images.unsplash.com/photo-1546519638405-a2d03ae8ef09?w=200&h=200&fit=crop&q=80',
            'Pro'        => 'https://images.unsplash.com/photo-1552674605-db6ffd4facb5?w=200&h=200&fit=crop&q=80',
            'Craque'     => 'https://images.unsplash.com/photo-1579952363873-27f3bade9f55?w=200&h=200&fit=crop&q=80',
            'Estrela'    => 'https://images.unsplash.com/photo-1567427017-8a5bcb89caab?w=200&h=200&fit=crop&q=80',
            'Lenda'      => 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=200&h=200&fit=crop&q=80',
            'Rei'        => 'https://images.unsplash.com/photo-1548771006-b8f9eabf0c91?w=200&h=200&fit=crop&q=80',
        ];

        $tiers = [
            'Iniciante',
            'Peladeiro',
            'Várzea',
            'Amador',
            'Semi-Pro',
            'Pro',
            'Craque',
            'Estrela',
            'Lenda',
            'Rei'
        ];

        $roman = ['I','II','III','IV','V'];

        $color = ["green","cyan","blue","purple","red","orange","yellow","grey","white","dark"];

        $levels = [];
        $xpTotal = 0;

        for ($i = 1; $i <= 100; $i++) {

            // RESGATAR ROMANO
            $tierIndex = floor(($i - 1) / 10);
            $tierName = $tiers[$tierIndex];

            //POSIÇÃO DO TIER
            $indexInTier = ($i - 1) % 10;

            //ROMANO OCUPA 2 POSIÇÕES
            $romanIndex = floor($indexInTier / 2);

            $title = $tierName . ' ' . $roman[$romanIndex];

            //CURVA DE XP
            if ($i <= 30) {
                $xpRequired = (int)(80 * pow($i, 1.5));
            } elseif ($i <= 70) {
                $xpRequired = (int)(100 * pow($i, 1.7));
            } else {
                $xpRequired = (int)(120 * pow($i, 2.0));
            }

            $xpTotal += $xpRequired;

            $levels[] = [
                'number' => $i,
                'tier' => $tierName,
                'title' => $title,
                'points_min' => $xpRequired,
                'points_max' => $xpTotal,
                'image' => $tierImages[$tierName],
                'color' => $color[$romanIndex],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('levels')->insert($levels);
    }
}

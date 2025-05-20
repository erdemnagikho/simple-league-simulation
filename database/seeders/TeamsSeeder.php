<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class TeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        smartCache()->del(Team::ALL_TEAMS_CACHE_KEY);

        $teams = [
            [
                'name' => 'Liverpool',
                'slug' => Str::slug('Liverpool'),
                'strength' => 4,
            ],
            [
                'name' => 'Manchester City',
                'slug' => Str::slug('Manchester City'),
                'strength' => 3,
            ],
            [
                'name' => 'Chelsea',
                'slug' => Str::slug('Chelsea'),
                'strength' => 2,
            ],
            [
                'name' => 'Arsenal',
                'slug' => Str::slug('Arsenal'),
                'strength' => 1,
            ]
        ];

        foreach ($teams as $team) {
            Team::query()
                ->create([
                    'name' => $team['name'],
                    'slug' => $team['slug'],
                    'strength' => $team['strength'],
                ]);
        }
    }
}

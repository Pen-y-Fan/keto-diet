<?php

declare(strict_types=1);

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        \App\Models\Food::factory(10)->create([
            'date' => Carbon::now()->startOfDay()->add('hours', 6),
        ]);
    }
}

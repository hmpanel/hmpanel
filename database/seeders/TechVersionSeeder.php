<?php

namespace Database\Seeders;

use App\Models\TechVersion;
use Illuminate\Database\Seeder;

class TechVersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TechVersion::factory()
            ->count(5)
            ->create();
    }
}

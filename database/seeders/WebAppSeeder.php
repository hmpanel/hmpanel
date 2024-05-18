<?php

namespace Database\Seeders;

use App\Models\WebApp;
use Illuminate\Database\Seeder;

class WebAppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WebApp::factory()
            ->count(5)
            ->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\SshAccess;
use Illuminate\Database\Seeder;

class SshAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SshAccess::factory()
            ->count(5)
            ->create();
    }
}

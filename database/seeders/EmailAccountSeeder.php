<?php

namespace Database\Seeders;

use App\Models\EmailAccount;
use Illuminate\Database\Seeder;

class EmailAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmailAccount::factory()
            ->count(5)
            ->create();
    }
}

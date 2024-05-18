<?php

namespace Database\Seeders;

use App\Models\FtpAccount;
use Illuminate\Database\Seeder;

class FtpAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FtpAccount::factory()
            ->count(5)
            ->create();
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')
            ->whereIn('name', ['Super Admin', 'petugas']) // adjust if your role field is named differently
            ->update(['theme' => 'nord']);

    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
       public function run(): void
    {
        $settings = [
            ['key' => 'commission_rate', 'value' => '0.10'], // نسبة المنصة 10%
            ['key' => 'publisher_rate', 'value' => '0.90'],  // نسبة الناشر 90%
            ['key' => 'minimum_withdraw', 'value' => '50'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}

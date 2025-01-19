<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $this->create_admin();
    }
    private function create_admin(): void
    {
        Log::info('............... AdminSeeder run started ...............');

        // Admin user setup
        $adminUser = User::updateOrCreate(['email' => 'admin@squ.com'], [
            'name' => [
                'en' => 'Admin',
                'ar' => 'Admin',
            ],
            'mobile' => '0000',
            'password' => Hash::make('admin'),
            'active' => true,
        ]);
        $adminUser->assignRole('super-admin');
        Log::info('Admin user saved and role assigned', ['user_id' => $adminUser->id]);

        Log::info('AdminSeeder run completed');
    }
}

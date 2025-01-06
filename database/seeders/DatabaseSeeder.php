<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            ConstantsTableSeederV4::class,
            RolesAndPermissionsSeeder::class,
            AdminSeeder::class,
            // QuestionnaireTypes::class,
            //CountrySeeder::class,
            //CitySeeder::class,
            MenuSeeder::class,
            // RestaurantSeeder::class,
            //CaptinSeeder::class,
            // BranchesSeeder::class,
            //IdentityCardTypes::class,
            // AttachmentSeeder::class,
            //CallOptionSeeder::class,
            //Employee::class,
            //ShortMessageTypeSeeder::class,

        ]);
    }
}

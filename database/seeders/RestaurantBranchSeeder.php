<?php

namespace Database\Seeders;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Models\Constant;
use App\Models\RestaurantBranch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantBranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $RESTAURANT_BRANCHES = [
            ['name' => 'Ramallah', 'value' => '295', 'module' => Modules::Customer, 'field' => DropDownFields::RESTAURANT_BRANCHES],
            ['name' => 'Beit Hanina', 'value' => '145', 'module' => Modules::Customer, 'field' => DropDownFields::RESTAURANT_BRANCHES],
        ];

        foreach ($RESTAURANT_BRANCHES as $value) {
            RestaurantBranch::updateOrCreate($value);
        }

        $this->command->info('RESTAURANT_BRANCHES Seeded successfully!');
    }
}

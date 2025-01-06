<?php

namespace Database\Seeders;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Models\Constant;
use App\Models\RestaurantBranch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Employee extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'CheckIn', 'value' => '1', 'module' => Modules::Employee, 'field' => DropDownFields::employee_status],
            ['name' => 'CheckOut', 'value' => '2', 'module' => Modules::Employee, 'field' => DropDownFields::employee_status],
        ];

        foreach ($types as $value) {
            Constant::updateOrCreate($value);
        }

        $this->command->info('RESTAURANT_BRANCHES Seeded successfully!');
    }
}

<?php

namespace Database\Seeders;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Models\Constant;
use Illuminate\Database\Seeder;

class BranchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $WHEELS_BRANCHES = [
            ['name' => 'Kufor Aqab', 'value' => '295', 'module' => Modules::Customer, 'field' => DropDownFields::WHEELS_BRANCHES],
            ['name' => 'Shufat', 'value' => '35', 'module' => Modules::Customer, 'field' => DropDownFields::WHEELS_BRANCHES],
            ['name' => 'Ras El- Amoud', 'value' => '31', 'module' => Modules::Customer, 'field' => DropDownFields::WHEELS_BRANCHES],
            ['name' => 'heikh Jarrah', 'value' => '146', 'module' => Modules::Customer, 'field' => DropDownFields::WHEELS_BRANCHES],
            ['name' => 'Bab El-Sahera', 'value' => '14', 'module' => Modules::Customer, 'field' => DropDownFields::WHEELS_BRANCHES],
            ['name' => 'Beit Hanina', 'value' => '145', 'module' => Modules::Customer, 'field' => DropDownFields::WHEELS_BRANCHES],
        ];

        foreach ($WHEELS_BRANCHES as $value) {
            Constant::updateOrCreate($value);
        }

        $this->command->info('WHEELS_BRANCHES Seeded successfully!');
    }
}

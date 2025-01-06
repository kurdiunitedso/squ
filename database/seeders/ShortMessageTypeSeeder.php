<?php

namespace Database\Seeders;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Models\Constant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShortMessageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $SHORT_MESSAGE = [
            ['name' => 'Welcoming', 'value' => 'Welcoming', 'module' => Modules::main_module, 'field' => DropDownFields::SHORT_MESSAGE],
            ['name' => 'Greeting', 'value' => 'Greeting', 'module' => Modules::main_module, 'field' => DropDownFields::SHORT_MESSAGE],
            ['name' => 'Birthday', 'value' => 'Birthday', 'module' => Modules::main_module, 'field' => DropDownFields::SHORT_MESSAGE],
            ['name' => 'New Service', 'value' => 'New Service', 'module' => Modules::main_module, 'field' => DropDownFields::SHORT_MESSAGE],
        ];

        foreach ($SHORT_MESSAGE as $value) {
            Constant::updateOrCreate($value);
        }

        $this->command->info('SHORT_MESSAGE Seeded successfully!');
    }
}

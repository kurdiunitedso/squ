<?php

namespace Database\Seeders;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Models\Constant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CallActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $CALL_ACTION = [
            ['name' => 'CALL_ACTION', 'value' => 'CALL_ACTION', 'module' => Modules::main_module, 'field' => DropDownFields::CALL_ACTION],

        ];


        foreach ($CALL_ACTION as $value) {
            Constant::updateOrCreate($value);
        }

        $this->command->info('CALL_ACTION Seeded successfully!');
    }
}

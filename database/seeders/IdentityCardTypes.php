<?php

namespace Database\Seeders;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Models\Constant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IdentityCardTypes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $IDENTITY_TYPE = [
            ['name' => 'Palestinian ID', 'value' => '1', 'module' => Modules::main_module, 'field' => DropDownFields::IDENTITY_TYPE],
            ['name' => 'Israeli ID', 'value' => '2', 'module' => Modules::main_module, 'field' => DropDownFields::IDENTITY_TYPE],
        ];

        foreach ($IDENTITY_TYPE as $value) {
            Constant::updateOrCreate($value);
        }

        $this->command->info('IDENTITY_TYPE Seeded successfully!');
    }
}

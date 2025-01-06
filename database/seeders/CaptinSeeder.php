<?php

namespace Database\Seeders;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Models\Constant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CaptinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $captin_types = [
            ['name' => 'policy_degree', 'value' => '1', 'module' => Modules::CAPTIN, 'field' => DropDownFields::policy_degree],
            ['name' => 'policy_code', 'value' => '1', 'module' => Modules::CAPTIN, 'field' => DropDownFields::policy_code],
            ['name' => 'insurance_type', 'value' => '1', 'module' => Modules::CAPTIN, 'field' => DropDownFields::insurance_type],
            ['name' => 'policy_degree', 'value' => '1', 'module' => Modules::CAPTIN, 'field' => DropDownFields::policy_degree],
            ['name' => 'insurance_company', 'value' => '1', 'module' => Modules::CAPTIN, 'field' => DropDownFields::insurance_company],
            ['name' => 'promissory', 'value' => '1', 'module' => Modules::CAPTIN, 'field' => DropDownFields::promissory],
            ['name' => 'box_no', 'value' => '1', 'module' => Modules::CAPTIN, 'field' => DropDownFields::box_no],
            ['name' => 'vehicle_model', 'value' => '1', 'module' => Modules::CAPTIN, 'field' => DropDownFields::vehicle_model],
            ['name' => 'vehicle_type', 'value' => '1', 'module' => Modules::CAPTIN, 'field' => DropDownFields::vehicle_type],
            ['name' => 'fuel_type', 'value' => '1', 'module' => Modules::CAPTIN, 'field' => DropDownFields::fuel_type],
            ['name' => 'degree', 'value' => '1', 'module' => Modules::CAPTIN, 'field' => DropDownFields::degree],
            ['name' => 'payment_method_captin', 'value' => 'payment_method_captin', 'module' => Modules::CAPTIN, 'field' => DropDownFields::payment_method_captin],
            ['name' => 'payment_type_captin', 'value' => 'payment_type_captin', 'module' => Modules::CAPTIN, 'field' => DropDownFields::payment_type_captin],

            ['name' => 'blood_type', 'value' => '1', 'module' => Modules::CAPTIN, 'field' => DropDownFields::blood_type],
            ['name' => 'reference_relatives', 'value' => '1', 'module' => Modules::CAPTIN, 'field' => DropDownFields::reference_relatives],
            ['name' => 'policy_codes', 'value' => '1', 'module' => Modules::CAPTIN, 'field' => DropDownFields::policy_codes],
            ['name' => 'attachment_type', 'value' => '1', 'module' => Modules::CAPTIN, 'field' => DropDownFields::ATTACHMENT_TYPE],
            ['name' => 'motor_cc', 'value' => '1', 'module' => Modules::CAPTIN, 'field' => DropDownFields::motor_cc],
            ['name' => 'Answer', 'value' => '1', 'module' => Modules::CAPTIN, 'field' => DropDownFields::CAPTIN_ACTION],
            ['name' => 'Cancel', 'value' => '1', 'module' => Modules::CAPTIN, 'field' => DropDownFields::CAPTIN_CALL_ACTION],
            ['name' => 'A', 'value' => 'A', 'module' => Modules::CAPTIN, 'field' => DropDownFields::CAPTIN_SHIFT],

        ];
        foreach ($captin_types as $value) {
            Constant::updateOrCreate($value);
        }

        $this->command->info('captin_types Seeded successfully!');

    }
}

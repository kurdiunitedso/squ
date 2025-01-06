<?php

namespace Database\Seeders;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Models\Constant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $IDENTITY_TYPE = [
            ['name' => 'Visa', 'value' => '1', 'module' => Modules::RESTAURANT, 'field' => DropDownFields::PAYMENT_TYPE],
            ['name' => 'Fast Food', 'value' => '1', 'module' => Modules::RESTAURANT, 'field' => DropDownFields::RESTAURANT_TYPE],
            ['name' => 'Bank of Palestine', 'value' => '1', 'module' => Modules::RESTAURANT, 'field' => DropDownFields::BANK],
            ['name' => 'Windows', 'value' => '1', 'module' => Modules::RESTAURANT, 'field' => DropDownFields::OS_TYPE],
            ['name' => 'EPOS', 'value' => '1', 'module' => Modules::RESTAURANT, 'field' => DropDownFields::POS_TYPE],
            ['name' => 'Active', 'value' => '1', 'module' => Modules::RESTAURANT, 'field' => DropDownFields::EMP_STATUS],
            ['name' => 'attachment_rest_type', 'value' => '1', 'module' => Modules::RESTAURANT, 'field' => DropDownFields::attachment_rest_type],
        ];

        foreach ($IDENTITY_TYPE as $value) {
            Constant::updateOrCreate($value);
        }

        $this->command->info('QuestionnaireTypes Seeded successfully!');
    }
}

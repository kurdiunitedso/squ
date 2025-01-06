<?php

namespace Database\Seeders;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Models\Constant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionnaireTypes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $IDENTITY_TYPE = [
            ['name' => 'Call', 'value' => '1', 'module' => Modules::Customer, 'field' => DropDownFields::QUESTIONNAIRE_TYPE],
        ];

        foreach ($IDENTITY_TYPE as $value) {
            Constant::updateOrCreate($value);
        }

        $this->command->info('QuestionnaireTypes Seeded successfully!');
    }
}

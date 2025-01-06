<?php

namespace Database\Seeders;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Models\Constant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CallOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $CALL_OPTION_TYPE = [
            ['name' => 'assign_status', 'value' => 'assign_status', 'module' => Modules::CALL, 'field' => DropDownFields::assign_status],
            ['name' => 'caller_type', 'value' => 'caller_type', 'module' => Modules::CALL, 'field' => DropDownFields::caller_type],
            ['name' => 'call_status', 'value' => 'call_status', 'module' => Modules::CALL, 'field' => DropDownFields::call_status],
            ['name' => 'urgency', 'value' => 'urgency', 'module' => Modules::CALL, 'field' => DropDownFields::urgency],
            ['name' => 'task_urgencys', 'value' => 'task_urgencys', 'module' => Modules::CALL, 'field' => DropDownFields::task_urgencys],
            ['name' => 'task_statusss', 'value' => 'task_statusss', 'module' => Modules::CALL, 'field' => DropDownFields::task_statuss],


            ['name' => 'action1', 'value' => 'action1', 'module' => Modules::CALL, 'field' => DropDownFields::CALL_ACTION],
            ['name' => 'Complain', 'value' => 'Complain', 'module' => Modules::CALL, 'field' => DropDownFields::CALL_OPTION_TYPE],
            ['name' => 'Inquiry', 'value' => 'Inquiry', 'module' => Modules::CALL, 'field' => DropDownFields::CALL_OPTION_TYPE],
        ];

        foreach ($CALL_OPTION_TYPE as $value) {
            Constant::updateOrCreate($value);
        }

        $this->command->info('CALL_OPTION_TYPE Seeded successfully!');
    }
}

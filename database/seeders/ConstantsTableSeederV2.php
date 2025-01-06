<?php

namespace Database\Seeders;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Models\Constant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Constants extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $IDENTITY_TYPE = [
            // Contract Statuses
            ['name' => t('Draft'), 'value' => 'draft', 'module' => Modules::contract_module, 'field' => DropDownFields::status, 'color' => '#6c757d'], // Gray
            ['name' => t('Pending Approval'), 'value' => 'pending_approval', 'module' => Modules::contract_module, 'field' => DropDownFields::status, 'color' => '#ffc107'], // Yellow
            ['name' => t('Active'), 'value' => 'active', 'module' => Modules::contract_module, 'field' => DropDownFields::status, 'color' => '#28a745'], // Green
            ['name' => t('On Hold'), 'value' => 'on_hold', 'module' => Modules::contract_module, 'field' => DropDownFields::status, 'color' => '#fd7e14'], // Orange
            ['name' => t('Completed'), 'value' => 'completed', 'module' => Modules::contract_module, 'field' => DropDownFields::status, 'color' => '#007bff'], // Blue
            ['name' => t('Cancelled'), 'value' => 'cancelled', 'module' => Modules::contract_module, 'field' => DropDownFields::status, 'color' => '#dc3545'], // Red
            ['name' => t('Expired'), 'value' => 'expired', 'module' => Modules::contract_module, 'field' => DropDownFields::status, 'color' => '#6610f2'], // Purple


            // Project Statuses
            ['name' => t('Pending'), 'value' => 'pending', 'module' => Modules::project_module, 'field' => DropDownFields::status, 'color' => '#FFA500'], // Orange
            ['name' => t('Active'), 'value' => 'active', 'module' => Modules::project_module, 'field' => DropDownFields::status, 'color' => '#4CAF50'], // Green
            ['name' => t('On Hold'), 'value' => 'on_hold', 'module' => Modules::project_module, 'field' => DropDownFields::status, 'color' => '#FF9800'], // Dark Orange
            ['name' => t('Completed'), 'value' => 'completed', 'module' => Modules::project_module, 'field' => DropDownFields::status, 'color' => '#2196F3'], // Blue
            ['name' => t('Cancelled'), 'value' => 'cancelled', 'module' => Modules::project_module, 'field' => DropDownFields::status, 'color' => '#F44336'], // Red

            // Task Statuses
            ['name' => t('Not Started'), 'value' => 'not_started', 'module' => Modules::task_module, 'field' => DropDownFields::status, 'color' => '#9E9E9E'], // Grey
            ['name' => t('In Progress'), 'value' => 'in_progress', 'module' => Modules::task_module, 'field' => DropDownFields::status, 'color' => '#03A9F4'], // Light Blue
            ['name' => t('Pending Review'), 'value' => 'pending_review', 'module' => Modules::task_module, 'field' => DropDownFields::status, 'color' => '#FF9800'], // Orange
            ['name' => t('Revision Required'), 'value' => 'revision_required', 'module' => Modules::task_module, 'field' => DropDownFields::status, 'color' => '#FF5722'], // Deep Orange
            ['name' => t('Approved'), 'value' => 'approved', 'module' => Modules::task_module, 'field' => DropDownFields::status, 'color' => '#8BC34A'], // Light Green
            ['name' => t('Completed'), 'value' => 'completed', 'module' => Modules::task_module, 'field' => DropDownFields::status, 'color' => '#4CAF50'], // Green

            // Task Assignments Status
            //  employee proccessing -> art manager aproval -> Completed
            ['name' => t('Processing'), 'value' => 'Processing', 'module' => Modules::task_assignments_module, 'field' => DropDownFields::employee_task_assignment_status, 'color' => '#29B6F6'], // Lighter Blue
            ['name' => t('Art Manager Approval'), 'value' => 'Art Manager Approval', 'module' => Modules::task_assignments_module, 'field' => DropDownFields::employee_task_assignment_status, 'color' => '#FF7043'], // Light Deep Orange
            ['name' => t('Customer Approval'), 'value' => 'Customer Approval', 'module' => Modules::task_assignments_module, 'field' => DropDownFields::employee_task_assignment_status, 'color' => '#FF7043'], // Light Deep Orange
            ['name' => t('Completed'), 'value' => 'completed', 'module' => Modules::task_assignments_module, 'field' => DropDownFields::employee_task_assignment_status, 'color' => '#66BB6A'], // Light Green

            // art manager : approve or reject or wating customer approval
            ['name' => t('Waiting Approval'), 'value' => 'Waiting Approval', 'module' => Modules::task_assignments_module, 'field' => DropDownFields::art_manager_task_assignment_status, 'color' => '#29B6F6'], // Lighter Blue
            ['name' => t('Approved'), 'value' => 'Approved', 'module' => Modules::task_assignments_module, 'field' => DropDownFields::art_manager_task_assignment_status, 'color' => '#FF7043'], // Light Deep Orange
            ['name' => t('Reject'), 'value' => 'Reject', 'module' => Modules::task_assignments_module, 'field' => DropDownFields::art_manager_task_assignment_status, 'color' => '#66BB6A'], // Light Green


            // Task Assignments Types
            ['name' => t('Created'), 'value' => 'created', 'module' => Modules::task_assignments_module, 'field' => DropDownFields::task_assignment_process_types, 'color' => '#BDBDBD'], // Light Grey
            ['name' => t('Status change'), 'value' => 'status change', 'module' => Modules::task_assignments_module, 'field' => DropDownFields::task_assignment_process_types, 'color' => '#BDBDBD'], // Light Grey
            ['name' => t('Active'), 'value' => 'active', 'module' => Modules::task_assignments_module, 'field' => DropDownFields::task_assignment_process_types, 'color' => '#BDBDBD'], // Light Grey
            ['name' => t('Title'), 'value' => 'Title', 'module' => Modules::task_assignments_module, 'field' => DropDownFields::task_assignment_process_types, 'color' => '#BDBDBD'], // Light Grey
            ['name' => t('Description'), 'value' => 'Description', 'module' => Modules::task_assignments_module, 'field' => DropDownFields::task_assignment_process_types, 'color' => '#BDBDBD'], // Light Grey
            ['name' => t('Start Date'), 'value' => 'Start Date', 'module' => Modules::task_assignments_module, 'field' => DropDownFields::task_assignment_process_types, 'color' => '#BDBDBD'], // Light Grey
            ['name' => t('End Date'), 'value' => 'End Date', 'module' => Modules::task_assignments_module, 'field' => DropDownFields::task_assignment_process_types, 'color' => '#BDBDBD'], // Light Grey

        ];

        foreach ($IDENTITY_TYPE as $value) {
            $value['constant_name'] = str_replace(' ', '_', trim(strtolower($value["name"])));
            Constant::updateOrCreate(
                collect($value)->only(['name', 'module', 'field'])->toArray(),
                collect($value)->except(['name', 'module', 'field'])->toArray(),
            );
        }

        $this->command->info('IDENTITY_TYPE Seeded successfully!');
    }
}

<?php

namespace App\Services\Constants;

use App\Enums\DropDownFields;
use App\Enums\Modules;

class GetConstantService
{
    public static function get_lead_form_type_list()
    {
        return ConstantService::search([
            'module' => 'lead_module',
            'field' => 'lead_form_type'
        ]);
    }
    public static function get_bank_list()
    {
        return \App\Services\Constants\ConstantService::search([
            'module' => \App\Enums\Modules::main_module,
            'field' => \App\Enums\DropDownFields::banks,
        ]);
    }
    public static function get_program_attachment_type_list()
    {
        return \App\Services\Constants\ConstantService::search([
            'module' => \App\Enums\Modules::attachment_module,
            'field' => \App\Enums\DropDownFields::program_attachment_type,
        ]);
    }
    // GetConstantService.php

    public static function get_program_eligibility_type_list()
    {
        return ConstantService::search([
            'module' => Modules::program_module,
            'field' => DropDownFields::program_eligibility_type
        ]);
    }

    public static function get_program_target_applicants_list()
    {
        return ConstantService::search([
            'module' => Modules::program_module,
            'field' => DropDownFields::program_target_applicants
        ]);
    }

    public static function get_program_category_list()
    {
        return ConstantService::search([
            'module' => Modules::program_module,
            'field' => DropDownFields::program_category
        ]);
    }

    public static function get_program_facility_list()
    {
        return ConstantService::search([
            'module' => Modules::program_module,
            'field' => DropDownFields::program_facility
        ]);
    }
}

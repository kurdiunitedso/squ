<?php

namespace App\Services\Constants;


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
}

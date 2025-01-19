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
    public static function get_apartment_size_list()
    {
        return \App\Services\Constants\ConstantService::search([
            'module' => \App\Enums\Modules::appartment_module,
            'field' => \App\Enums\DropDownFields::apartment_size,
        ]);
    }
}

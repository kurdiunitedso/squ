<?php

namespace App\Traits;

use App\Models\AddOn;
use App\Models\Apartment;
use App\Models\Building;
use App\Models\Client;
use App\Models\Lead;
use App\Models\PriceOffer;
use App\Models\Program;
use App\Models\Sale;
use App\Services\Constants\GetConstantService;

trait HasCommonData
{
    /**
     * Available dropdown types that can be loaded
     */
    protected const DROPDOWN_TYPES = [
        'city_list' => 'city_list',

        'attachment_type_list' => 'attachment_type_list',

        'website_section_type_list' => 'website_section_type_list',
        'bank_list' => 'bank_list',
        'program_target_applicants_list' => 'program_target_applicants_list',
        'program_category_list' => 'program_category_list',
        'program_eligibility_type_list' => 'program_eligibility_type_list',
        'program_facility_list' => 'program_facility_list',
        // Add other dropdown types here
    ];

    /**
     * Default dropdown configuration. Controllers should override getRequiredDropdowns()
     * instead of defining their own $requiredDropdowns property
     */
    private $defaultDropdowns = [
        'index' => [],
        'create' => ['*'],
        'edit' => ['*'],
        'store' => [],
        'update' => [],
    ];
    /**
     * Get required dropdowns for actions. Override this in controllers.
     */
    protected function getRequiredDropdowns(): array
    {
        return $this->defaultDropdowns;
    }
    /**
     * Get common data with specific dropdowns for the current action
     */
    protected function getCommonData(?string $action = null, array $specificDropdowns = []): array
    {
        $data = [
            '_view_path' =>  $this->_model::ui['view'],
            '_model' => $this->_model
        ];

        $data = array_merge($data, $this->getUIConstants());

        $dropdownsToLoad = $this->determineRequiredDropdowns($action, $specificDropdowns);

        if (!empty($dropdownsToLoad)) {
            $data = array_merge($data, $this->loadDropdowns($dropdownsToLoad));
        }

        return $data;
    }



    /**
     * Determine which dropdowns should be loaded
     */
    protected function determineRequiredDropdowns(?string $action, array $specificDropdowns): array
    {
        if (!empty($specificDropdowns)) {
            return $specificDropdowns;
        }

        $requiredDropdowns = $this->getRequiredDropdowns();

        if ($action && isset($requiredDropdowns[$action])) {
            $required = $requiredDropdowns[$action];

            if (in_array('*', $required)) {
                return array_keys(self::DROPDOWN_TYPES);
            }

            return $required;
        }

        return [];
    }

    /**
     * Load only the specified dropdowns
     */
    protected function loadDropdowns(array $dropdownTypes): array
    {
        $dropdowns = [];

        foreach ($dropdownTypes as $type) {
            if (isset(self::DROPDOWN_TYPES[$type])) {
                $method = self::DROPDOWN_TYPES[$type];
                if (method_exists($this, $method)) {
                    $dropdowns[$type] = $this->$method();
                }
            }
        }

        return $dropdowns;
    }

    /**
     * Get UI constants
     */
    protected function getUIConstants(): array
    {
        return [
            'ui' => $this->_model::ui,
            'table' => $this->_model::ui['table'],
            'route' => $this->_model::ui['route'],
            'singular' => $this->_model::ui['s_ucf'],
            'plural' => $this->_model::ui['p_ucf'],
            'singular_lower' => $this->_model::ui['s_lcf'],
            'plural_lower' => $this->_model::ui['p_lcf'],
            'id_field' => $this->_model::ui['_id'],
            'view' => $this->_model::ui['view'],
        ];
    }

    /**
     * Individual dropdown data methods
     */
    protected function city_list()
    {
        return \App\Models\City::all();
    }

    protected function website_section_type_list()
    {
        return \App\Services\Constants\ConstantService::search([
            'module' => \App\Enums\Modules::website_sections_module,
            'field' => \App\Enums\DropDownFields::website_section_type,
        ]);
    }
    protected function bank_list()
    {
        return GetConstantService::get_bank_list();
    }

    protected function program_target_applicants_list()
    {
        return GetConstantService::get_program_target_applicants_list();
    }

    protected function program_category_list()
    {
        return GetConstantService::get_program_category_list();
    }

    protected function program_eligibility_type_list()
    {
        return GetConstantService::get_program_eligibility_type_list();
    }

    protected function program_facility_list()
    {
        return GetConstantService::get_program_facility_list();
    }

    protected function attachment_type_list()
    {
        $model = request()->model;
        // dd($model, GetConstantService::get_program_attachment_type_list());
        switch ($model) {
            case Program::class:
                return GetConstantService::get_program_attachment_type_list();
        }
    }
}

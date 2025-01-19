<?php

namespace App\Traits;

use App\Models\AddOn;
use App\Models\Apartment;
use App\Models\Building;
use App\Models\Client;
use App\Models\Lead;
use App\Models\PriceOffer;
use App\Models\Sale;

trait HasCommonData
{
    /**
     * Available dropdown types that can be loaded
     */
    protected const DROPDOWN_TYPES = [
        'city_list' => 'city_list',
        'building_list' => 'building_list',
        'apartment_type_list' => 'apartment_type_list',
        'apartment_status_list' => 'apartment_status_list',
        'apartment_size_list' => 'apartment_size_list',
        'orientation_list' => 'orientation_list',
        'parking_type_list' => 'parking_type_list',
        'lead_form_type_list' => 'lead_form_type_list',
        'apartment_list' => 'apartment_list',
        'lead_status_list' => 'lead_status_list',
        'lead_source_list' => 'lead_source_list',
        'price_offer_status_list' => 'price_offer_status_list',
        'attachment_type_list' => 'attachment_type_list',
        'active_add_on_list' => 'active_add_on_list',
        'website_section_type_list' => 'website_section_type_list',
        'bank_list' => 'bank_list',
        'sales_contract_type_list' => 'sales_contract_type_list',
        'sales_payment_type_list' => 'sales_payment_type_list',
        'sales_status_list' => 'sales_status_list',
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

    protected function building_list()
    {
        return \App\Models\Building::all();
    }

    protected function apartment_type_list()
    {
        return \App\Services\Constants\ConstantService::search([
            'module' => \App\Enums\Modules::appartment_module,
            'field' => \App\Enums\DropDownFields::apartment_type,
        ]);
    }
    protected function apartment_status_list()
    {
        return \App\Services\Constants\ConstantService::search([
            'module' => \App\Enums\Modules::appartment_module,
            'field' => \App\Enums\DropDownFields::apartment_status,
        ]);
    }

    protected function apartment_size_list()
    {
        return \App\Services\Constants\ConstantService::search([
            'module' => \App\Enums\Modules::appartment_module,
            'field' => \App\Enums\DropDownFields::apartment_size,
        ]);
    }

    protected function orientation_list()
    {
        return \App\Services\Constants\ConstantService::search([
            'module' => \App\Enums\Modules::appartment_module,
            'field' => \App\Enums\DropDownFields::apartment_orientation,
        ]);
    }

    protected function parking_type_list()
    {
        return \App\Services\Constants\ConstantService::search([
            'module' => \App\Enums\Modules::appartment_module,
            'field' => \App\Enums\DropDownFields::apartment_parking_type,
        ]);
    }
    protected function lead_form_type_list()
    {
        return \App\Services\Constants\ConstantService::search([
            'module' => \App\Enums\Modules::lead_module,
            'field' => \App\Enums\DropDownFields::lead_form_type,
        ]);
    }
    protected function lead_status_list()
    {
        return \App\Services\Constants\ConstantService::search([
            'module' => \App\Enums\Modules::lead_module,
            'field' => \App\Enums\DropDownFields::lead_status,
        ]);
    }
    protected function lead_source_list()
    {
        return \App\Services\Constants\ConstantService::search([
            'module' => \App\Enums\Modules::lead_module,
            'field' => \App\Enums\DropDownFields::lead_source,
        ]);
    }
    protected function price_offer_status_list()
    {
        return \App\Services\Constants\ConstantService::search([
            'module' => \App\Enums\Modules::price_offer_module,
            'field' => \App\Enums\DropDownFields::price_offer_status,
        ]);
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
        return \App\Services\Constants\ConstantService::search([
            'module' => \App\Enums\Modules::main_module,
            'field' => \App\Enums\DropDownFields::banks,
        ]);
    }
    protected function sales_contract_type_list()
    {
        return \App\Services\Constants\ConstantService::search([
            'module' => \App\Enums\Modules::sales_module,
            'field' => \App\Enums\DropDownFields::sales_contract_type,
        ]);
    }
    protected function sales_payment_type_list()
    {
        return \App\Services\Constants\ConstantService::search([
            'module' => \App\Enums\Modules::sales_module,
            'field' => \App\Enums\DropDownFields::sales_payment_type,
        ]);
    }
    protected function sales_status_list()
    {
        return \App\Services\Constants\ConstantService::search([
            'module' => \App\Enums\Modules::sales_module,
            'field' => \App\Enums\DropDownFields::sales_status,
        ]);
    }
    protected function _view_path()
    {
        return \App\Services\Constants\ConstantService::search([
            'module' => \App\Enums\Modules::price_offer_module,
            'field' => \App\Enums\DropDownFields::price_offer_status,
        ]);
    }
    protected function attachment_type_list()
    {
        $model = request()->model;
        switch ($model) {
            case Apartment::class:
                return \App\Services\Constants\ConstantService::search([
                    'module' => \App\Enums\Modules::attachment_module,
                    'field' => \App\Enums\DropDownFields::apartment_attachment_type,
                ]);
            case Building::class:
                return \App\Services\Constants\ConstantService::search([
                    'module' => \App\Enums\Modules::attachment_module,
                    'field' => \App\Enums\DropDownFields::building_attachment_type,
                ]);
            case PriceOffer::class:
                return \App\Services\Constants\ConstantService::search([
                    'module' => \App\Enums\Modules::attachment_module,
                    'field' => \App\Enums\DropDownFields::price_offer_attachment_type,
                ]);
            case Lead::class:
                return \App\Services\Constants\ConstantService::search([
                    'module' => \App\Enums\Modules::attachment_module,
                    'field' => \App\Enums\DropDownFields::lead_attachment_type,
                ]);
            case Client::class:
                return \App\Services\Constants\ConstantService::search([
                    'module' => \App\Enums\Modules::attachment_module,
                    'field' => \App\Enums\DropDownFields::client_attachment_type,
                ]);
            case Sale::class:
                return \App\Services\Constants\ConstantService::search([
                    'module' => \App\Enums\Modules::attachment_module,
                    'field' => \App\Enums\DropDownFields::sale_attachment_type,
                ]);
        }
    }
    protected function apartment_list()
    {
        return Apartment::get();
    }
    protected function active_add_on_list()
    {
        return AddOn::where('active', true)->get();
    }
}

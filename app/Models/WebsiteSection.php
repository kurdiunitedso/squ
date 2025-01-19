<?php

namespace App\Models;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Services\Constants\ConstantService;
use App\Traits\HasActionButtons;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class WebsiteSection extends Model
{
    use HasFactory, SoftDeletes, HasActionButtons, HasTranslations;
    public $translatable = ['name', 'description'];
    protected $fillable = [
        'name',
        'type_id',
        'description',
        'image',
        'active',
        'order',
        'url',
    ];

    public const ui = [
        'table' => 'website_sections',
        'route' => 'website_sections',
        's_ucf' => 'Website Section',
        'p_ucf' => 'Website Sections',
        's_lcf' => 'website_section',
        'p_lcf' => 'website_sections',
        'view' => 'CP.WebsiteManagement.website_sections.',
        '_id' => 'website_section_id',
        'controller_name' => 'WebsiteSectionController',
        'image_path' => 'website_sections'
    ];
    public function type()
    {
        return $this->belongsTo(Constant::class, 'type_id');
    }


    public static function getWebsiteSectionTypeConstant($name)
    {
        return ConstantService::getByModuleAndField(Modules::website_sections_module, DropDownFields::website_section_type)
            ->where('constant_name', $name)
            ->first();
    }
    /**
     * Scope a query to only include sections of a specific type
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $typeName The constant_name of the type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, string $typeName)
    {
        $typeConstant = self::getWebsiteSectionTypeConstant($typeName);

        if ($typeConstant) {
            return $query->where('type_id', $typeConstant->id);
        }

        return $query;
    }

    /**
     * Scope to get menu items
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMenus($query)
    {
        return $query->ofType(DropDownFields::website_section_type_list['menu'])

            ->where('active', true)
            ->orderBy('order');
    }
    /**
     * Scope to get Sliders
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSliders($query)
    {
        return $query->ofType(DropDownFields::website_section_type_list['slider'])
            ->where('active', true)
            ->orderBy('order');
    }

    /**
     * Scope to get active sections
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Override this method in your model to customize buttons
     */
    protected function getActionButtons(): array
    {
        return [
            $this->getEditButton(),
            $this->getRemoveButton(),
            // $this->getMenuButton()
        ];
    }
}

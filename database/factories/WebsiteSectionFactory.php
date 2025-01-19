<?php

namespace Database\Factories;

use App\Models\WebsiteSection;
use App\Models\Constant;
use App\Enums\Modules;
use App\Enums\DropDownFields;
use Illuminate\Database\Eloquent\Factories\Factory;

class WebsiteSectionFactory extends Factory
{
    protected $model = WebsiteSection::class;

    public function definition()
    {
        // Get all website section type constants
        $typeIds = Constant::where('module', Modules::website_sections_module)
            ->where('field', DropDownFields::website_section_type)
            ->pluck('id')
            ->toArray();

        // If no types exist, create a default one
        if (empty($typeIds)) {
            $typeIds = [
                Constant::create([
                    'module' => Modules::website_sections_module,
                    'field' => DropDownFields::website_section_type,
                    'constant_name' => 'menu',
                    'name' => ['en' => 'Menu', 'ar' => 'قائمة'],
                ])->id
            ];
        }

        return [
            'name' => [
                'en' => $this->faker->words(2, true),
                'ar' => 'قسم ' . $this->faker->numberBetween(1, 1000)
            ],
            'description' => [
                'en' => $this->faker->paragraph(),
                'ar' => 'وصف ' . $this->faker->sentence()
            ],
            'type_id' => $this->faker->randomElement($typeIds),
            'image' => null, // You can add image handling if needed
            'active' => $this->faker->boolean(80), // 80% chance of being active
            'order' => $this->faker->numberBetween(1, 100),
            'url' => $this->faker->url(),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (WebsiteSection $websiteSection) {
            //
        })->afterCreating(function (WebsiteSection $websiteSection) {
            //
        });
    }

    /**
     * Indicate that the section is a menu.
     *
     * @return Factory
     */
    public function menu()
    {
        return $this->state(function (array $attributes) {
            $menuType = WebsiteSection::getWebsiteSectionTypeConstant('menu');
            return [
                'type_id' => $menuType ? $menuType->id : null,
            ];
        });
    }

    /**
     * Indicate that the section is a slider.
     *
     * @return Factory
     */
    public function slider()
    {
        return $this->state(function (array $attributes) {
            $sliderType = WebsiteSection::getWebsiteSectionTypeConstant('slider');
            return [
                'type_id' => $sliderType ? $sliderType->id : null,
            ];
        });
    }
}

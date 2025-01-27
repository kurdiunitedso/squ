<?php

namespace Database\Seeders;

use App\Enums\DropDownFields;
use App\Models\WebsiteSection;
use Illuminate\Database\Seeder;

class WebsiteSectionSeeder extends Seeder
{
    public function run()
    {
        WebsiteSection::query()->delete();
        // Create 50 random website sections
        WebsiteSection::factory(3)->create();

        $menuType = WebsiteSection::getWebsiteSectionTypeConstant(DropDownFields::website_section_type_list['menu']);
        $sliderType = WebsiteSection::getWebsiteSectionTypeConstant(DropDownFields::website_section_type_list['slider']);

        if (!$menuType) {
            $this->command->error('Menu type constant not found! Please run MenuConstantSeeder first.');
            return;
        }
    }
}

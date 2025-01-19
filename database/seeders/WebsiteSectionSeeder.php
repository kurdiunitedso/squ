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
        $menuType = WebsiteSection::getWebsiteSectionTypeConstant(DropDownFields::website_section_type_list['menu']);
        $sliderType = WebsiteSection::getWebsiteSectionTypeConstant(DropDownFields::website_section_type_list['slider']);

        if (!$menuType) {
            $this->command->error('Menu type constant not found! Please run MenuConstantSeeder first.');
            return;
        }

        $menuItems = [
            [
                'name' => [
                    'en' => 'Home',
                    'ar' => 'الرئيسية'
                ],
                'type_id' => $menuType->id,
                'description' => [
                    'en' => 'Home Page',
                    'ar' => 'الصفحة الرئيسية'
                ],
                'active' => true,
                'order' => 1,
                'url' => '/',
            ],

            [
                'name' => [
                    'en' => 'Services',
                    'ar' => 'خدماتنا'
                ],
                'type_id' => $menuType->id,
                'description' => [
                    'en' => 'Our Services',
                    'ar' => 'خدماتنا'
                ],
                'active' => true,
                'order' => 3,
                'url' => '#',

            ],
            [
                'name' => [
                    'en' => 'Book Now',
                    'ar' => 'احجز موعد الاّن'
                ],
                'type_id' => $menuType->id,
                'description' => [
                    'en' => 'Book Now',
                    'ar' => 'احجز موعد الاّن'
                ],
                'active' => true,
                'order' => 4,
                'url' => '#',

            ],

        ];
        $sliderItems = [
            [
                'type_id' => $sliderType->id,
                'description' => [
                    'en' =>                        'Advanced security system and spacious living areas that meet all residents aspirations',

                    'ar' => 'نظام أمان متقدم ومساحات معيشة رحبة تلبي جميع تطلعات السكان.'
                ],
                'active' => true,
                'image' => 'website/img/feature-sliders/slide01.png',

            ],
            [

                'type_id' => $sliderType->id,
                'description' => [
                    'en' => 'Lobbies designed in luxury hotel style, adding an atmosphere of elegance and comfort',
                    'ar' => 'ردهات مصممة بأسلوب الفنادق الفاخرة، مما يضفي طابعًا من الأناقة والراحة.'
                ],
                'active' => true,
                'image' => 'website/img/feature-sliders/slide02.png',

            ],
            [

                'type_id' => $sliderType->id,
                'description' => [
                    'en' => 'Multiple entrances ensuring easy access and security, with elevators equipped for furniture and heavy load transportation to facilitate movement within the towers',
                    'ar' => 'مداخل متعددة تضمن سهولة الوصول والأمان و مصاعد مجهزة لنقل الأثاث والأحمال الثقيلة لتسهيل الانتقال داخل الأبراج.'
                ],
                'active' => true,
                'image' => 'website/img/feature-sliders/slide03.png',

            ],
            [

                'type_id' => $sliderType->id,
                'description' => [
                    'en' => 'Parking lots equipped with charging stations for electric vehicles, storage spaces, and a central gas and electricity system',
                    'ar' => 'مواقف سيارات مجهزة بمحطات شحن للسيارات الكهربائية، ومساحات تخزين، ونظام غاز وكهرباء مركزي.'
                ],
                'active' => true,
                'image' => 'website/img/feature-sliders/slide04.png',

            ],


        ];

        foreach ($menuItems as $item) {
            WebsiteSection::create($item);
        }
        foreach ($sliderItems as $item) {
            WebsiteSection::create($item);
        }
    }
}

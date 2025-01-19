<?php

namespace Database\Seeders;

use App\Models\Menu;

use App\Models\Slider;
use App\Models\WebsiteSection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Menu = [
            [
                "name" => "لوحة التحكم",
                "name_en" => "Dashboard",
                "name_he" => "Dashboard",
                "route" => "home",
                "icon_svg" => getSvgIcon('dashboard'),
                "order" => 1,
                "permission_name" => "dashboard_access",
            ],
            [
                "name" => "الاعدادات",
                "name_en" => "Settings",
                "name_he" => "Settings",
                "route" => NULL,
                "icon_svg" => getSvgIcon('settings'),
                "order" => 2,
                "permission_name" => NULL,
                "subRoutes" => [
                    [
                        "name" => "الدول والمدن",
                        "name_en" => "Countries and Cities",
                        "name_he" => "Countries and Cities",
                        "route" => "settings.country-city.index",
                        "icon_svg" => NULL,
                        "order" => 1,
                        "permission_name" => "settings_country_city_access",
                    ],
                    [
                        "name" => "القائمة الرئيسية",
                        "name_en" => "Menu",
                        "name_he" => "Menu",
                        "route" => "settings.menus.index",
                        "icon_svg" => NULL,
                        "order" => 2,
                        "permission_name" => "settings_menu_access",
                    ],

                    [
                        "name" => "الثوابت",
                        "name_en" => "Constants",
                        "name_he" => "Constants",
                        "route" => "settings.constants.index",
                        "icon_svg" => NULL,
                        "order" => 3,
                        "permission_name" => "settings_constants_access",
                    ],


                ]
            ],
            [
                "name" => "إدارة المستخدمين",
                "name_en" => "User Management",
                "name_he" => "User Management",
                "route" => NULL,
                "icon_svg" => getSvgIcon('user_managment'),
                "order" => 3,
                "permission_name" => NULL,
                "subRoutes" => [
                    [
                        "name" => "المستخدمين",
                        "name_en" => "Users",
                        "name_he" => "משתמשים",
                        "route" => "user-management.users.index",
                        "icon_svg" => NULL,
                        "order" => 1,
                        "permission_name" => "user_management_access",
                    ],
                    [
                        "name" => "الصلاحيات",
                        "name_en" => "Roles",
                        "name_he" => "Roles",
                        "route" => "user-management.roles.index",
                        "icon_svg" => NULL,
                        "order" => 2,
                        "permission_name" => "user_management_access",
                    ],
                ]
            ],
            [
                "name" => t("Website Management", [], 'ar'),
                "name_en" => t("Website Management", [], 'en'),
                "name_he" => t("Website Management", [], 'he'),
                "route" => null,
                "icon_svg" => getSvgIcon('menu_webiste'),
                "order" => 9,
                "permission_name" => "user_management_access",
                "subRoutes" => [
                    // [
                    //     "name" => t(MenuWebSite::ui['p_ucf']),
                    //     "name_en" => MenuWebSite::ui['p_ucf'],
                    //     "name_he" => MenuWebSite::ui['p_ucf'],
                    //     "route" => "menuWebsite.index",
                    //     "icon_svg" => '',
                    //     "order" => 1,
                    //     "permission_name" => MenuWebSite::ui['s_lcf'] . "_access",
                    // ],
                    [
                        "name" => t(WebsiteSection::ui['p_ucf']),
                        "name_en" => WebsiteSection::ui['p_ucf'],
                        "name_he" => WebsiteSection::ui['p_ucf'],
                        "route" => WebsiteSection::ui['route'] . ".index|" . WebsiteSection::ui['route'] . ".create",
                        "icon_svg" => '',
                        "order" => 1,
                        "permission_name" => WebsiteSection::ui['s_lcf'] . "_access",
                    ],


                ],

            ],
        ];


        DB::table('menus')->delete();

        foreach ($Menu as $menuItem) {
            // dd($menuItem);
            $parent = Menu::updateOrCreate([
                "name" => $menuItem['name'],
                "name_en" => $menuItem['name_en'],
                "name_he" => $menuItem['name_he'],
                "route" => $menuItem['route'],
                "icon_svg" => $menuItem['icon_svg'],
                "order" => $menuItem['order'],
                "permission_name" => $menuItem['permission_name'],
            ]);
            if (isset($menuItem["subRoutes"])) {
                foreach ($menuItem["subRoutes"] as $subMenu) {
                    Menu::updateOrCreate([
                        "name" => $subMenu['name'],
                        "name_en" => $subMenu['name_en'],
                        "name_he" => $subMenu['name_he'],
                        "route" => $subMenu['route'],
                        "icon_svg" => $subMenu['icon_svg'],
                        "order" => $subMenu['order'],
                        "permission_name" => $subMenu['permission_name'],
                        "parent_id" => $parent->id,
                    ]);
                }
            }
        }

        $this->command->info('Menu created successfully!');
    }
}

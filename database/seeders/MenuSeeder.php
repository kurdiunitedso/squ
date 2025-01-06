<?php

namespace Database\Seeders;

use App\Models\Contract;
use App\Models\Department;
use App\Models\Lead;
use App\Models\Menu;
use App\Models\Objective;
use App\Models\Offer;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                "icon_svg" => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor"></rect>
                                    <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="currentColor"></rect>
                                    <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="currentColor"></rect>
                                    <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="currentColor"></rect>
                                </svg>',
                "order" => 1,
                "permission_name" => "dashboard_access",
            ],
            [
                "name" => "إدارة المستخدمين",
                "name_en" => "User Management",
                "name_he" => "User Management",
                "route" => NULL,
                "icon_svg" => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="currentColor"></path>
                                <rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="currentColor"></rect>
                            </svg>',
                "order" => 2,
                "permission_name" => NULL,
                "subRoutes" => [
                    [
                        "name" => "المستخدمين",
                        "name_en" => "Users",
                        "name_he" => "משתמשים",
                        "route" => "user-management.users.index",
                        "icon_svg" => NULL,
                        "order" => 3,
                        "permission_name" => "user_management_access",
                    ],
                    [
                        "name" => "الصلاحيات",
                        "name_en" => "Roles",
                        "name_he" => "Roles",
                        "route" => "user-management.roles.index",
                        "icon_svg" => NULL,
                        "order" => 4,
                        "permission_name" => "user_management_access",
                    ],
                ]
            ],
            [
                "name" => "الاعدادات",
                "name_en" => "Settings",
                "name_he" => "Settings",
                "route" => NULL,
                "icon_svg" => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3" d="M5 8.04999L11.8 11.95V19.85L5 15.85V8.04999Z" fill="currentColor"></path>
                                <path d="M20.1 6.65L12.3 2.15C12 1.95 11.6 1.95 11.3 2.15L3.5 6.65C3.2 6.85 3 7.15 3 7.45V16.45C3 16.75 3.2 17.15 3.5 17.25L11.3 21.75C11.5 21.85 11.6 21.85 11.8 21.85C12 21.85 12.1 21.85 12.3 21.75L20.1 17.25C20.4 17.05 20.6 16.75 20.6 16.45V7.45C20.6 7.15 20.4 6.75 20.1 6.65ZM5 15.85V7.95L11.8 4.05L18.6 7.95L11.8 11.95V19.85L5 15.85Z" fill="currentColor"></path>
                                </svg>',
                "order" => 5,
                "permission_name" => NULL,
                "subRoutes" => [
                    [
                        "name" => "الدول والمدن",
                        "name_en" => "Countries and Cities",
                        "name_he" => "Countries and Cities",
                        "route" => "settings.country-city.index",
                        "icon_svg" => NULL,
                        "order" => 6,
                        "permission_name" => "settings_country_city_access",
                    ],
                    [
                        "name" => "القائمة الرئيسية",
                        "name_en" => "Menu",
                        "name_he" => "Menu",
                        "route" => "settings.menus.index",
                        "icon_svg" => NULL,
                        "order" => 7,
                        "permission_name" => "settings_menu_access",
                    ],
                    [
                        "name" => "استبيانات",
                        "name_en" => "Questionnaires",
                        "name_he" => "Questionnaires",
                        "route" => "settings.questionnaires.index",
                        "icon_svg" => NULL,
                        "order" => 8,
                        "permission_name" => "settings_questionnaire_access",
                    ],
                    [
                        "name" => "الثوابت",
                        "name_en" => "Constants",
                        "name_he" => "Constants",
                        "route" => "settings.constants.index",
                        "icon_svg" => NULL,
                        "order" => 9,
                        "permission_name" => "settings_constants_access",
                    ],
                    [
                        "name" => t(Objective::ui['p_ucf']),
                        "name_en" => Objective::ui['p_ucf'],
                        "name_he" => Objective::ui['p_ucf'],
                        "route" => "settings." . Objective::ui['route'] . ".index|" . "settings." . Objective::ui['route'] . ".create|" . "settings." . Objective::ui['route'] . ".edit",
                        "icon_svg" => NULL,
                        "order" => 9,
                        "permission_name" => "settings_" . Objective::ui['route'] . "_access",
                    ],

                ]
            ],
            [
                "name" => "المطاعم",
                "name_en" => "Restaurant",
                "name_he" => "Restaurant",
                "route" => NULL,
                "icon_svg" => ' <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/ecommerce/ecm004.svg-->
<span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path opacity="0.3" d="M18 10V20C18 20.6 18.4 21 19 21C19.6 21 20 20.6 20 20V10H18Z" fill="currentColor"/>
<path opacity="0.3" d="M11 10V17H6V10H4V20C4 20.6 4.4 21 5 21H12C12.6 21 13 20.6 13 20V10H11Z" fill="currentColor"/>
<path opacity="0.3" d="M10 10C10 11.1 9.1 12 8 12C6.9 12 6 11.1 6 10H10Z" fill="currentColor"/>
<path opacity="0.3" d="M18 10C18 11.1 17.1 12 16 12C14.9 12 14 11.1 14 10H18Z" fill="currentColor"/>
<path opacity="0.3" d="M14 4H10V10H14V4Z" fill="currentColor"/>
<path opacity="0.3" d="M17 4H20L22 10H18L17 4Z" fill="currentColor"/>
<path opacity="0.3" d="M7 4H4L2 10H6L7 4Z" fill="currentColor"/>
<path d="M6 10C6 11.1 5.1 12 4 12C2.9 12 2 11.1 2 10H6ZM10 10C10 11.1 10.9 12 12 12C13.1 12 14 11.1 14 10H10ZM18 10C18 11.1 18.9 12 20 12C21.1 12 22 11.1 22 10H18ZM19 2H5C4.4 2 4 2.4 4 3V4H20V3C20 2.4 19.6 2 19 2ZM12 17C12 16.4 11.6 16 11 16H6C5.4 16 5 16.4 5 17C5 17.6 5.4 18 6 18H11C11.6 18 12 17.6 12 17Z" fill="currentColor"/>
</svg>
</span>
<!--end::Svg Icon-->',
                "order" => 10,
                "permission_name" => NULL,
                "subRoutes" => [
                    [
                        "name" => "عرض المطاعم",
                        "name_en" => "Restaurants",
                        "name_he" => "Restaurants",
                        "route" => "restaurants.index",
                        "icon_svg" => NULL,
                        "order" => 11,
                        "permission_name" => "restaurant_access",
                    ],
                    [
                        "name" => "إضافة المطاعم",
                        "name_en" => "Add Restaurants",
                        "name_he" => "Add Restaurants",
                        "route" => "restaurants.create",
                        "icon_svg" => NULL,
                        "order" => 12,
                        "permission_name" => "restaurant_access",
                    ]

                ]
            ],
            [
                "name" => "المنشآت",
                "name_en" => "Facility",
                "name_he" => "Facility",
                "route" => NULL,
                "icon_svg" => '<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Home/Door-open.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <title>Stockholm-icons / Home / Door-open</title>
    <desc></desc>
    <defs/>
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect opacity="0.300000012" x="0" y="0" width="24" height="24"/>
        <polygon fill="#fff" fill-rule="nonzero" opacity="0.3" points="7 4.89473684 7 21 5 21 5 3 11 3 11 4.89473684"/>
        <path d="M10.1782982,2.24743315 L18.1782982,3.6970464 C18.6540619,3.78325557 19,4.19751166 19,4.68102291 L19,19.3190064 C19,19.8025177 18.6540619,20.2167738 18.1782982,20.3029829 L10.1782982,21.7525962 C9.63486295,21.8510675 9.11449486,21.4903531 9.0160235,20.9469179 C9.00536265,20.8880837 9,20.8284119 9,20.7686197 L9,3.23140966 C9,2.67912491 9.44771525,2.23140966 10,2.23140966 C10.0597922,2.23140966 10.119464,2.2367723 10.1782982,2.24743315 Z M11.9166667,12.9060229 C12.6070226,12.9060229 13.1666667,12.2975724 13.1666667,11.5470105 C13.1666667,10.7964487 12.6070226,10.1879981 11.9166667,10.1879981 C11.2263107,10.1879981 10.6666667,10.7964487 10.6666667,11.5470105 C10.6666667,12.2975724 11.2263107,12.9060229 11.9166667,12.9060229 Z" fill="#fff"/>
    </g>
</svg><!--end::Svg Icon-->',
                "order" => 10,
                "permission_name" => NULL,
                "subRoutes" => [
                    [
                        "name" => "عرض المنشآت",
                        "name_en" => "Facilities",
                        "name_he" => "Facilities",
                        "route" => "facilities.index",
                        "icon_svg" => NULL,
                        "order" => 11,
                        "permission_name" => "facility_access",
                    ],
                    [
                        "name" => "إضافة المنشآت",
                        "name_en" => "Add Facilities",
                        "name_he" => "Add Facilities",
                        "route" => "facilities.create",
                        "icon_svg" => NULL,
                        "order" => 12,
                        "permission_name" => "facility_access",
                    ]

                ]
            ],
            [
                "name" => "الكباتن",
                "name_en" => "Captain",
                "name_he" => "Captain",
                "route" => NULL,
                "icon_svg" => '<!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/communication/com014.svg-->
                            <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.0173 9H15.3945C14.2833 9 13.263 9.61425 12.7431 10.5963L12.154 11.7091C12.0645 11.8781 12.1072 12.0868 12.2559 12.2071L12.6402 12.5183C13.2631 13.0225 13.7556 13.6691 14.0764 14.4035L14.2321 14.7601C14.2957 14.9058 14.4396 15 14.5987 15H18.6747C19.7297 15 20.4057 13.8774 19.912 12.945L18.6686 10.5963C18.1487 9.61425 17.1285 9 16.0173 9Z" fill="currentColor"/>
                            <rect opacity="0.3" x="14" y="4" width="4" height="4" rx="2" fill="currentColor"/>
                            <path d="M4.65486 14.8559C5.40389 13.1224 7.11161 12 9 12C10.8884 12 12.5961 13.1224 13.3451 14.8559L14.793 18.2067C15.3636 19.5271 14.3955 21 12.9571 21H5.04292C3.60453 21 2.63644 19.5271 3.20698 18.2067L4.65486 14.8559Z" fill="currentColor"/>
                            <rect opacity="0.3" x="6" y="5" width="6" height="6" rx="3" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->',
                "order" => 13,
                "permission_name" => "captin_access",
                "subRoutes" => [
                    [
                        "name" => "عرض الكباتن",
                        "name_en" => "Captains",
                        "name_he" => "Captains",
                        "route" => "captins.index",
                        "icon_svg" => NULL,
                        "order" => 14,
                        "permission_name" => "captin_access",
                    ],
                    [
                        "name" => "إضافة الكباتن",
                        "name_en" => "Add Captins",
                        "name_he" => "Add Captins",
                        "route" => "captins.create",
                        "icon_svg" => NULL,
                        "order" => 15,
                        "permission_name" => "captin_access",
                    ]

                ]
            ],

            [
                "name" => t(Department::ui['p_ucf']),
                "name_en" => Department::ui['p_ucf'],
                "name_he" => Department::ui['p_ucf'],
                "route" => Department::ui['route'] . ".index|" . Department::ui['route'] . ".create",
                "icon_svg" => '<!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/communication/com014.svg-->
                            <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.0173 9H15.3945C14.2833 9 13.263 9.61425 12.7431 10.5963L12.154 11.7091C12.0645 11.8781 12.1072 12.0868 12.2559 12.2071L12.6402 12.5183C13.2631 13.0225 13.7556 13.6691 14.0764 14.4035L14.2321 14.7601C14.2957 14.9058 14.4396 15 14.5987 15H18.6747C19.7297 15 20.4057 13.8774 19.912 12.945L18.6686 10.5963C18.1487 9.61425 17.1285 9 16.0173 9Z" fill="currentColor"/>
                            <rect opacity="0.3" x="14" y="4" width="4" height="4" rx="2" fill="currentColor"/>
                            <path d="M4.65486 14.8559C5.40389 13.1224 7.11161 12 9 12C10.8884 12 12.5961 13.1224 13.3451 14.8559L14.793 18.2067C15.3636 19.5271 14.3955 21 12.9571 21H5.04292C3.60453 21 2.63644 19.5271 3.20698 18.2067L4.65486 14.8559Z" fill="currentColor"/>
                            <rect opacity="0.3" x="6" y="5" width="6" height="6" rx="3" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon-->',
                "order" => 13,

                "permission_name" => Department::ui['s_lcf'] . "_access",
                "subRoutes" => [
                    [
                        "name" => t(Department::ui['p_ucf']),
                        "name_en" => Department::ui['p_ucf'],
                        "name_he" => Department::ui['p_ucf'],
                        "route" => Department::ui['route'] . ".index|" . Department::ui['route'] . ".edit",
                        "icon_svg" => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M8 8C8 7.4 8.4 7 9 7H16V3C16 2.4 15.6 2 15 2H3C2.4 2 2 2.4 2 3V13C2 13.6 2.4 14 3 14H5V16.1C5 16.8 5.79999 17.1 6.29999 16.6L8 14.9V8Z" fill="currentColor"/>
                                        <path d="M22 8V18C22 18.6 21.6 19 21 19H19V21.1C19 21.8 18.2 22.1 17.7 21.6L15 18.9H9C8.4 18.9 8 18.5 8 17.9V7.90002C8 7.30002 8.4 6.90002 9 6.90002H21C21.6 7.00002 22 7.4 22 8ZM19 11C19 10.4 18.6 10 18 10H12C11.4 10 11 10.4 11 11C11 11.6 11.4 12 12 12H18C18.6 12 19 11.6 19 11ZM17 15C17 14.4 16.6 14 16 14H12C11.4 14 11 14.4 11 15C11 15.6 11.4 16 12 16H16C16.6 16 17 15.6 17 15Z" fill="currentColor"/>
                                        </svg>',
                        "order" => 32,
                        "permission_name" => Department::ui['s_lcf'] . "_access",
                    ],
                    [
                        "name" => t('Add ' . Department::ui['p_ucf']),
                        "name_en" => 'Add ' . Department::ui['p_ucf'],
                        "name_he" => 'Add ' . Department::ui['p_ucf'],
                        "route" => Department::ui['route'] . ".create",
                        "icon_svg" => NULL,
                        "order" => 15,
                        "permission_name" => Department::ui['s_lcf'] . "_create",
                    ]


                ],


            ],


            [
                "name" => "الزبائن",
                "name_en" => "Client",
                "name_he" => "Client",
                "route" => NULL,
                "icon_svg" => '<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/General/Smile.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"  viewBox="0 0 24 24" version="1.1">
    <title>Stockholm-icons / General / Smile</title>
    <desc></desc>
    <defs/>
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <rect fill="currentColor"  x="2" y="2" width="20" height="20" rx="10"/>
        <path d="M6.16794971,14.5547002 C5.86159725,14.0951715 5.98577112,13.4743022 6.4452998,13.1679497 C6.90482849,12.8615972 7.52569784,12.9857711 7.83205029,13.4452998 C8.9890854,15.1808525 10.3543313,16 12,16 C13.6456687,16 15.0109146,15.1808525 16.1679497,13.4452998 C16.4743022,12.9857711 17.0951715,12.8615972 17.5547002,13.1679497 C18.0142289,13.4743022 18.1384028,14.0951715 17.8320503,14.5547002 C16.3224187,16.8191475 14.3543313,18 12,18 C9.64566871,18 7.67758127,16.8191475 6.16794971,14.5547002 Z" fill="#000"/>
    </g>
</svg>',
                "order" => 13,
                "permission_name" => "client_access",
                "subRoutes" => [
                    [
                        "name" => "عرض الزبائن",
                        "name_en" => "Clients",
                        "name_he" => "Clients",
                        "route" => "clients.index",
                        "icon_svg" => NULL,
                        "order" => 14,
                        "permission_name" => "client_access",
                    ],
                    [
                        "name" => "إضافة الزبائن",
                        "name_en" => "Add Clients",
                        "name_he" => "Add Clients",
                        "route" => "clients.create",
                        "icon_svg" => NULL,
                        "order" => 15,
                        "permission_name" => "client_access",
                    ]

                ]
            ],


            [
                "name" => "المركبة",
                "name_en" => "Vehicle",
                "name_he" => "Vehicle",
                "route" => NULL,
                "icon_svg" => '<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo8/dist/../src/media/svg/icons/Devices/Generator.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <title>Stockholm-icons / Devices / Generator</title>
    <desc></desc>
    <defs/>
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <rect fill="currentColor" opacity="0.3" x="2" y="6" width="24" height="24" rx="2"/>
        <path d="M5,4 L7,4 C7.55228475,4 8,4.44771525 8,5 L8,6 L4,6 L4,5 C4,4.44771525 4.44771525,4 5,4 Z M17,4 L19,4 C19.5522847,4 20,4.44771525 20,5 L20,6 L16,6 L16,5 C16,4.44771525 16.4477153,4 17,4 Z" fill="#000000"/>
        <path d="M7,12 L7,11 C7,10.4477153 7.44771525,10 8,10 C8.55228475,10 9,10.4477153 9,11 L9,12 L10,12 C10.5522847,12 11,12.4477153 11,13 C11,13.5522847 10.5522847,14 10,14 L9,14 L9,15 C9,15.5522847 8.55228475,16 8,16 C7.44771525,16 7,15.5522847 7,15 L7,14 L6,14 C5.44771525,14 5,13.5522847 5,13 C5,12.4477153 5.44771525,12 6,12 L7,12 Z" fill="#000000"/>
        <rect fill="currentColor" x="14" y="12" width="4" height="2" rx="1"/>
    </g>
</svg>',
                "order" => 13,
                "permission_name" => "vehicle_access",
                "subRoutes" => [
                    [
                        "name" => "عرض المركبات",
                        "name_en" => "Vehicles",
                        "name_he" => "Vehicles",
                        "route" => "vehicles.index",
                        "icon_svg" => NULL,
                        "order" => 14,
                        "permission_name" => "vehicle_access",
                    ],
                    [
                        "name" => "إضافة مركبة",
                        "name_en" => "Add Vehicles",
                        "name_he" => "Add Vehicles",
                        "route" => "vehicles.create",
                        "icon_svg" => NULL,
                        "order" => 15,
                        "permission_name" => "vehicle_access",
                    ]

                ]
            ],

            [
                "name" => "شركات الإعلان",
                "name_en" => "Marketing Agency",
                "name_he" => "Marketing Agency",
                "route" => NULL,
                "icon_svg" => '<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Design/Bucket.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <title>Stockholm-icons / Design / Bucket</title>
    <desc></desc>
    <defs/>
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M5,5 L5,15 C5,15.5948613 5.25970314,16.1290656 5.6719139,16.4954176 C5.71978107,16.5379595 5.76682388,16.5788906 5.81365532,16.6178662 C5.82524933,16.6294602 15,7.45470952 15,7.45470952 C15,6.9962515 15,6.17801499 15,5 L5,5 Z M5,3 L15,3 C16.1045695,3 17,3.8954305 17,5 L17,15 C17,17.209139 15.209139,19 13,19 L7,19 C4.790861,19 3,17.209139 3,15 L3,5 C3,3.8954305 3.8954305,3 5,3 Z" fill="#fff" fill-rule="nonzero" transform="translate(10.000000, 11.000000) rotate(-315.000000) translate(-10.000000, -11.000000) "/>
        <path d="M20,22 C21.6568542,22 23,20.6568542 23,19 C23,17.8954305 22,16.2287638 20,14 C18,16.2287638 17,17.8954305 17,19 C17,20.6568542 18.3431458,22 20,22 Z" fill="#fff" opacity="0.3"/>
    </g>
</svg>',
                "order" => 10,
                "permission_name" => "marketingAgency_access",
                "subRoutes" => [
                    [
                        "name" => "عرض شركات الإعلان",
                        "name_en" => "MarketingAgencys",
                        "name_he" => "MarketingAgencys",
                        "route" => "marketingAgencys.index",
                        "icon_svg" => NULL,
                        "order" => 11,
                        "permission_name" => "marketingAgency_access",
                    ],
                    [
                        "name" => "إضافة شركة إعلان",
                        "name_en" => "Add Marketing Agencys",
                        "name_he" => "Add Marketing Agencys",
                        "route" => "marketingAgencys.create",
                        "icon_svg" => NULL,
                        "order" => 12,
                        "permission_name" => "marketingAgency_access",
                    ]

                ]
            ],

            [
                "name" => "شركات التأمين",
                "name_en" => "Insurance Company",
                "name_he" => "Insurance Company",
                "route" => NULL,
                "icon_svg" => '<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Shopping/Chart-bar3.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <title>Stockholm-icons / Shopping / Chart-bar3</title>
    <desc></desc>
    <defs/>
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <rect fill="#fff" opacity="0.3" x="7" y="4" width="3" height="13" rx="1.5"/>
        <rect fill="#fff" opacity="0.3" x="12" y="9" width="3" height="8" rx="1.5"/>
        <path d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z" fill="#000000" fill-rule="nonzero"/>
        <rect fill="#fff" opacity="0.3" x="17" y="11" width="3" height="6" rx="1.5"/>
    </g>
</svg>',
                "order" => 10,
                "permission_name" => "insuranceCompany_access",
                "subRoutes" => [
                    [
                        "name" => "عرض شركات التأمين",
                        "name_en" => "InsuranceCompanys",
                        "name_he" => "InsuranceCompanys",
                        "route" => "insuranceCompanys.index",
                        "icon_svg" => NULL,
                        "order" => 11,
                        "permission_name" => "insuranceCompany_access",
                    ],
                    [
                        "name" => "إضافة شركة تأمين",
                        "name_en" => "Add Insurance Companys",
                        "name_he" => "Add Insurance Companys",
                        "route" => "insuranceCompanys.create",
                        "icon_svg" => NULL,
                        "order" => 12,
                        "permission_name" => "insuranceCompany_access",
                    ]

                ]
            ],

            [
                "name" => "عرض وثيقة التأمين",
                "name_en" => "Policy Offer",
                "name_he" => "Policy Offer",
                "route" => NULL,
                "icon_svg" => '<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Design/Brush.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <title>Stockholm-icons / Design / Brush</title>
    <desc></desc>
    <defs/>
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M13.5,6 C13.33743,8.28571429 12.7799545,9.78571429 11.8275735,10.5 C11.8275735,10.5 12.5,4 10.5734853,2 C10.5734853,2 10.5734853,5.92857143 8.78777106,9.14285714 C7.95071887,10.6495511 7.00205677,12.1418252 7.00205677,14.1428571 C7.00205677,17 10.4697177,18 12.0049375,18 C13.8025422,18 17,17 17,13.5 C17,12.0608202 15.8333333,9.56082016 13.5,6 Z" fill="#fff"/>
        <path d="M9.72075922,20 L14.2792408,20 C14.7096712,20 15.09181,20.2754301 15.2279241,20.6837722 L16,23 L8,23 L8.77207592,20.6837722 C8.90818997,20.2754301 9.29032881,20 9.72075922,20 Z" fill="#000000" opacity="0.3"/>
    </g>
</svg><!--end::Svg Icon-->',
                "order" => 10,
                "permission_name" => "policyOffers_access",
                "subRoutes" => [
                    [
                        "name" => "عرض  وثيقة التأمين",
                        "name_en" => "Policy Offer",
                        "name_he" => "Policy Offer",
                        "route" => "policyOffers.index",
                        "icon_svg" => NULL,
                        "order" => 11,
                        "permission_name" => "policyOffers_access",
                    ],
                    [
                        "name" => "إضافة عرض وثيقة  تأمين",
                        "name_en" => "Add Policy Offers",
                        "name_he" => "Add Policy Offer",
                        "route" => "policyOffers.create",
                        "icon_svg" => NULL,
                        "order" => 12,
                        "permission_name" => "policyOffers_access",
                    ]

                ]
            ],


            [
                "name" => "المكالمات",
                "name_en" => "Calls",
                "name_he" => "Calls",
                "route" => "client_calls_actions.index|client_calls_actions.create",
                "icon_svg" => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3" d="M8 8C8 7.4 8.4 7 9 7H16V3C16 2.4 15.6 2 15 2H3C2.4 2 2 2.4 2 3V13C2 13.6 2.4 14 3 14H5V16.1C5 16.8 5.79999 17.1 6.29999 16.6L8 14.9V8Z" fill="currentColor"/>
                                <path d="M22 8V18C22 18.6 21.6 19 21 19H19V21.1C19 21.8 18.2 22.1 17.7 21.6L15 18.9H9C8.4 18.9 8 18.5 8 17.9V7.90002C8 7.30002 8.4 6.90002 9 6.90002H21C21.6 7.00002 22 7.4 22 8ZM19 11C19 10.4 18.6 10 18 10H12C11.4 10 11 10.4 11 11C11 11.6 11.4 12 12 12H18C18.6 12 19 11.6 19 11ZM17 15C17 14.4 16.6 14 16 14H12C11.4 14 11 14.4 11 15C11 15.6 11.4 16 12 16H16C16.6 16 17 15.6 17 15Z" fill="currentColor"/>
                                </svg>',
                "order" => 27,
                "permission_name" => "calls_module_access",
                "subRoutes" => [
                    [
                        "name" => "المكالمات",
                        "name_en" => "Calls",
                        "name_he" => "Calls",
                        "route" => "client_calls_actions.index|client_calls_actions.create",
                        "icon_svg" => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M8 8C8 7.4 8.4 7 9 7H16V3C16 2.4 15.6 2 15 2H3C2.4 2 2 2.4 2 3V13C2 13.6 2.4 14 3 14H5V16.1C5 16.8 5.79999 17.1 6.29999 16.6L8 14.9V8Z" fill="currentColor"/>
                                        <path d="M22 8V18C22 18.6 21.6 19 21 19H19V21.1C19 21.8 18.2 22.1 17.7 21.6L15 18.9H9C8.4 18.9 8 18.5 8 17.9V7.90002C8 7.30002 8.4 6.90002 9 6.90002H21C21.6 7.00002 22 7.4 22 8ZM19 11C19 10.4 18.6 10 18 10H12C11.4 10 11 10.4 11 11C11 11.6 11.4 12 12 12H18C18.6 12 19 11.6 19 11ZM17 15C17 14.4 16.6 14 16 14H12C11.4 14 11 14.4 11 15C11 15.6 11.4 16 12 16H16C16.6 16 17 15.6 17 15Z" fill="currentColor"/>
                                        </svg>',
                        "order" => 28,
                        "permission_name" => "calls_module_access",
                    ],
                    [
                        "name" => "المكالمات مهمات",
                        "name_en" => "Calls Tasks",
                        "name_he" => "Calls Tasks",
                        "route" => "call_tasks.index|call_tasks.create",
                        "icon_svg" => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M8 8C8 7.4 8.4 7 9 7H16V3C16 2.4 15.6 2 15 2H3C2.4 2 2 2.4 2 3V13C2 13.6 2.4 14 3 14H5V16.1C5 16.8 5.79999 17.1 6.29999 16.6L8 14.9V8Z" fill="currentColor"/>
                                        <path d="M22 8V18C22 18.6 21.6 19 21 19H19V21.1C19 21.8 18.2 22.1 17.7 21.6L15 18.9H9C8.4 18.9 8 18.5 8 17.9V7.90002C8 7.30002 8.4 6.90002 9 6.90002H21C21.6 7.00002 22 7.4 22 8ZM19 11C19 10.4 18.6 10 18 10H12C11.4 10 11 10.4 11 11C11 11.6 11.4 12 12 12H18C18.6 12 19 11.6 19 11ZM17 15C17 14.4 16.6 14 16 14H12C11.4 14 11 14.4 11 15C11 15.6 11.4 16 12 16H16C16.6 16 17 15.6 17 15Z" fill="currentColor"/>
                                        </svg>',
                        "order" => 29,
                        "permission_name" => "callTasks_module_access",
                    ],
                    [
                        "name" => "CDR",
                        "name_en" => "CDR",
                        "name_he" => "CDR",
                        "route" => "cdr.index",
                        "icon_svg" => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3" d="M5 15C3.3 15 2 13.7 2 12C2 10.3 3.3 9 5 9H5.10001C5.00001 8.7 5 8.3 5 8C5 5.2 7.2 3 10 3C11.9 3 13.5 4 14.3 5.5C14.8 5.2 15.4 5 16 5C17.7 5 19 6.3 19 8C19 8.4 18.9 8.7 18.8 9C18.9 9 18.9 9 19 9C20.7 9 22 10.3 22 12C22 13.7 20.7 15 19 15H5ZM5 12.6H13L9.7 9.29999C9.3 8.89999 8.7 8.89999 8.3 9.29999L5 12.6Z" fill="currentColor"/>
                                <path d="M17 17.4V12C17 11.4 16.6 11 16 11C15.4 11 15 11.4 15 12V17.4H17Z" fill="currentColor"/>
                                <path opacity="0.3" d="M12 17.4H20L16.7 20.7C16.3 21.1 15.7 21.1 15.3 20.7L12 17.4Z" fill="currentColor"/>
                                <path d="M8 12.6V18C8 18.6 8.4 19 9 19C9.6 19 10 18.6 10 18V12.6H8Z" fill="currentColor"/>
                                </svg>',
                        "order" => 30,
                        "permission_name" => "cdr_access",
                    ],
                ],

            ],

            [
                'name' => t(splitAndUppercase('Wheels Vists'), [], 'ar'),
                'name_en' => t(splitAndUppercase('Wheels Vists'), [], 'en'),
                'name_he' => t(splitAndUppercase('Wheels Vists'), [], 'en'),
                "route" => "visits.index|visits.create",
                "icon_svg" => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <title>Stockholm-icons / Communication / Clipboard-check</title>
    <desc></desc>
    <defs/>
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="currentColor" />
        <path d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z" fill="#000000"/>
        <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000"/>
    </g>
</svg>',
                "order" => 29,
                "permission_name" => "visits_module_access",
                "subRoutes" => [
                    [
                        'name' => t(splitAndUppercase('Wheels Vists'), [], 'ar'),
                        'name_en' => t(splitAndUppercase('Wheels Vists'), [], 'en'),
                        'name_he' => t(splitAndUppercase('Wheels Vists'), [], 'en'),
                        "route" => "visits.index|visits.create",
                        "icon_svg" => '',
                        "order" => 30,
                        "permission_name" => "visits_module_access",
                    ],


                ],

            ],
            [
                "name" => " طلبات الزيارات",
                "name_en" => "Visit Requests",
                "name_he" => "Visit Requests",
                "route" => "visitRequests.index|visitRequests.create",
                "icon_svg" => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <title>Stockholm-icons / Communication / Clipboard-check</title>
    <desc></desc>
    <defs/>
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="currentColor" />
        <path d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z" fill="#000000"/>
        <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000"/>
    </g>
</svg>',
                "order" => 29,
                "permission_name" => "visits_module_access",
                "subRoutes" => [


                    [
                        "name" => " طللب الزيارات",
                        "name_en" => "Visit Requests",
                        "name_he" => "Visit Requests",
                        "route" => "visitRequests.index|visitRequests.create",
                        "icon_svg" => '',
                        "order" => 31,
                        "permission_name" => "visitRequest_module_access",
                    ],


                ],

            ],
            [
                "name" => "التذاكر",
                "name_en" => "Tickets",
                "name_he" => "Tickets",
                "route" => "tickets.index|tickets.create",
                "icon_svg" => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <title>Stockholm-icons / Shopping / Bag2</title>
    <desc></desc>
    <defs/>
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M5.94290508,4 L18.0570949,4 C18.5865712,4 19.0242774,4.41271535 19.0553693,4.94127798 L19.8754445,18.882556 C19.940307,19.9852194 19.0990032,20.9316862 17.9963398,20.9965487 C17.957234,20.9988491 17.9180691,21 17.8788957,21 L6.12110428,21 C5.01653478,21 4.12110428,20.1045695 4.12110428,19 C4.12110428,18.9608266 4.12225519,18.9216617 4.12455553,18.882556 L4.94463071,4.94127798 C4.97572263,4.41271535 5.41342877,4 5.94290508,4 Z" fill="currentColor" />
        <path d="M7,7 L9,7 C9,8.65685425 10.3431458,10 12,10 C13.6568542,10 15,8.65685425 15,7 L17,7 C17,9.76142375 14.7614237,12 12,12 C9.23857625,12 7,9.76142375 7,7 Z" fill="#000000"/>
    </g>
</svg>',
                "order" => 31,
                "permission_name" => "tickets_module_access",
                "subRoutes" => [
                    [
                        "name" => "التذاكر",
                        "name_en" => "Tickets",
                        "name_he" => "Tickets",
                        "route" => "tickets.index|tickets.create",
                        "icon_svg" => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M8 8C8 7.4 8.4 7 9 7H16V3C16 2.4 15.6 2 15 2H3C2.4 2 2 2.4 2 3V13C2 13.6 2.4 14 3 14H5V16.1C5 16.8 5.79999 17.1 6.29999 16.6L8 14.9V8Z" fill="currentColor"/>
                                        <path d="M22 8V18C22 18.6 21.6 19 21 19H19V21.1C19 21.8 18.2 22.1 17.7 21.6L15 18.9H9C8.4 18.9 8 18.5 8 17.9V7.90002C8 7.30002 8.4 6.90002 9 6.90002H21C21.6 7.00002 22 7.4 22 8ZM19 11C19 10.4 18.6 10 18 10H12C11.4 10 11 10.4 11 11C11 11.6 11.4 12 12 12H18C18.6 12 19 11.6 19 11ZM17 15C17 14.4 16.6 14 16 14H12C11.4 14 11 14.4 11 15C11 15.6 11.4 16 12 16H16C16.6 16 17 15.6 17 15Z" fill="currentColor"/>
                                        </svg>',
                        "order" => 32,
                        "permission_name" => "tickets_module_access",
                    ],


                ],

            ],
            [
                "name" => "الطلبات",
                "name_en" => "Orders",
                "name_he" => "Orders",
                "route" => "orders.index|orders.create",
                "icon_svg" => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <title></title>
    <desc></desc>
    <defs/>
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z" fill="currentColor" fill-rule="nonzero" opacity="0.3"/>
        <path d="M3.28077641,9 L20.7192236,9 C21.2715083,9 21.7192236,9.44771525 21.7192236,10 C21.7192236,10.0817618 21.7091962,10.163215 21.6893661,10.2425356 L19.5680983,18.7276069 C19.234223,20.0631079 18.0342737,21 16.6576708,21 L7.34232922,21 C5.96572629,21 4.76577697,20.0631079 4.43190172,18.7276069 L2.31063391,10.2425356 C2.17668518,9.70674072 2.50244587,9.16380623 3.03824078,9.0298575 C3.11756139,9.01002735 3.1990146,9 3.28077641,9 Z M12,12 C11.4477153,12 11,12.4477153 11,13 L11,17 C11,17.5522847 11.4477153,18 12,18 C12.5522847,18 13,17.5522847 13,17 L13,13 C13,12.4477153 12.5522847,12 12,12 Z M6.96472382,12.1362967 C6.43125772,12.2792385 6.11467523,12.8275755 6.25761704,13.3610416 L7.29289322,17.2247449 C7.43583503,17.758211 7.98417199,18.0747935 8.51763809,17.9318517 C9.05110419,17.7889098 9.36768668,17.2405729 9.22474487,16.7071068 L8.18946869,12.8434035 C8.04652688,12.3099374 7.49818992,11.9933549 6.96472382,12.1362967 Z M17.0352762,12.1362967 C16.5018101,11.9933549 15.9534731,12.3099374 15.8105313,12.8434035 L14.7752551,16.7071068 C14.6323133,17.2405729 14.9488958,17.7889098 15.4823619,17.9318517 C16.015828,18.0747935 16.564165,17.758211 16.7071068,17.2247449 L17.742383,13.3610416 C17.8853248,12.8275755 17.5687423,12.2792385 17.0352762,12.1362967 Z" fill="currentColor"/>
    </g>
</svg>',
                "order" => 31,
                "permission_name" => "orders_module_access",
                "subRoutes" => [
                    [
                        "name" => "الطلبات",
                        "name_en" => "Orders",
                        "name_he" => "Orders",
                        "route" => "orders.index|orders.create",
                        "icon_svg" => '',
                        "order" => 32,
                        "permission_name" => "orders_module_access",
                    ],


                ],

            ],
            [
                "name" => t(Lead::ui['p_ucf']),
                "name_en" => Lead::ui['p_ucf'],
                "name_he" => Lead::ui['p_ucf'],
                "route" => Lead::ui['route'] . ".index|" . Lead::ui['route'] . ".create",
                //  "route" => "leads.index|leads.create",
                "icon_svg" => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <title>Stockholm-icons / Communication / Readed-mail</title>
    <desc></desc>
    <defs/>
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M4.875,20.75 C4.63541667,20.75 4.39583333,20.6541667 4.20416667,20.4625 L2.2875,18.5458333 C1.90416667,18.1625 1.90416667,17.5875 2.2875,17.2041667 C2.67083333,16.8208333 3.29375,16.8208333 3.62916667,17.2041667 L4.875,18.45 L8.0375,15.2875 C8.42083333,14.9041667 8.99583333,14.9041667 9.37916667,15.2875 C9.7625,15.6708333 9.7625,16.2458333 9.37916667,16.6291667 L5.54583333,20.4625 C5.35416667,20.6541667 5.11458333,20.75 4.875,20.75 Z" fill="#fff" fill-rule="nonzero" opacity="0.3"/>
        <path d="M12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.98630124,11 4.48466491,11.0516454 4,11.1500272 L4,7 C4,5.8954305 4.8954305,5 6,5 L20,5 C21.1045695,5 22,5.8954305 22,7 L22,16 C22,17.1045695 21.1045695,18 20,18 L12.9835977,18 Z M19.1444251,6.83964668 L13,10.1481833 L6.85557487,6.83964668 C6.4908718,6.6432681 6.03602525,6.77972206 5.83964668,7.14442513 C5.6432681,7.5091282 5.77972206,7.96397475 6.14442513,8.16035332 L12.6444251,11.6603533 C12.8664074,11.7798822 13.1335926,11.7798822 13.3555749,11.6603533 L19.8555749,8.16035332 C20.2202779,7.96397475 20.3567319,7.5091282 20.1603533,7.14442513 C19.9639747,6.77972206 19.5091282,6.6432681 19.1444251,6.83964668 Z" fill="#fff"/>
    </g>
</svg>',
                "order" => 31,
                "permission_name" => "lead_access",
                "subRoutes" => [
                    [
                        "name" => t(Lead::ui['p_ucf']),
                        "name_en" => Lead::ui['p_ucf'],
                        "name_he" => Lead::ui['p_ucf'],
                        "route" => Lead::ui['route'] . ".index|" . Lead::ui['route'] . ".create",
                        // "route" => "leads.index|leads.create",
                        "icon_svg" => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M8 8C8 7.4 8.4 7 9 7H16V3C16 2.4 15.6 2 15 2H3C2.4 2 2 2.4 2 3V13C2 13.6 2.4 14 3 14H5V16.1C5 16.8 5.79999 17.1 6.29999 16.6L8 14.9V8Z" fill="currentColor"/>
                                        <path d="M22 8V18C22 18.6 21.6 19 21 19H19V21.1C19 21.8 18.2 22.1 17.7 21.6L15 18.9H9C8.4 18.9 8 18.5 8 17.9V7.90002C8 7.30002 8.4 6.90002 9 6.90002H21C21.6 7.00002 22 7.4 22 8ZM19 11C19 10.4 18.6 10 18 10H12C11.4 10 11 10.4 11 11C11 11.6 11.4 12 12 12H18C18.6 12 19 11.6 19 11ZM17 15C17 14.4 16.6 14 16 14H12C11.4 14 11 14.4 11 15C11 15.6 11.4 16 12 16H16C16.6 16 17 15.6 17 15Z" fill="currentColor"/>
                                        </svg>',
                        "order" => 32,
                        "permission_name" => "lead_access",
                    ],


                ],

            ],
            [
                "name" => "العروض",
                "name_en" => "Offers",
                "name_he" => "Offers",
                "route" => Offer::ui['route'] . ".index|" . Offer::ui['route'] . ".create|" . Offer::ui['route'] . ".edit",
                // "route" => "offers.index|offers.create",
                "icon_svg" => '<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Files/Compiled-file.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <title>Stockholm-icons / Files / Compiled-file</title>
                                <desc></desc>
                                <defs/>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                    <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#fff" fill-rule="nonzero" opacity="0.3"/>
                                    <rect fill="#fff" opacity="0.3" transform="translate(8.984240, 12.127098) rotate(-45.000000) translate(-8.984240, -12.127098) " x="7.41281179" y="10.5556689" width="3.14285714" height="3.14285714" rx="0.75"/>
                                    <rect fill="#fff" opacity="0.3" transform="translate(15.269955, 12.127098) rotate(-45.000000) translate(-15.269955, -12.127098) " x="13.6985261" y="10.5556689" width="3.14285714" height="3.14285714" rx="0.75"/>
                                    <rect fill="#fff" transform="translate(12.127098, 15.269955) rotate(-45.000000) translate(-12.127098, -15.269955) " x="10.5556689" y="13.6985261" width="3.14285714" height="3.14285714" rx="0.75"/>
                                    <rect fill="#fff" transform="translate(12.127098, 8.984240) rotate(-45.000000) translate(-12.127098, -8.984240) " x="10.5556689" y="7.41281179" width="3.14285714" height="3.14285714" rx="0.75"/>
                                </g>
                            </svg>',
                "order" => 31,
                "permission_name" => "offer_access",
                "subRoutes" => [
                    [
                        "name" => "العروض",
                        "name_en" => "Offers",
                        "name_he" => "Offers",
                        "route" => Offer::ui['route'] . ".index|" . Offer::ui['route'] . ".create|" . Offer::ui['route'] . ".edit",
                        "icon_svg" => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M8 8C8 7.4 8.4 7 9 7H16V3C16 2.4 15.6 2 15 2H3C2.4 2 2 2.4 2 3V13C2 13.6 2.4 14 3 14H5V16.1C5 16.8 5.79999 17.1 6.29999 16.6L8 14.9V8Z" fill="currentColor"/>
                                        <path d="M22 8V18C22 18.6 21.6 19 21 19H19V21.1C19 21.8 18.2 22.1 17.7 21.6L15 18.9H9C8.4 18.9 8 18.5 8 17.9V7.90002C8 7.30002 8.4 6.90002 9 6.90002H21C21.6 7.00002 22 7.4 22 8ZM19 11C19 10.4 18.6 10 18 10H12C11.4 10 11 10.4 11 11C11 11.6 11.4 12 12 12H18C18.6 12 19 11.6 19 11ZM17 15C17 14.4 16.6 14 16 14H12C11.4 14 11 14.4 11 15C11 15.6 11.4 16 12 16H16C16.6 16 17 15.6 17 15Z" fill="currentColor"/>
                                        </svg>',
                        "order" => 32,
                        "permission_name" => "offer_access",
                    ],


                ],

            ],
            [
                "name" => t(Contract::ui['p_ucf']),
                "name_en" => Contract::ui['p_ucf'],
                "name_he" => Contract::ui['p_ucf'],
                "route" => Contract::ui['route'] . ".index|" . Contract::ui['route'] . ".create",
                "icon_svg" => '<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Files/Compiled-file.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <title>Stockholm-icons / Files / Compiled-file</title>
                                <desc></desc>
                                <defs/>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                    <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#fff" fill-rule="nonzero" opacity="0.3"/>
                                    <rect fill="#fff" opacity="0.3" transform="translate(8.984240, 12.127098) rotate(-45.000000) translate(-8.984240, -12.127098) " x="7.41281179" y="10.5556689" width="3.14285714" height="3.14285714" rx="0.75"/>
                                    <rect fill="#fff" opacity="0.3" transform="translate(15.269955, 12.127098) rotate(-45.000000) translate(-15.269955, -12.127098) " x="13.6985261" y="10.5556689" width="3.14285714" height="3.14285714" rx="0.75"/>
                                    <rect fill="#fff" transform="translate(12.127098, 15.269955) rotate(-45.000000) translate(-12.127098, -15.269955) " x="10.5556689" y="13.6985261" width="3.14285714" height="3.14285714" rx="0.75"/>
                                    <rect fill="#fff" transform="translate(12.127098, 8.984240) rotate(-45.000000) translate(-12.127098, -8.984240) " x="10.5556689" y="7.41281179" width="3.14285714" height="3.14285714" rx="0.75"/>
                                </g>
                            </svg>',
                "order" => 31,
                "permission_name" => Contract::ui['s_lcf'] . "_access",
                "subRoutes" => [
                    [
                        "name" => t(Contract::ui['p_ucf']),
                        "name_en" => Contract::ui['p_ucf'],
                        "name_he" => Contract::ui['p_ucf'],
                        "route" => Contract::ui['route'] . ".index|" . Contract::ui['route'] . ".create",
                        "icon_svg" => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M8 8C8 7.4 8.4 7 9 7H16V3C16 2.4 15.6 2 15 2H3C2.4 2 2 2.4 2 3V13C2 13.6 2.4 14 3 14H5V16.1C5 16.8 5.79999 17.1 6.29999 16.6L8 14.9V8Z" fill="currentColor"/>
                                        <path d="M22 8V18C22 18.6 21.6 19 21 19H19V21.1C19 21.8 18.2 22.1 17.7 21.6L15 18.9H9C8.4 18.9 8 18.5 8 17.9V7.90002C8 7.30002 8.4 6.90002 9 6.90002H21C21.6 7.00002 22 7.4 22 8ZM19 11C19 10.4 18.6 10 18 10H12C11.4 10 11 10.4 11 11C11 11.6 11.4 12 12 12H18C18.6 12 19 11.6 19 11ZM17 15C17 14.4 16.6 14 16 14H12C11.4 14 11 14.4 11 15C11 15.6 11.4 16 12 16H16C16.6 16 17 15.6 17 15Z" fill="currentColor"/>
                                        </svg>',
                        "order" => 32,
                        "permission_name" => Contract::ui['s_lcf'] . "_access",
                    ],


                ],

            ],
            [
                "name" => t(Project::ui['p_ucf']),
                "name_en" => Project::ui['p_ucf'],
                "name_he" => Project::ui['p_ucf'],
                "route" => Project::ui['route'] . ".index|" . Project::ui['route'] . ".create",
                "icon_svg" => '<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Files/Compiled-file.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <title>Stockholm-icons / Files / Compiled-file</title>
                                <desc></desc>
                                <defs/>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                    <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#fff" fill-rule="nonzero" opacity="0.3"/>
                                    <rect fill="#fff" opacity="0.3" transform="translate(8.984240, 12.127098) rotate(-45.000000) translate(-8.984240, -12.127098) " x="7.41281179" y="10.5556689" width="3.14285714" height="3.14285714" rx="0.75"/>
                                    <rect fill="#fff" opacity="0.3" transform="translate(15.269955, 12.127098) rotate(-45.000000) translate(-15.269955, -12.127098) " x="13.6985261" y="10.5556689" width="3.14285714" height="3.14285714" rx="0.75"/>
                                    <rect fill="#fff" transform="translate(12.127098, 15.269955) rotate(-45.000000) translate(-12.127098, -15.269955) " x="10.5556689" y="13.6985261" width="3.14285714" height="3.14285714" rx="0.75"/>
                                    <rect fill="#fff" transform="translate(12.127098, 8.984240) rotate(-45.000000) translate(-12.127098, -8.984240) " x="10.5556689" y="7.41281179" width="3.14285714" height="3.14285714" rx="0.75"/>
                                </g>
                            </svg>',
                "order" => 31,
                "permission_name" => Project::ui['s_lcf'] . "_access",
                "subRoutes" => [
                    [
                        "name" => t(Project::ui['p_ucf']),
                        "name_en" => Project::ui['p_ucf'],
                        "name_he" => Project::ui['p_ucf'],
                        "route" => Project::ui['route'] . ".index|" . Project::ui['route'] . ".create",
                        "icon_svg" => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M8 8C8 7.4 8.4 7 9 7H16V3C16 2.4 15.6 2 15 2H3C2.4 2 2 2.4 2 3V13C2 13.6 2.4 14 3 14H5V16.1C5 16.8 5.79999 17.1 6.29999 16.6L8 14.9V8Z" fill="currentColor"/>
                                        <path d="M22 8V18C22 18.6 21.6 19 21 19H19V21.1C19 21.8 18.2 22.1 17.7 21.6L15 18.9H9C8.4 18.9 8 18.5 8 17.9V7.90002C8 7.30002 8.4 6.90002 9 6.90002H21C21.6 7.00002 22 7.4 22 8ZM19 11C19 10.4 18.6 10 18 10H12C11.4 10 11 10.4 11 11C11 11.6 11.4 12 12 12H18C18.6 12 19 11.6 19 11ZM17 15C17 14.4 16.6 14 16 14H12C11.4 14 11 14.4 11 15C11 15.6 11.4 16 12 16H16C16.6 16 17 15.6 17 15Z" fill="currentColor"/>
                                        </svg>',
                        "order" => 32,
                        "permission_name" => Project::ui['s_lcf'] . "_access",
                    ],


                ],

            ],
            [
                "name" => t(Task::ui['p_ucf']),
                "name_en" => Task::ui['p_ucf'],
                "name_he" => Task::ui['p_ucf'],
                "route" => Task::ui['route'] . ".index|" . Task::ui['route'] . ".create",
                "icon_svg" => '<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Files/Compiled-file.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <title>Stockholm-icons / Files / Compiled-file</title>
                                <desc></desc>
                                <defs/>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                    <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#fff" fill-rule="nonzero" opacity="0.3"/>
                                    <rect fill="#fff" opacity="0.3" transform="translate(8.984240, 12.127098) rotate(-45.000000) translate(-8.984240, -12.127098) " x="7.41281179" y="10.5556689" width="3.14285714" height="3.14285714" rx="0.75"/>
                                    <rect fill="#fff" opacity="0.3" transform="translate(15.269955, 12.127098) rotate(-45.000000) translate(-15.269955, -12.127098) " x="13.6985261" y="10.5556689" width="3.14285714" height="3.14285714" rx="0.75"/>
                                    <rect fill="#fff" transform="translate(12.127098, 15.269955) rotate(-45.000000) translate(-12.127098, -15.269955) " x="10.5556689" y="13.6985261" width="3.14285714" height="3.14285714" rx="0.75"/>
                                    <rect fill="#fff" transform="translate(12.127098, 8.984240) rotate(-45.000000) translate(-12.127098, -8.984240) " x="10.5556689" y="7.41281179" width="3.14285714" height="3.14285714" rx="0.75"/>
                                </g>
                            </svg>',
                "order" => 31,
                "permission_name" => Task::ui['s_lcf'] . "_access",
                "subRoutes" => [
                    [
                        "name" => t(Task::ui['p_ucf']),
                        "name_en" => Task::ui['p_ucf'],
                        "name_he" => Task::ui['p_ucf'],
                        "route" => Task::ui['route'] . ".index|" . Task::ui['route'] . ".create",
                        "icon_svg" => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M8 8C8 7.4 8.4 7 9 7H16V3C16 2.4 15.6 2 15 2H3C2.4 2 2 2.4 2 3V13C2 13.6 2.4 14 3 14H5V16.1C5 16.8 5.79999 17.1 6.29999 16.6L8 14.9V8Z" fill="currentColor"/>
                                        <path d="M22 8V18C22 18.6 21.6 19 21 19H19V21.1C19 21.8 18.2 22.1 17.7 21.6L15 18.9H9C8.4 18.9 8 18.5 8 17.9V7.90002C8 7.30002 8.4 6.90002 9 6.90002H21C21.6 7.00002 22 7.4 22 8ZM19 11C19 10.4 18.6 10 18 10H12C11.4 10 11 10.4 11 11C11 11.6 11.4 12 12 12H18C18.6 12 19 11.6 19 11ZM17 15C17 14.4 16.6 14 16 14H12C11.4 14 11 14.4 11 15C11 15.6 11.4 16 12 16H16C16.6 16 17 15.6 17 15Z" fill="currentColor"/>
                                        </svg>',
                        "order" => 32,
                        "permission_name" => Task::ui['s_lcf'] . "_access",
                    ],


                ],

            ],



            [
                "name" => "زبائن تريليونز",
                "name_en" => "Trillions Client",
                "name_he" => "Trillions Client",
                "route" => NULL,
                "icon_svg" => '<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo8/dist/../src/media/svg/icons/Food/Carrot.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <title>Stockholm-icons / Food / Carrot</title>
    <desc></desc>
    <defs/>
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M14.3724866,0.190822526 C11.3151949,5.41320416 11.3151949,9.23673357 14.3724866,11.6614108 C17.3047782,9.23673357 17.3047782,5.41320416 14.3724866,0.190822526 Z" fill="#fff" opacity="0.3" transform="translate(14.325612, 5.926117) scale(-1, 1) rotate(-195.000000) translate(-14.325612, -5.926117) "/>
        <path d="M17.5544671,3.37280304 C14.4971754,8.59518468 14.4971754,12.4187141 17.5544671,14.8433913 C20.4867588,12.4187141 20.4867588,8.59518468 17.5544671,3.37280304 Z" fill="#fff" opacity="0.3" transform="translate(17.507592, 9.108097) rotate(-645.000000) translate(-17.507592, -9.108097) "/>
        <path d="M15.9634768,1.78181278 C12.9061852,7.00419442 12.9061852,10.8277238 15.9634768,13.252401 C18.8957685,10.8277238 18.8957685,7.00419442 15.9634768,1.78181278 Z" fill="#fff" opacity="0.3" transform="translate(15.916602, 7.517107) rotate(-315.000000) translate(-15.916602, -7.517107) "/>
        <path d="M2.57844233,17.5134712 L2.86827202,17.8033009 C3.25879631,18.1938252 3.89196129,18.1938252 4.28248558,17.8033009 C4.67300987,17.4127766 4.67300987,16.7796116 4.28248558,16.3890873 L3.59132296,15.6979247 L4.60420359,13.8823782 L5.69669914,14.9748737 C6.08722343,15.365398 6.72038841,15.365398 7.1109127,14.9748737 C7.501437,14.5843494 7.501437,13.9511845 7.1109127,13.5606602 L5.69669914,12.1464466 C5.6702016,12.1199491 5.64258699,12.0952494 5.6140069,12.0723477 L6.62996485,10.2512852 L8.52512627,12.1464466 C8.91565056,12.5369709 9.54881554,12.5369709 9.93933983,12.1464466 C10.3298641,11.7559223 10.3298641,11.1227573 9.93933983,10.732233 L7.81801948,8.6109127 C7.75963657,8.55252979 7.69583066,8.50287505 7.62822323,8.46194849 L7.87276434,8.02361869 C8.41091279,7.05900994 9.62913819,6.71329556 10.5937469,7.251444 C10.7549891,7.34139987 10.9029979,7.45325048 11.0335565,7.58380908 L15.9162516,12.4665041 C16.6973001,13.2475527 16.6973001,14.5138826 15.9162516,15.2949312 C15.785693,15.4254898 15.6376841,15.5373404 15.476442,15.6272963 L3.46875087,22.3263028 C2.81004861,22.6937881 1.98744333,22.5793264 1.45408877,22.0459719 C0.920734216,21.5126173 0.806272498,20.690012 1.17375786,20.0313098 L2.57844233,17.5134712 Z" fill="#fff"/>
    </g>
</svg><!--end::Svg Icon-->',
                "order" => 13,
                "permission_name" => "clientTrillion_access,claim_access",
                "subRoutes" => [
                    [
                        "name" => "زبائن تريليونز",
                        "name_en" => "Trillions Client",
                        "name_he" => "Trillions Client",
                        "route" => "clientTrillions.index",
                        "icon_svg" => NULL,
                        "order" => 14,
                        "permission_name" => "clientTrillion_access",
                    ],
                    [
                        "name" => "إضافة زبائن تريليونز",
                        "name_en" => "Add Trillions Clients",
                        "name_he" => "Add Trillions Clients",
                        "route" => "clientTrillions.create",
                        "icon_svg" => NULL,
                        "order" => 15,
                        "permission_name" => "clientTrillion_access",
                    ],
                    [
                        "name" => " مطالبات",
                        "name_en" => "Claims",
                        "name_he" => "Claims",
                        "route" => "claims.index",
                        "icon_svg" => NULL,
                        "order" => 16,
                        "permission_name" => "claim_access",
                    ]

                ]
            ],
            [
                "name" => "الموظفين",
                "name_en" => "Employees",
                "name_he" => "Employees",
                "route" => NULL,
                "icon_svg" => '<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Home/Flower2.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <title></title>
    <desc></desc>
    <defs/>
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <polygon points="0 0 24 0 24 24 0 24"/>
        <circle fill="#fff" opacity="0.3" cx="15" cy="17" r="5"/>
        <circle fill="#fff" opacity="0.3" cx="9" cy="17" r="5"/>
        <circle fill="#fff" opacity="0.3" cx="7" cy="11" r="5"/>
        <circle fill="#fff" opacity="0.3" cx="17" cy="11" r="5"/>
        <circle fill="#fff" opacity="0.3" cx="12" cy="7" r="5"/>
    </g>
</svg><!--end::Svg Icon-->',
                "order" => 20,
                "permission_name" => "employee_access",
                "subRoutes" => [
                    [
                        "name" => "الموظفين",
                        "name_en" => "Employees",
                        "name_he" => "Employees",
                        "route" => "employees.index",
                        "icon_svg" => NULL,
                        "order" => 14,
                        "permission_name" => "employee_access",
                    ],
                    [
                        "name" => "إضافة الموظفين",
                        "name_en" => "Add Employees",
                        "name_he" => "Add Employees",
                        "route" => "employees.create",
                        "icon_svg" => NULL,
                        "order" => 15,
                        "permission_name" => "employee_access",
                    ]

                ]
            ],
            [
                "name" => "ملف الموظف",
                "name_en" => "Employee Profile",
                "name_he" => "Employee Profile",
                "route" => NULL,
                "icon_svg" => '<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Home/Flower2.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <title></title>
    <desc></desc>
    <defs/>
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <polygon points="0 0 24 0 24 24 0 24"/>
        <circle fill="#fff" opacity="0.3" cx="15" cy="17" r="5"/>
        <circle fill="#fff" opacity="0.3" cx="9" cy="17" r="5"/>
        <circle fill="#fff" opacity="0.3" cx="7" cy="11" r="5"/>
        <circle fill="#fff" opacity="0.3" cx="17" cy="11" r="5"/>
        <circle fill="#fff" opacity="0.3" cx="12" cy="7" r="5"/>
    </g>
</svg><!--end::Svg Icon-->',
                "order" => 20,
                "permission_name" => "employee_access",
                "subRoutes" => [

                    [
                        "name" => "ملفي الوظيفي",
                        "name_en" => "Employee Profile",
                        "name_he" => "Employee Profile",
                        "route" => "myemployees.edit",
                        "icon_svg" => NULL,
                        "order" => 15,
                        "permission_name" => "myemployee_access",
                    ]

                ]
            ]

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

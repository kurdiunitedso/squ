<?php

namespace Database\Seeders;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Models\Constant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Constants extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $IDENTITY_TYPE = [
            ['name' => 'الجهة المسؤولة', 'value' => 'الجهة المسؤولة', 'module' => Modules::TICKET, 'field' => DropDownFields::targets],
            ['name' => 'بخصوص', 'value' => 'بخصوص', 'module' => Modules::TICKET, 'field' => DropDownFields::destinations],
            ['name' => 'cheif', 'value' => 'cheif', 'module' => Modules::RESTAURANT, 'field' => DropDownFields::titles],
            ['name' => 'epson', 'value' => 'epson', 'module' => Modules::RESTAURANT, 'field' => DropDownFields::printer_type],
            ['name' => 'Saturday', 'value' => 'Saturday', 'module' => Modules::CAPTIN, 'field' => DropDownFields::work_days],
            ['name' => 'Sunday', 'value' => 'Sunday', 'module' => Modules::CAPTIN, 'field' => DropDownFields::work_days],
            ['name' => 'Monday', 'value' => 'Monday', 'module' => Modules::CAPTIN, 'field' => DropDownFields::work_days],
            ['name' => 'Tuesday', 'value' => 'Tuesday', 'module' => Modules::CAPTIN, 'field' => DropDownFields::work_days],
            ['name' => 'Wednesday', 'value' => 'Wednesday', 'module' => Modules::CAPTIN, 'field' => DropDownFields::work_days],
            ['name' => 'Thursday', 'value' => 'Thursday', 'module' => Modules::CAPTIN, 'field' => DropDownFields::work_days],
            ['name' => 'Friday', 'value' => 'Friday', 'module' => Modules::CAPTIN, 'field' => DropDownFields::work_days],
            ['name' => 'ممتاز', 'value' => 'ممتاز', 'module' => Modules::RESTAURANT, 'field' => DropDownFields::sys_satisfaction_rat],
            ['name' => 'work_type', 'value' => 'work_type', 'module' => Modules::CAPTIN, 'field' => DropDownFields::work_types],
            ['name' => 'NOW', 'value' => 'NOW', 'module' => Modules::CLIENT, 'field' => DropDownFields::category],
            ['name' => 'BOT', 'value' => 'BOT', 'module' => Modules::CLIENT, 'field' => DropDownFields::category],
            ['name' => 'BOX', 'value' => 'BOX', 'module' => Modules::CLIENT, 'field' => DropDownFields::category],
            ['name' => 'client_attachment', 'value' => 'client_attachment', 'module' => Modules::CLIENT, 'field' => DropDownFields::ATTACHMENT_TYPE],
            ['name' => 'visit_purpose', 'value' => 'visit_purpose', 'module' => Modules::VISIT, 'field' => DropDownFields::purpose],
            ['name' => 'male', 'value' => 'male', 'module' => Modules::main_module, 'field' => DropDownFields::gender],
            ['name' => 'female', 'value' => 'female', 'module' => Modules::main_module, 'field' => DropDownFields::gender],

            ['name' => 'status', 'value' => 'status', 'module' => Modules::CLIENT, 'field' => DropDownFields::status],
            ['name' => 'status', 'value' => 'status', 'module' => Modules::VISIT, 'field' => DropDownFields::status],

            ['name' => 'green', 'value' => 'green', 'module' => Modules::VEHICLE, 'field' => DropDownFields::color],

            ['name' => 'attachment_type', 'value' => 'attachment_type', 'module' => Modules::VEHICLE, 'field' => DropDownFields::ATTACHMENT_TYPE],


            ['name' => 'nissan', 'value' => 'nissan', 'module' => Modules::VEHICLE, 'field' => DropDownFields::brand],


            ['name' => 'insurance type 1', 'value' => 'insurance type 1', 'module' => Modules::INSURANCECOMPANY, 'field' => DropDownFields::INSURANCECOMPANY_TYPE],

            ['name' => 'title', 'value' => 'title', 'module' => Modules::INSURANCECOMPANY, 'field' => DropDownFields::titles],

            ['name' => 'attachment_type', 'value' => 'attachment_type', 'module' => Modules::INSURANCECOMPANY, 'field' => DropDownFields::ATTACHMENT_TYPE],

            ['name' => 'insurance', 'value' => 'insurance', 'module' => Modules::CLIENT, 'field' => DropDownFields::client_type],

            ['name' => 'third_party', 'value' => 'third_party', 'module' => Modules::POLICYOFFER, 'field' => DropDownFields::policyOffer_type],

            ['name' => 'processing', 'value' => 'processing', 'module' => Modules::POLICYOFFER, 'field' => DropDownFields::status],
            ['name' => 'accepted', 'value' => 'accepted', 'module' => Modules::POLICYOFFER, 'field' => DropDownFields::status],


            ['name' => 'accepted', 'value' => 'accepted', 'module' => Modules::POLICYOFFER, 'field' => DropDownFields::status],
            ['name' => 'mograted', 'value' => 'mograted', 'module' => Modules::POLICYOFFER, 'field' => DropDownFields::mortgaged_type],

            ['name' => 'accident_desc', 'value' => 'accident_desc', 'module' => Modules::POLICYOFFER, 'field' => DropDownFields::accident_desc],

            ['name' => 'Client Image', 'value' => 'Client Image', 'module' => Modules::POLICYOFFER, 'field' => DropDownFields::ATTACHMENT_TYPE],
            ['name' => 'Driving License', 'value' => 'Driving License', 'module' => Modules::POLICYOFFER, 'field' => DropDownFields::ATTACHMENT_TYPE],
            ['name' => 'Vehicle Front View', 'value' => 'Vehicle Front View', 'module' => Modules::POLICYOFFER, 'field' => DropDownFields::ATTACHMENT_TYPE],
            ['name' => 'Vehicle Back View', 'value' => 'Vehicle Back View', 'module' => Modules::POLICYOFFER, 'field' => DropDownFields::ATTACHMENT_TYPE],
            ['name' => 'Vehicle Right View', 'value' => 'Vehicle Right View', 'module' => Modules::POLICYOFFER, 'field' => DropDownFields::ATTACHMENT_TYPE],
            ['name' => 'Vehicle Left View', 'value' => 'Vehicle left View', 'module' => Modules::POLICYOFFER, 'field' => DropDownFields::ATTACHMENT_TYPE],

            ['name' => 'Chasse Image', 'value' => 'Chasse Image', 'module' => Modules::POLICYOFFER, 'field' => DropDownFields::ATTACHMENT_TYPE],
            ['name' => 'Vehicle License Front View', 'value' => 'Vehicle License Front View', 'module' => Modules::POLICYOFFER, 'field' => DropDownFields::ATTACHMENT_TYPE],
            ['name' => 'Vehicle License Back View', 'value' => 'Vehicle License Back View', 'module' => Modules::POLICYOFFER, 'field' => DropDownFields::ATTACHMENT_TYPE],

            ['name' => 'License Image', 'value' => 'License Image', 'module' => Modules::POLICYOFFER, 'field' => DropDownFields::ATTACHMENT_TYPE],

            ['name' => 'مالي', 'value' => 'مالي', 'module' => Modules::TICKET, 'field' => DropDownFields::refund_type],
            ['name' => 'وجبة', 'value' => 'وجبة', 'module' => Modules::TICKET, 'field' => DropDownFields::refund_type],
            ['name' => 'توصيل', 'value' => 'توصيل', 'module' => Modules::TICKET, 'field' => DropDownFields::refund_type],

            ['name' => 'type', 'value' => 'type', 'module' => Modules::CLIENTTRILLION, 'field' => DropDownFields::client_type],
            ['name' => 'att', 'value' => 'att', 'module' => Modules::CLIENTTRILLION, 'field' => DropDownFields::ATTACHMENT_TYPE],
            ['name' => 'shiftA', 'value' => 'shiftA', 'module' => Modules::CLIENTTRILLION, 'field' => DropDownFields::shifts],
            ['name' => 'department1', 'value' => 'department1', 'module' => Modules::CLIENTTRILLION, 'field' => DropDownFields::departments],
            ['name' => 'title_1', 'value' => 'title_1', 'module' => Modules::CLIENTTRILLION, 'field' => DropDownFields::titles],
            ['name' => 'attach trillions', 'value' => 'attach trillions', 'module' => Modules::CLIENTTRILLION, 'field' => DropDownFields::ATTACHMENT_TYPE],

            ['name' => 'facebook', 'value' => 'facebook', 'module' => Modules::CLIENTTRILLION, 'field' => DropDownFields::platform],

            ['name' => 'allowance', 'value' => 'allowance', 'module' => Modules::Employee, 'field' => DropDownFields::payment_roll_category],
            ['name' => 'deduction', 'value' => 'deduction', 'module' => Modules::Employee, 'field' => DropDownFields::payment_roll_category],
            ['name' => 'basic salary', 'value' => 'basic salary', 'module' => Modules::Employee, 'field' => DropDownFields::payment_roll],
            ['name' => 'hour rate', 'value' => 'hour rate', 'module' => Modules::Employee, 'field' => DropDownFields::payment_roll],
            ['name' => 'Trillion', 'value' => 'Trillion', 'module' => Modules::Employee, 'field' => DropDownFields::project],
            ['name' => 'Wheels', 'value' => 'Wheels', 'module' => Modules::Employee, 'field' => DropDownFields::project],
            ['name' => 'Annual', 'value' => 'Annual', 'module' => Modules::Employee, 'field' => DropDownFields::vacation],
            ['name' => 'Sick', 'value' => 'Sick', 'module' => Modules::Employee, 'field' => DropDownFields::vacation],
            ['name' => 'Delivery', 'value' => 'Delivery', 'module' => Modules::Employee, 'field' => DropDownFields::vacation],

            ['name' => 'month', 'value' => 'month', 'module' => Modules::Employee, 'field' => DropDownFields::salary],
            ['name' => 'BSC', 'value' => 'BSC', 'module' => Modules::Employee, 'field' => DropDownFields::education],
            ['name' => 'January', 'value' => '1', 'module' => Modules::main_module, 'field' => DropDownFields::Month],
            ['name' => 'February', 'value' => '2', 'module' => Modules::main_module, 'field' => DropDownFields::Month],
            ['name' => 'March', 'value' => '3', 'module' => Modules::main_module, 'field' => DropDownFields::Month],
            ['name' => 'April', 'value' => '4', 'module' => Modules::main_module, 'field' => DropDownFields::Month],
            ['name' => 'May', 'value' => '5', 'module' => Modules::main_module, 'field' => DropDownFields::Month],
            ['name' => 'June', 'value' => '6', 'module' => Modules::main_module, 'field' => DropDownFields::Month],
            ['name' => 'July', 'value' => '7', 'module' => Modules::main_module, 'field' => DropDownFields::Month],
            ['name' => 'Sept', 'value' => '9', 'module' => Modules::main_module, 'field' => DropDownFields::Month],
            ['name' => 'August', 'value' => '8', 'module' => Modules::main_module, 'field' => DropDownFields::Month],
            ['name' => 'October', 'value' => '10', 'module' => Modules::main_module, 'field' => DropDownFields::Month],
            ['name' => 'November', 'value' => '11', 'module' => Modules::main_module, 'field' => DropDownFields::Month],
            ['name' => 'December', 'value' => '12', 'module' => Modules::main_module, 'field' => DropDownFields::Month],
            ['name' => '2023', 'value' => '2023', 'module' => Modules::main_module, 'field' => DropDownFields::Year],
            ['name' => '2024', 'value' => '2024', 'module' => Modules::main_module, 'field' => DropDownFields::Year],
            ['name' => 'Reject', 'value' => 'Reject', 'module' => Modules::Employee, 'field' => DropDownFields::vacation_status],
            ['name' => 'Approve', 'value' => 'Approve', 'module' => Modules::Employee, 'field' => DropDownFields::vacation_status],
            ['name' => 'Reject', 'value' => 'Reject', 'module' => Modules::Employee, 'field' => DropDownFields::salary_status],
            ['name' => 'Approve', 'value' => 'Approve', 'module' => Modules::Employee, 'field' => DropDownFields::salary_status],

            ['name' => 'Type1', 'value' => 'Type1', 'module' => Modules::CLAIM, 'field' => DropDownFields::CLAIM_TYPE],
            ['name' => 'claim att', 'value' => 'claim att', 'module' => Modules::CLAIM, 'field' => DropDownFields::ATTACHMENT_TYPE],
            ['name' => 'cheif', 'value' => 'cheif', 'module' => Modules::FACILITY, 'field' => DropDownFields::titles],
            ['name' => 'epson', 'value' => 'epson', 'module' => Modules::FACILITY, 'field' => DropDownFields::printer_type],
            ['name' => 'ممتاز', 'value' => 'ممتاز', 'module' => Modules::FACILITY, 'field' => DropDownFields::sys_satisfaction_rat],
            ['name' => 'Restaurant', 'value' => 'Restaurant', 'module' => Modules::FACILITY, 'field' => DropDownFields::FACILITY_CATEGORY],
            ['name' => 'E', 'value' => 'SuperMarket', 'module' => Modules::FACILITY, 'field' => DropDownFields::FACILITY_CATEGORY],
            ['name' => 'Linux', 'value' => 'SuperMarket', 'module' => Modules::FACILITY, 'field' => DropDownFields::OS_TYPE],
            ['name' => 'Oddo', 'value' => 'SuperMarket', 'module' => Modules::FACILITY, 'field' => DropDownFields::POS_TYPE],
            ['name' => 'Facility', 'value' => 'Facility', 'module' => Modules::VISIT, 'field' => DropDownFields::visit_category],
            ['name' => 'Facility', 'value' => 'Facility', 'module' => Modules::VISIT, 'field' => DropDownFields::purpose],

            ['name' => 'Simple', 'value' => 'Simple', 'module' => Modules::LEAD, 'field' => DropDownFields::LEAD_TYPE],
            ['name' => 'Complex', 'value' => 'Complex', 'module' => Modules::LEAD, 'field' => DropDownFields::LEAD_TYPE],
            ['name' => 'Simple', 'value' => 'Simple', 'module' => Modules::offer_module, 'field' => DropDownFields::OFFER_TYPE],
            ['name' => 'Complex', 'value' => 'Complex', 'module' => Modules::offer_module, 'field' => DropDownFields::OFFER_TYPE],

            ['name' => 'processing', 'value' => 'processing', 'module' => Modules::LEAD, 'field' => DropDownFields::status],
            ['name' => 'completed', 'value' => 'completed', 'module' => Modules::LEAD, 'field' => DropDownFields::status],
            ['name' => 'processing', 'value' => 'processing', 'module' => Modules::offer_module, 'field' => DropDownFields::status],
            ['name' => 'completed', 'value' => 'completed', 'module' => Modules::offer_module, 'field' => DropDownFields::status],




            ['name' => 'procurement x', 'value' => 'procurement x', 'module' => Modules::Employee, 'field' => DropDownFields::perject],
            ['name' => 'elite care', 'value' => 'elite care', 'module' => Modules::Employee, 'field' => DropDownFields::perject],
            ['name' => 'mabeet', 'value' => 'mabeet', 'module' => Modules::Employee, 'field' => DropDownFields::perject],
            ['name' => 'trillions', 'value' => 'trillions', 'module' => Modules::Employee, 'field' => DropDownFields::perject],
            ['name' => 'wheels', 'value' => 'wheels', 'module' => Modules::Employee, 'field' => DropDownFields::perject],
            ['name' => 'Engineer', 'value' => 'Engineer', 'module' => Modules::Employee, 'field' => DropDownFields::career],
            ['name' => 'Contract', 'value' => 'Contract', 'module' => Modules::Employee, 'field' => DropDownFields::ATTACHMENT_TYPE],


            ['name' => 'not paid', 'value' => 'not paid', 'module' => Modules::CLAIM, 'field' => DropDownFields::status],
            ['name' => 'processing', 'value' => 'processing', 'module' => Modules::CLAIM, 'field' => DropDownFields::status],
            ['name' => 'paid', 'value' => 'paid', 'module' => Modules::CLAIM, 'field' => DropDownFields::status],
            ['name' => 'usd', 'value' => 'usd', 'module' => Modules::CLAIM, 'field' => DropDownFields::currency],

            ['name' => 'Check', 'value' => 'Check', 'module' => Modules::CLAIM, 'field' => DropDownFields::PAYMENT_TYPE],
            ['name' => 'Cash', 'value' => 'Cash', 'module' => Modules::CLAIM, 'field' => DropDownFields::PAYMENT_TYPE],
            ['name' => 'USD', 'value' => 'USD', 'module' => Modules::main_module, 'field' => DropDownFields::currency],
            ['name' => 'ILS', 'value' => 'ILS', 'module' => Modules::main_module, 'field' => DropDownFields::currency],

            ['name' => 'IT', 'value' => 'IT', 'module' => Modules::Employee, 'field' => DropDownFields::departments],
            ['name' => 'designer', 'value' => 'designer', 'module' => Modules::Employee, 'field' => DropDownFields::position],
            ['name' => 'account manager', 'value' => 'account manager', 'module' => Modules::Employee, 'field' => DropDownFields::position],
            ['name' => 'producer', 'value' => 'producer', 'module' => Modules::Employee, 'field' => DropDownFields::position],
            ['name' => 'content creator', 'value' => 'content creator', 'module' => Modules::Employee, 'field' => DropDownFields::position],

            ['name' => 'marketing type 1', 'value' => 'marketing type 1', 'module' => Modules::MARKETINGAGENCY, 'field' => DropDownFields::MARKETINGAGENCY_TYPE],

            ['name' => 'title', 'value' => 'title', 'module' => Modules::MARKETINGAGENCY, 'field' => DropDownFields::titles],

            ['name' => 'attachment_type', 'value' => 'attachment_type', 'module' => Modules::MARKETINGAGENCY, 'field' => DropDownFields::ATTACHMENT_TYPE],

            ['name' => 'small', 'value' => 'small', 'module' => Modules::MARKETINGAGENCY, 'field' => DropDownFields::sizes],

            ['name' => 'large', 'value' => 'large', 'module' => Modules::MARKETINGAGENCY, 'field' => DropDownFields::sizes],

            ['name' => 'Visa', 'value' => 'Visa', 'module' => Modules::FACILITY, 'field' => DropDownFields::PAYMENT_TYPE],





        ];

        foreach ($IDENTITY_TYPE as $value) {
            $value['constant_name'] = str_replace(' ', '_', trim(strtolower($value["name"])));
            Constant::updateOrCreate(
                collect($value)->only(['name', 'module', 'field'])->toArray(),
                collect($value)->except(['name', 'module', 'field'])->toArray(),
            );
        }

        $this->command->info('IDENTITY_TYPE Seeded successfully!');
    }
}

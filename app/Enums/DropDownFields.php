<?php

namespace App\Enums;

class DropDownFields
{
    const MARITAL_STATUS = 'marital_status';
    const WHEELS_BRANCHES = 'WHEELS_branches';
    const ticket_type = 'ticket_type';
    const OFFER_TYPE = 'offer_type';
    const sizes = 'sizes';
    const accident_desc = 'accident_desc';
    const policyOffer_type = 'policyOffer_type';
    const client_type = 'client_type';
    const currency = 'currency';
    const CLAIM_TYPE = 'claim_type';
    const position = 'position_type';
    const LEAD_TYPE = 'lead_type';
    const facility_type = 'facility_type';
    const salary_status = 'salary_status';
    const titles = 'title_type';
    const payment_roll = 'payment_roll';
    const career = 'career';
    const salary = 'salary';
    const Month = 'Month';
    const Year = 'Year';
    const education = 'education';
    const FACILITY_CATEGORY = 'FACILITY_CATEGORY';
    const vacation = 'vacation';
    const mortgaged_type = 'mortgaged_type';
    const employee_types = 'employee_types';
    const shifts = 'shift_type';
    const gender = 'gender';
    const vacation_status = 'vacation_status';
    const payment_roll_category = 'payment_roll_category';
    const payment_roll_payment = ';payment_roll_payment';
    const currences = 'currences';
    const employment_type = 'employment_type';
    const perject = 'perject';
    const brand = 'brand_type';
    const platform = 'platform_type';
    const INSURANCECOMPANY_TYPE = 'insurance_company_type';
    const MARKETINGAGENCY_TYPE = 'MARKETINGAGENCY_TYPE_type';
    const refund_type = 'refund_type';
    const targets = 'targets_type';
    const departments = 'departments_type';
    const color = 'color_type';
    const destinations = 'destinations_type';
    const order_type = 'orderv_type';
    const POS_TYPE = 'pos_type';
    const priority = 'priority_type';
    const purpose = 'purpose_type';
    const category = 'category_type';
    const visit_category = 'visit_category';
    const status = 'status_type';
    const visit_type = 'visit_type';
    const period = 'period';
    const project = 'project';
    const work_days = 'work_days';
    const work_types = 'work_types';
    const employee_task_assignment_status = 'employee_task_assignment_status';
    const art_manager_task_assignment_status = 'art_manager_task_assignment_status';
    const task_assignment_process_types = 'task_assignment_process_types';

    const sys_satisfaction_rat = 'sys_satisfaction_rat';
    const printer_type = 'printer_type';

    const task_statuss = 'task_statusss';
    const task_urgencys = 'task_urgencys';
    const OS_TYPE = 'os_type';
    const call_status = 'call_status';
    const caller_type = 'caller_type';
    const assign_status = 'assign_status';
    const urgency = 'urgency';
    const employee_status = 'employee_status';
    const payment_method_captin = 'payment_method_captin';
    const payment_type_captin = 'payment_type_captin';


    const SHORT_MESSAGE = 'short_message';
    const SHORT_MESSAGE_TEMPLATE = 'short_message_template';
    const motor_cc = 'motor_cc';
    const CALL_OPTION_TYPE = 'call_option_type';
    const EMP_STATUS = 'employee_status';
    const BANK = 'bank';
    const PAYMENT_TYPE = 'payment_type';
    const PAYMENT_METHOD = 'PAYMENT_METHOD';
    const RESTAURANT_TYPE = 'restaurant_type';
    const FACILITY_TYPE = 'facility_type';



    const objective_type = 'objective_type';
    const offer_status = 'offer_status';

    const BLOOD_TYPE = [
        ['value' => 'A+'],
        ['value' => 'A-'],
        ['value' => 'B+'],
        ['value' => 'B-'],
        ['value' => 'O+'],
        ['value' => 'O-'],
        ['value' => 'AB+'],
        ['value' => 'AB-'],
    ];
    const PREPARATION_TIME = [
        ['value' => '5'],
        ['value' => '10'],
        ['value' => '15'],
        ['value' => '20'],
        ['value' => '30'],
        ['value' => '45'],
        ['value' => '60'],
    ];

    const rating = [
        '' => '',
        '5' => 'Excellent-5',
        '4' => 'Very Good-4',
        '3' => 'Good-3',
        '2' => 'Accept-2',
        '1' => 'Bad-1',
        '0' => 'Very Bad-0',
    ];



    const IDENTITY_TYPE = 'identity_type';
    const QUESTIONNAIRE_TYPE = 'call';


    const ATTACHMENT_TYPE = 'attachment_type';
    const attachment_rest_type = 'attachment_rest_type';


    const CALL_ACTION = 'call_action';
    const CAPTIN_ACTION = 'call_action';
    const CAPTIN_SHIFT = 'CAPTIN_SHIFT';
    const blood_type = 'blood_type';
    const degree = 'degree';
    const CAPTIN_CALL_ACTION = 'CAPTIN_CALL_ACTION';

    const fuel_type = 'fuel_type';
    const vehicle_type = 'vehicle_type';
    const vehicle_model = 'vehicle_model';
    const box_no = 'box_no';
    const promissory = 'promissory';
    const insurance_company = 'insurance_company';
    const policy_degree = 'policy_degree';
    const policy_code = 'policy_degree';
    const insurance_type = 'insurance_type';

    const reference_relatives = 'reference_relatives';

    const policy_codes = 'policy_codes';

    const objective_type_list = [
        'long_term' => 'long_term',
        'short_term' => 'short_term',
    ];
    const offer_status_list = [
        'pending' => 'pending',
        'processing' => 'processing',
        'approved' => 'approved',
        'rejected' => 'rejected',
        'created_by_system' => 'created_by_system',
    ];

    const colors_list = [
        'pending' => '#FFA800',      // Warning/Orange color
        'approved' => '#50CD89',     // Success/Green color
        'rejected' => '#F1416C',     // Danger/Red color
        'inquiry' => '#009EF7',      // Primary/Blue color
        'request_for_price_offer' => '#7239EA', // Purple/Info color
        /********* */
        'created_by_system' => '#A1A5B7',     // Grey - initial/neutral system state
        'ready_to_sale' => '#50CD89',         // Green - available for sale
        'sold' => '#F1416C',                  // Red - not available/final state
        'in_maintenance' => '#FFA800',         // Orange - temporary unavailable state
        'paid_processing' => '#009EF7',        // Blue - active process

    ];
}

<?php

namespace App\Enums;

class DropDownFields
{
    const MARITAL_STATUS  = 'marital_status';
    const ALHAYAT_BRANCHES = 'alhayat_branches';
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
    const category = 'category_type';
    const MEMBERSHIP_TYPE = 'membership_type';
    const EXTERNAL_APPT_STATUS = 'external_app_status';
    const MEMBERSHIP_SUBTYPE = 'membership_subtype';
    // const RELATION_TYPE = 'relation_type';
    const IDENTITY_TYPE = 'identity_type';
    const PATIENT_RELATIVES = 'patient_relatives';

    const Payment_Types = 'payment_types';
    const Employee_Types = 'employee_types';

    const SICK_FUND = 'sick_fund';
    const status = 'status';
    const type = 'type';
    const ATTACHMENT_TYPE = 'attachment_type';

    const PROCEDURE_TYPE = 'procedure_type';
    const PROCEDURE_FEE_TYPE = 'procedure_fee_type';
    const INVOICE_TYPE = 'invoice_type';

    const CALL_ACTION = 'call_action';
    const CALL_PATIENT_ACTION = 'call_patient_action';

    const SHORT_MESSAGE = 'short_message';
    const SHORT_MESSAGE_TEMPLATE = 'short_message_template';
    const QUESTIONNAIRE_TYPE = 'questionnaire_type';

    const HOSITPAL_TYPE = 'hositpal_type';
    const CLINIC_SERVICE_TYPE = 'clinic_service_type';
    const CLINIC_TEAM_CONTACT_TYPE = 'clinic_team_contact_type';
    const CLINIC_TEAM_TITLE_TYPE = 'clinic_team_title_type';
    const CLINIC_TEAM_WORKING_SHIFT = 'clinic_team_working_shift';
    const DOCTOR_TYPE = 'doctor_type';

    const Pro_Types = 'pro_type';
    const Card_Types = 'card_type';
    const DOCTOR_SERVICE_TYPE = 'doctor_service_type';
    const SYSTEM_NOTIFICATION_TYPE = 'system_notification_type';
    const SMS_NOTIFICATION_TYPE = 'sms_notification_type';
    const CALL_OPTION_TYPE = 'call_option_type';
    const URGENCY_EXTERNAL_APPT = 'urgency_external_appt';
    const EXTERNAL_APPT_SERVICE_TYPE = 'external_appt_service_type';
    const EXTERNAL_APPT_RECOMMENDATIONS = 'external_appt_recommendations';
    const UERGANCY_COVERAGE_REQUEST = 'uergancy_coverage_request';
    const MEDICATION_COVERAGE_PERIOD = 'medication_coverage_period';
    const TREATMENT_SERVICE_TYPE = 'treatment_service_type';
    const COMPLAIN_TYPE = 'complain_type';
    const sales_contract_type  = 'sales_contract_type';
    const sales_payment_type  = 'sales_payment_type';
    const sales_status  = 'sales_status';
    const apartment_type  = 'apartment_type';
    const apartment_size  = 'apartment_size';
    const apartment_orientation  = 'apartment_orientation';
    const apartment_parking_type  = 'apartment_parking_type';
    const apartment_status  = 'apartment_status';
    const lead_source  = 'lead_source';
    const lead_form_type  = 'lead_form_type';
    const lead_status  = 'lead_status';
    const lead_actions  = 'lead_actions';
    const price_offer_status  = 'price_offer_status';
    const apartment_attachment_type  = 'apartment_attachment_type';
    const building_attachment_type  = 'building_attachment_type';
    const price_offer_attachment_type  = 'price_offer_attachment_type';
    const lead_attachment_type  = 'lead_attachment_type';
    const client_attachment_type  = 'client_attachment_type';
    const sale_attachment_type  = 'sale_attachment_type';
    const payments_payment_type  = 'payments_payment_type';



    const website_section_type  = 'website_section_type';
    // In App\Enums\DropDownFields.php

    const banks = 'banks';
    const bank_branches = 'bank_branches';


    const banks_list = [
        'bank_of_palestine' => 'bank_of_palestine',
        'arab_bank' => 'arab_bank',
        'cairo_amman_bank' => 'cairo_amman_bank',
    ];

    const bank_branches_list = [
        'bank_of_palestine' => [
            'main_branch' => 'main_branch',
            'ramallah_branch' => 'ramallah_branch',
            'al_bireh_branch' => 'al_bireh_branch',
        ],
        'arab_bank' => [
            'main_branch' => 'main_branch',
            'gaza_branch' => 'gaza_branch',
        ],
        'cairo_amman_bank' => [
            'main_branch' => 'main_branch',
            'nablus_branch' => 'nablus_branch',
        ],
    ];
    const sales_contract_type_list = [
        'new_apartment_sales_agreement' => 'new_apartment_sales_agreement',
        'resale_apartment_agreement' => 'resale_apartment_agreement',
        'lease_to_own_agreement' => 'lease_to_own_agreement',
        'installment_sales_agreement' => 'installment_sales_agreement',
    ];
    const sales_payment_type_list  = [
        // 'downpayment_only' => 'downpayment_only',
        'downpayment_installment' => 'downpayment_installment',
        'downpayment_installment_balloon' => 'downpayment_installment_balloon',
        // 'full_payment' => 'full_payment',
    ];
    /****************** Payments ************** */
    const payment_plans_payment_frequency = 'payment_plans_payment_frequency';
    const payment_plans_payment_frequency_list  = [
        'monthly' => 'monthly',
        'quarterly' => 'quarterly',
        'yearly' => 'yearly',
    ];
    const payment_plans_status = 'payment_plans_status';
    const payment_plans_status_list  = [
        'active' => 'active',
        'completed' => 'completed',
        'defaulted' => 'defaulted',
        'cancelled' => 'cancelled',
    ];


    const payment_schedules_payment_type = 'payment_schedules_payment_type';
    const payment_schedules_payment_type_list = [
        'downpayment' => 'downpayment',
        'installment' => 'installment',
        'balloon' => 'balloon'
    ];
    const payment_schedules_status  = 'payment_schedules_status';
    const payment_schedules_status_list  = [
        'pending' => 'pending',
        'partial' => 'partial',
        'paid' => 'paid',
        'overdue' => 'overdue',
    ];



    const payment_transactions_payment_method = 'payment_transactions_payment_method';
    const  payment_transactions_payment_method_list = [
        'cash' => 'cash',
        'check' => 'check',
        'bank_transfer' => 'bank_transfer',
        'other' => 'other'
    ];
    const payment_transactions_status = 'payment_transactions_status';
    const  payment_transactions_status_list = [
        'pending' => 'pending',
        'completed' => 'completed',
        'failed' => 'failed',
        'reversed' => 'reversed'
    ];
    const  payment_fees_fee_type = 'payment_fees_fee_type';
    const  payment_fees_fee_type_list = [
        'late_payment' => 'late_payment',
        'processing' => 'processing',
        'bounced_check' => 'bounced_check',
        'other' => 'other',
    ];
    const  payment_fees_status = 'payment_fees_status';
    const  payment_fees_status_list = [
        'pending' => 'pending',
        'paid' => 'paid',

    ];





    /************************ */
    const sales_status_list  = [
        'processing' => 'processing',
        'approved' => 'approved',
        'submitted_to_accounted' => 'submitted_to_accounted',
    ];

    const apartment_types_list = [
        'apartment_type_1' => 'apartment_type_1',
        'apartment_type_2' => 'apartment_type_1',
    ];
    const apartment_sizes_list = [
        'apartment_size_1' => 'apartment_size_1',
        'apartment_size_2' => 'apartment_size_2',
    ];
    const apartment_orientations_list = [
        'orientation_1' => 'orientation_1',
        'orientation_2' => 'orientation_2',
    ];
    const apartment_parking_types_list = [
        'parking_type_1' => 'parking_type_1',
        'parking_type_2' => 'parking_type_2',
    ];
    const apartment_status_list = [
        'created_by_system' => 'created_by_system',
        'ready_to_sale' => 'ready_to_sale',
        'sold' => 'sold',
        'in_maintenance' => 'in_maintenance',
        'paid_processing' => 'paid_processing',
    ];
    const lead_source_list = [
        'dashboard' => 'dashboard',
        'call_center' => 'call_center',
        'whatsapp' => 'whatsapp',
        'website' => 'website',
    ];
    const lead_form_types_list = [
        'header' => 'header',
        'choose_apartment' => 'choose_apartment',
        'footer' => 'footer',
        'inquiry_form' => 'inquiry_form',
    ];
    const lead_status_list = [
        'pending' => 'pending',
        // 'resolved' => 'resolved',
        'inquiry' => 'inquiry',
        'request_for_price_offer' => 'request_for_price_offer',
    ];
    // const lead_actions_list = [
    //     'inquiry' => 'inquiry',
    //     'request_for_price_offer' => 'request_for_price_offer',
    // ];
    const price_offer_status_list = [
        'pending' => 'pending',
        'approved' => 'approved',
        'rejected' => 'rejected',
    ];
    const apartment_attachment_type_list = [
        'brochure' => 'brochure',
        'inside_view' => 'inside_view',
        'outside_view' => 'outside_view',
    ];
    const client_attachment_type_list = [
        'id_card' => 'id_card',
        'passport' => 'passport',
        'avatar' => 'avatar',
    ];
    const sale_attachment_type_list = [
        'contract' => 'contract',
    ];

    const building_attachment_type_list = [
        'top_view' => 'top_view',
        'right_view' => 'right_view',
        'left_view' => 'left_view',
    ];
    const price_offer_attachment_type_list = [
        'price_type_1' => 'price_type_1',
    ];
    const lead_attachment_type_list = [
        'lead_type_1' => 'lead_type_1',
    ];
    const website_section_type_list = [
        'menu' => 'menu',
        'slider' => 'slider',
        'feature' => 'feature',
        'service' => 'service',
        'review_management' => 'review_management',
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
        /********   sales   ******** */
        'new_apartment_sales_agreement' => '#28a745',
        'resale_apartment_agreement' => '#17a2b8',
        'lease_to_own_agreement' => '#ffc107',
        'installment_sales_agreement' => '#6610f2',
        'downpayment_only' => '#20c997',
        'downpayment_installment' => '#fd7e14',
        'downpayment_installment_balloon' => '#6f42c1',
        'full_payment' => '#198754',
        /*************sales status list */
        'processing' => '#FFA800',
        'approved' => '#50CD89',
        'submitted_to_accounted' => '#198754',
        /*********payment */
        // Payment Statuses
        // 'pending' => '#FFA500',   // Orange for waiting/pending actions
        'partial' => '#3498DB',   // Blue for in-progress/partial completion
        'paid' => '#2ECC71',      // Green for successful/completed payments
        'overdue' => '#E74C3C',   // Red for overdue/urgent attention

        // Payment Types
        'downpayment' => '#9B59B6',    // Purple for initial payments
        'installment' => '#34495E',     // Dark blue-gray for regular payments
        'balloon' => '#16A085',     // Teal for final/special payments
        // Payment Plan Status Colors
        'active' => '#00B74A',     // Bright green for active/ongoing plans
        'completed' => '#1266F1',  // Royal blue for successfully completed
        'defaulted' => '#F93154',  // Strong red for defaulted/failed payments
        'cancelled' => '#757575'   // Gray for cancelled/terminated plans

    ];
}

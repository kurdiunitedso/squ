<?php

namespace App\Enums;

class DropDownFields
{
    const MARITAL_STATUS  = 'marital_status';
    const MEMBERSHIP_TYPE = 'membership_type';
    const EXTERNAL_APPT_STATUS = 'external_app_status';
    const MEMBERSHIP_SUBTYPE = 'membership_subtype';
    const IDENTITY_TYPE = 'identity_type';
    const Payment_Types = 'payment_types';
    const Employee_Types = 'employee_types';
    const status = 'status';
    const type = 'type';
    const ATTACHMENT_TYPE = 'attachment_type';
    const PROCEDURE_TYPE = 'procedure_type';
    const PROCEDURE_FEE_TYPE = 'procedure_fee_type';
    const INVOICE_TYPE = 'invoice_type';

    const website_section_type  = 'website_section_type';
    const banks = 'banks';
    const bank_branches = 'bank_branches';
    const program_attachment_type = 'program_attachment_type';

    const banks_list = [
        'bank_of_palestine' => 'bank_of_palestine',
        'arab_bank' => 'arab_bank',
        'cairo_amman_bank' => 'cairo_amman_bank',
    ];
    const program_attachment_type_list = [
        'program_photo' => 'program_photo',
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

    // App/Enums/DropDownFields.php

    const program_eligibility_type = 'program_eligibility_type';
    const program_target_applicants = 'program_target_applicants';
    const program_category = 'program_category';
    const program_facility = 'program_facility';

    const program_eligibility_type_list = [
        'student' => 'student',
        'researcher' => 'researcher',
        'faculty' => 'faculty',
        'staff' => 'staff',
        'external' => 'external'
    ];

    const program_target_applicants_list = [
        'squ_only' => 'squ_only',
        'all' => 'all'
    ];

    const program_category_list = [
        'research' => 'research',
        'innovation' => 'innovation',
        'entrepreneurship' => 'entrepreneurship',
        'training' => 'training'
    ];

    const program_facility_list = [
        'lab_access' => 'lab_access',
        'workspace' => 'workspace',
        'equipment' => 'equipment',
        'mentoring' => 'mentoring',
        'funding' => 'funding'
    ];

    const question_type = 'question_type';

    const question_type_list = [
        'text' => 'text',
        'textarea' => 'textarea',
        'dropdown' => 'dropdown',
        'checkbox' => 'checkbox',
        'tags' => 'tags',
        'repeater' => 'repeater',
        'file' => 'file'
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

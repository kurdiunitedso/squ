<style>
    /******** tasks moudle ***************/
    /* Board Layout */
    .tsk-board {
        display: flex;
        gap: 1.5rem;
        padding: 1.5rem;
        height: calc(100vh - 80px);
        overflow-x: auto;
        scroll-padding: 1.5rem;
        scrollbar-width: thin;
        background: #f9fafb;
    }

    .tsk-board::-webkit-scrollbar {
        height: 6px;
    }

    .tsk-board::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.02);
        border-radius: 6px;
    }

    .tsk-board::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, 0.15);
        border-radius: 6px;
    }

    /* List/Column Styles */
    .tsk-list {
        flex: 0 0 320px;
        display: flex;
        flex-direction: column;
        background: #fff;
        border-radius: 12px;
        border: 1px solid rgba(0, 0, 0, 0.08);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease;
    }

    .tsk-list:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .tsk-list-header {
        padding: 1rem 1.25rem;
        background: #fff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        border-radius: 12px 12px 0 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .tsk-list-header-title {
        font-size: 1.1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .tsk-list-cards {
        padding: 1rem;
        overflow-y: auto;
        flex-grow: 1;
        min-height: 100px;
    }

    .tsk-list-cards::-webkit-scrollbar {
        width: 4px;
    }

    .tsk-list-cards::-webkit-scrollbar-track {
        background: transparent;
    }

    .tsk-list-cards::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, 0.1);
        border-radius: 4px;
    }

    /* Card Styles */
    .tsk-card {
        background: #fff;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        border: 1px solid rgba(0, 0, 0, 0.08);
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease;
        cursor: pointer;
        position: relative;
        border-left: 4px solid var(--status-color, #e2e8f0);
    }

    .tsk-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border-color: rgba(0, 0, 0, 0.12);
    }

    .tsk-card-title {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .tsk-card-description {
        font-size: 0.85rem;
        color: #64748b;
        line-height: 1.5;
        margin-bottom: 0.75rem;
    }

    .tsk-card-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }

    .tsk-card-status {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .tsk-card-active-flag {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .tsk-card-active-flag.active {
        background-color: #e8fff3;
        color: #50cd89;
    }

    .tsk-card-active-flag.inactive {
        background-color: #fff5f8;
        color: #f1416c;
    }

    .tsk-card-project {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.75rem;
        background: #f8f9fa;
        border-radius: 6px;
        margin-bottom: 1rem;
    }

    .tsk-project-details {
        flex: 1;
        min-width: 0;
    }

    .tsk-project-client {
        font-size: 0.75rem;
        color: #a1a5b7;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .tsk-card-employee {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem;
        background: #f8f9fa;
        border-radius: 6px;
        margin: 0.75rem 0;
    }

    .tsk-employee-avatar {
        width: 32px;
        height: 32px;
        background: #e1f0ff;
        color: #009ef7;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
        font-size: 0.875rem;
        flex-shrink: 0;
    }

    .tsk-employee-info {
        flex: 1;
        min-width: 0;
    }

    .tsk-employee-name {
        font-size: 0.875rem;
        font-weight: 500;
        color: #3f4254;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .tsk-employee-position {
        font-size: 0.75rem;
        color: #a1a5b7;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .tsk-card-meta {
        border-top: 1px dashed #e9ecef;
        padding-top: 0.75rem;
        margin-top: 0.75rem;
    }

    .tsk-card-dates {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }

    .tsk-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.75rem;
        color: #7e8299;
        background: #f8f9fa;
        padding: 0.25rem 0.75rem;
        border-radius: 4px;
    }

    .tsk-meta-item i {
        color: #009ef7;
        font-size: 1rem;
    }

    .tsk-card-actions {
        display: flex;
        justify-content: flex-end;
    }

    /* Timeline Styles */
    .tsk-timeline {
        position: relative;
        padding: 1.5rem;
        margin-top: 1rem;
    }

    .tsk-timeline-item {
        position: relative;
        padding-left: 3rem;
        padding-bottom: 1.5rem;
        cursor: pointer;
    }

    .tsk-timeline-item:not(:last-child)::before {
        content: "";
        position: absolute;
        left: 15px;
        top: 30px;
        bottom: 0;
        width: 2px;
        background: #e4e6ef;
    }

    .tsk-timeline-item:hover .tsk-timeline-content {
        background: #f8fafd;
        transform: translateX(5px);
    }

    .tsk-timeline-avatar {
        position: absolute;
        left: 0;
        top: 0;
        width: 32px;
        height: 32px;
        background: #f1f3f6;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: #009ef7;
        font-size: 0.9rem;
        z-index: 1;
        border: 2px solid #fff;
        box-shadow: 0 0 0 3px rgba(0, 158, 247, 0.1);
    }

    .tsk-timeline-content {
        background: #fff;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.08);
        transition: all 0.2s ease;
    }

    /* Comments Modal */
    .tsk-comments-modal .modal-content {
        border: none;
        border-radius: 12px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .tsk-comments-modal .modal-header {
        background: #f8fafc;
        border-bottom: 1px dashed #e4e6ef;
        border-radius: 12px 12px 0 0;
        padding: 1rem 1.5rem;
    }

    .tsk-comments-modal .modal-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #181c32;
    }

    .tsk-comments-container {
        max-height: 500px;
        overflow-y: auto;
        padding: 1.5rem 2rem;
    }

    .tsk-comment {
        display: flex;
        gap: 1rem;
        padding: 1.25rem 0;
        border-bottom: 1px dashed #e4e6ef;
        animation: tsk-fadeIn 0.3s ease forwards;
    }

    .tsk-comment:last-child {
        border-bottom: none;
    }

    .tsk-comment-avatar {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: #eef3f7;
        color: #009ef7;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .tsk-comment-content {
        flex: 1;
    }

    /* Dropzone */
    .tsk-dropzone {
        border: 2px dashed #e4e6ef;
        background: #f9fafb;
        border-radius: 10px;
        padding: 1.5rem;
        transition: all 0.2s ease;
    }

    .tsk-dropzone:hover {
        border-color: #009ef7;
    }

    /* Utilities */
    .tsk-loading {
        position: relative;
        pointer-events: none;
    }

    .tsk-loading::after {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(2px);
        border-radius: 8px;
        z-index: 1;
    }

    .tsk-loading::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 24px;
        height: 24px;
        border: 2px solid #e2e8f0;
        border-top-color: #3b82f6;
        border-radius: 50%;
        animation: tsk-spin 0.8s linear infinite;
        z-index: 2;
    }

    @keyframes tsk-spin {
        to {
            transform: translate(-50%, -50%) rotate(360deg);
        }
    }

    @keyframes tsk-fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .tsk-card-dates {
            flex-direction: column;
        }

        .tsk-meta-item {
            width: 100%;
        }

        .tsk-board {
            gap: 1rem;
        }
    }

    /********************************/
    /* Task Details Modal Styles */
    .modal-task-header {
        --primary: #009ef7;
        --success: #50cd89;
        --warning: #ffc700;
        --danger: #f1416c;
        --border: #e4e6ef;
        background: #fff;
        border-radius: 12px 12px 0 0;
        overflow: hidden;
    }

    .task-header-bg {
        background: linear-gradient(135deg, var(--primary) 0%, #0095e8 100%);
        padding: 2.5rem 2rem;
        position: relative;
        overflow: hidden;
    }

    .task-header-bg::after {
        content: "";
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100'
 xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48
 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z' fill='rgba(255,255,255,0.05)'
 fill-rule='evenodd'/%3E%3C/svg%3E")
 center/auto repeat;
                opacity: 0.5;
        }

        .task-header-content {
            position: relative;
            z-index: 1;
        }

        .task-title {
            color: #fff;
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .task-description {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .task-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .task-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            color: #fff;
        }

        .task-badge.active-badge {
            background: var(--success);
            box-shadow: 0 2px 6px rgba(80, 205, 137, 0.2);
        }

        .task-badge.inactive-badge {
            background: var(--danger);
            box-shadow: 0 2px 6px rgba(241, 65, 108, 0.2);
        }

        /* Quick Info Panel */
        .task-quick-info {
            background: #fff;
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin: -2rem 1.5rem 0;
            position: relative;
            z-index: 2;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .info-icon {
            width: 3rem;
            height: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.75rem;
            flex-shrink: 0;
        }

        .info-icon.status {
            background: rgba(0, 158, 247, 0.1);
            color: var(--primary);
        }

        .info-icon.employee {
            background: rgba(80, 205, 137, 0.1);
            color: var(--success);
        }

        .info-icon.active-state {
            background: rgba(255, 168, 0, 0.1);
            color: var(--warning);
        }

        .info-content {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 0.875rem;
            color: #a1a5b7;
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-size: 1rem;
            font-weight: 600;
            color: #181c32;
        }

        /* Timeline Cards */
        .card.shadow-sm {
            border: none;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
            transition: all 0.2s ease;
        }

        .card.shadow-sm:hover {
            transform: translateY(-2px);
        }

        .card-header.min-h-50px {
            background: #f8fafc;
            border-bottom: 1px solid var(--border);
        }

        /* Timeline Icons */
        .rounded-circle.bg-light-primary {
            background: rgba(0, 158, 247, 0.1);
        }

        .rounded-circle.bg-light-success {
            background: rgba(80, 205, 137, 0.1);
        }

        /* Status Badges */
        .badge.badge-light-success {
            background: #e8fff3;
            color: var(--success);
        }

        .badge.badge-light-warning {
            background: #fff8dd;
            color: var(--warning);
        }

        /* Timeline Process */
        .tsk-timeline-item {
            transition: all 0.2s ease;
        }

        .tsk-timeline-item:hover {
            transform: translateX(5px);
        }

        .tsk-timeline-content {
            background: #fff;
            border: 1px solid var(--border);
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .task-quick-info {
                grid-template-columns: 1fr;
            }

            .task-description {
                max-width: 100%;
            }

            .task-badges {
                flex-wrap: wrap;
            }
        }

        /******* task assigment comments styles *********/
        .comment {
            border-bottom: 1px dashed #e4e6ef;
            padding-bottom: 1rem;
        }

        .comment:last-child {
            border-bottom: none;
        }

        .symbol-label {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            color: var(--kt-primary);
            border-radius: 0.475rem;
        }

        .comment-content {
            border-radius: 0.475rem;
            padding: 1rem;
            background-color: #f8f9fa;
        }
</style>

@php
    use App\Enums\DropDownFields;
    use App\Enums\Modules;
    use App\Models\Project;
    use App\Models\Task;
    use App\Models\TaskAssignment;
    use App\Models\TaskProcess;
@endphp
@extends('metronic.index')

@section('title', Task::ui['p_ucf'])
@section('subpageTitle', Task::ui['p_ucf'])
@push('styles')
    <link href="{{ asset('css/custom.css?v=1') }}" rel="stylesheet" type="text/css" />

    <style>
        /* Enhanced Styles with 'tsk-' prefix */
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

        /* Column Styles */
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

        /* Task Card Styles */
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
            overflow: hidden;
        }

        .tsk-card,
        .tsk-card-status,
        .tsk-card-active-flag {
            transition: all 0.3s ease;
        }

        .tsk-card {
            border-left: 4px solid var(--status-color);
        }

        .tsk-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--status-color, #e2e8f0);
            opacity: 0.8;
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
            padding-left: 0.5rem;
        }

        .tsk-card-description {
            font-size: 0.85rem;
            color: #64748b;
            line-height: 1.5;
            margin-bottom: 0.75rem;
            padding-left: 0.5rem;
        }

        .tsk-card-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8rem;
            color: #94a3b8;
            margin-top: 0.75rem;
            padding-top: 0.75rem;
            border-top: 1px dashed rgba(0, 0, 0, 0.06);
        }

        .tsk-card-dates {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            font-size: 0.75rem;
        }

        .tsk-card-date {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #64748b;
        }

        .tsk-status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
            color: #fff;
        }

        /* Modal Enhancements */
        .tsk-modal-header {
            background: linear-gradient(to right, #f8fafc, #f1f5f9);
            border-radius: 16px 16px 0 0;
            padding: 1.5rem !important;
        }

        .tsk-modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .tsk-modal-status {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .tsk-modal-body {
            padding: 1.5rem !important;
        }

        .tsk-info-section {
            background: #fff;
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(0, 0, 0, 0.06);
        }

        .tsk-info-label {
            font-size: 0.85rem;
            color: #64748b;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .tsk-info-value {
            font-size: 1rem;
            color: #1e293b;
            line-height: 1.5;
        }

        /* Task Process Timeline Styles */
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
            content: '';
            position: absolute;
            left: 15px;
            top: 30px;
            bottom: 0;
            width: 2px;
            background: #E4E6EF;
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

        .tsk-timeline-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .tsk-timeline-user {
            font-weight: 600;
            color: #181C32;
            font-size: 0.95rem;
        }

        .tsk-timeline-time {
            color: #A1A5B7;
            font-size: 0.85rem;
        }

        .tsk-timeline-status {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-top: 0.75rem;
            padding-top: 0.75rem;
            border-top: 1px dashed #E4E6EF;
        }

        .tsk-status-change {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .tsk-status-label {
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 500;
            background: #f1f3f6;
            color: #5E6278;
        }

        .tsk-status-arrow {
            color: #A1A5B7;
            display: flex;
            align-items: center;
        }

        .tsk-status-new {
            background: #E8FFF3;
            color: #50CD89;
        }

        .tsk-comments-indicator {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.75rem;
            font-size: 0.85rem;
            color: #A1A5B7;
        }

        .tsk-comments-indicator i {
            color: #009ef7;
        }

        /* Status-specific styles */
        .tsk-status-processing {
            background: #EEF6FF;
            color: #009ef7;
        }

        .tsk-status-approval {
            background: #FFF8DD;
            color: #FFA800;
        }

        .tsk-status-completed {
            background: #E8FFF3;
            color: #50CD89;
        }

        /* Animation for new items */
        @keyframes tsk-fadeIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .tsk-timeline-item {
            animation: tsk-fadeIn 0.3s ease forwards;
        }

        /* Loading State */
        .tsk-loading {
            position: relative;
            pointer-events: none;
        }

        .tsk-loading::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(2px);
            border-radius: 8px;
            z-index: 1;
        }

        .tsk-loading::before {
            content: '';
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




        /* Comments Modal Styles */
        .tsk-comments-modal .modal-content {
            border: none;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .tsk-comments-modal .modal-header {
            background: #f8fafc;
            border-bottom: 1px dashed #E4E6EF;
            border-radius: 12px 12px 0 0;
            padding: 1rem 1.5rem;
        }

        .tsk-comments-modal .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #181C32;
        }

        .tsk-comments-container {
            max-height: 400px;
            overflow-y: auto;
            padding: 2.5rem;
            margin: -1rem -1.5rem 1rem;
        }

        .tsk-comments-container::-webkit-scrollbar {
            width: 6px;
        }

        .tsk-comments-container::-webkit-scrollbar-track {
            background: transparent;
        }

        .tsk-comments-container::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 3px;
        }

        /* Individual Comment Styles */
        .tsk-comment {
            display: flex;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px dashed #E4E6EF;
            animation: tsk-slideIn 0.3s ease forwards;
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

        .tsk-comment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .tsk-comment-user {
            font-weight: 600;
            color: #181C32;
            font-size: 0.95rem;
        }

        .tsk-comment-time {
            color: #A1A5B7;
            font-size: 0.85rem;
        }

        .tsk-comment-text {
            color: #5E6278;
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 0.75rem;
        }

        /* Comment Attachments */
        .tsk-comment-files {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.75rem;
        }

        .tsk-file-item {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.75rem;
            background: #f1f3f6;
            border-radius: 6px;
            color: #009ef7;
            font-size: 0.85rem;
            transition: all 0.2s ease;
        }

        .tsk-file-item:hover {
            background: #eef3f7;
            transform: translateY(-1px);
        }

        .tsk-file-item i {
            font-size: 1.1rem;
        }

        /* Comment Form */
        .tsk-comment-form {
            padding: 1.5rem;
            background: #f8fafc;
            border-radius: 12px;
            margin-top: 1rem;
        }

        .tsk-comment-input {
            background: #fff !important;
            border: 1px solid #E4E6EF !important;
            border-radius: 8px !important;
            padding: 1rem !important;
            resize: none;
            transition: all 0.2s ease;
        }

        .tsk-comment-input:focus {
            border-color: #009ef7 !important;
            box-shadow: 0 0 0 3px rgba(0, 158, 247, 0.1) !important;
        }

        /* Dropzone Styling */
        /* Update or add these styles */
        .tsk-dropzone {
            border: 2px dashed #E4E6EF;
            background: #F9FAFB;
            border-radius: 10px;
            padding: 1.5rem;
            transition: all 0.2s ease;
        }

        /* Custom preview template styles */
        .tsk-dropzone .dz-preview {
            display: flex;
            align-items: center;
            background: #fff;
            border: 1px solid #E4E6EF;
            border-radius: 8px;
            padding: 0.75rem;
            margin: 0.75rem 0;
            position: relative;
        }

        .tsk-dropzone .dz-preview .dz-details {
            display: flex;
            align-items: center;
            flex: 1;
            min-width: 0;
            /* Helps with text overflow */
            padding-right: 1rem;
        }

        .tsk-dropzone .dz-preview .dz-filename {
            font-size: 0.9rem;
            color: #3F4254;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }

        .tsk-dropzone .dz-preview .dz-size {
            font-size: 0.85rem;
            color: #A1A5B7;
            margin-left: 1rem;
        }

        .tsk-dropzone .dz-preview .dz-remove {
            color: #F1416C;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.5rem;
            border-radius: 0.475rem;
            transition: all 0.2s ease;
        }

        .tsk-dropzone .dz-preview .dz-remove:hover {
            background-color: #FFF5F8;
        }

        .tsk-dropzone .dz-preview .dz-success-mark,
        .tsk-dropzone .dz-preview .dz-error-mark {
            margin-right: 0.75rem;
        }

        .tsk-dropzone .dz-preview .dz-success-mark svg,
        .tsk-dropzone .dz-preview .dz-error-mark svg {
            width: 24px;
            height: 24px;
        }

        .tsk-dropzone .dz-preview .dz-success-mark {
            color: #50CD89;
        }

        .tsk-dropzone .dz-preview .dz-error-mark {
            color: #F1416C;
        }

        /* Uploaded Files Preview */
        /* Update the existing file preview styles */
        .tsk-file-previews {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-top: 0.75rem;
        }

        .tsk-file-preview {
            flex: 0 0 auto;
            width: calc(33.333% - 0.5rem);
            /* Show 3 files per row */
            min-width: 200px;
            max-width: 250px;
            background: #fff;
            border-radius: 8px;
            border: 1px solid #E4E6EF;
            padding: 0.75rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }

        .tsk-file-preview:hover {
            border-color: #009ef7;
            background: #F1FAFF;
            transform: translateY(-2px);
        }

        .tsk-file-preview-header {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .tsk-file-preview-icon {
            width: 32px;
            height: 32px;
            min-width: 32px;
            background: #F1FAFF;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #009ef7;
        }

        .tsk-file-preview-info {
            flex: 1;
            overflow: hidden;
        }

        .tsk-file-preview-name {
            font-size: 0.85rem;
            font-weight: 500;
            color: #3F4254;
            margin-bottom: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .tsk-file-preview-size {
            font-size: 0.75rem;
            color: #B5B5C3;
        }

        .tsk-file-preview-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 0.5rem;
        }

        /* Update the comments container to show more content */
        .tsk-comments-container {
            max-height: 500px;
            /* Increased height */
            overflow-y: auto;
            padding: 1.5rem 2rem;
        }

        /* Update comment spacing */
        .tsk-comment {
            padding: 1.25rem 0;
            border-bottom: 1px dashed #E4E6EF;
        }

        .tsk-comment:last-child {
            border-bottom: none;
        }

        /* Animations */
        @keyframes tsk-slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    {{-- active flag --}}
    <style>
        /* Add these to your existing styles */
        .tsk-card-badges {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
            flex-wrap: wrap;
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

        .tsk-card-status i {
            font-size: 6px;
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
            background-color: #E8FFF3;
            color: #50CD89;
        }

        .tsk-card-active-flag.inactive {
            background-color: #FFF5F8;
            color: #F1416C;
        }

        /* Update existing card styles */
        .tsk-card {
            padding: 1rem;
            margin-bottom: 0.75rem;
            background: #fff;
            border-radius: 0.5rem;
            border: 1px solid #E4E6EF;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }

        .tsk-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
        }
    </style>
    {{-- modal header styles --}}
    <style>
        /* Modal Header Styles */
        .modal-task-header {
            position: relative;
            padding: 0;
            overflow: hidden;
        }

        .task-header-bg {
            position: relative;
            background: linear-gradient(135deg, #009ef7 0%, #0095e8 100%);
            padding: 2.5rem 2rem 6rem;
            border-radius: 0.75rem 0.75rem 0 0;
        }

        .task-header-bg::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z' fill='rgba(255,255,255,0.05)' fill-rule='evenodd'/%3E%3C/svg%3E") center/auto repeat;
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
            max-width: 80%;
            line-height: 1.5;
        }

        .task-badges {
            display: flex;
            align-items: center;
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

        .task-badge i {
            font-size: 1rem;
        }

        /* Quick Info Panel */
        .task-quick-info {
            background: #fff;
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin: -4rem 1.5rem 0;
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
            background: var(--status-bg, rgba(0, 158, 247, 0.1));
            color: var(--status-color, #009ef7);
        }

        .info-icon.employee {
            background: rgba(80, 205, 137, 0.1);
            color: #50cd89;
        }

        .info-icon.active-state {
            background: rgba(255, 168, 0, 0.1);
            color: #ffa800;
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

        /* Responsive Adjustments */
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
    </style>

    <style>
        /* Status and Active Flag Badge Styles */
        .task-badges {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .task-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-badge {
            backdrop-filter: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .active-badge {
            background-color: #50CD89 !important;
            color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(80, 205, 137, 0.2);
        }

        .inactive-badge {
            background-color: #F1416C !important;
            color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(241, 65, 108, 0.2);
        }

        /* Status Badge Icon */
        .status-badge i {
            font-size: 8px;
            margin-right: 6px;
        }

        /* Active/Inactive Badge Icon */
        .active-badge i,
        .inactive-badge i {
            font-size: 14px;
            margin-right: 6px;
        }
    </style>
@endpush
@section('content')
    <!--begin::Content container-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                        rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <input type="text" data-col-index="search" data-kt-table-filter="search"
                                class="form-control datatable-input form-control-solid w-250px ps-14"
                                placeholder="{{ t('Search ' . Task::ui['s_ucf']) }}" />
                            <input type="hidden" name="selectedCaptin">
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-departments-table-toolbar="base">
                            @include(Task::ui['route'] . '.partials._filter')
                            <!--end::Add captins-->
                        </div>
                        <!--end::Toolbar-->

                        <!--begin::Modal - Add task-->
                        <div class="modal fade" id="kt_modal_add_captins" tabindex="-1" aria-hidden="true">
                            <!--begin::Modal dialog-->
                            <div class="modal-dialog modal-dialog-centered mw-650px">

                            </div>
                            <!--end::Modal dialog-->
                        </div>
                        <!--end::Modal - Add task-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Table-->


                    <div class="container-fluid">
                        <h1 class="my-4">Task Assignment Board</h1>
                        <div class="board tsk-board">
                            @foreach ($status_list as $status)
                                <div class="list tsk-list">
                                    <div class="list-header tsk-list-header">
                                        <div class="tsk-list-header-title">
                                            {{ $status->name }}
                                            <span
                                                class="badge tsk-status-badge">{{ ($tasks_assigned[$status->id] ?? collect())->count() }}</span>
                                        </div>
                                    </div>
                                    <div class="list-cards tsk-list-cards" id="{{ $status->value }}"
                                        data-status-id="{{ $status->id }}">
                                        @if (isset($tasks_assigned[$status->id]))
                                            @foreach ($tasks_assigned[$status->id] as $task_assigned)
                                                <div class="card task-card tsk-card" data-id="{{ $task_assigned->id }}"
                                                    data-current-status-id="{{ $status->id }}"
                                                    data-employee-id="{{ $task_assigned->employee_id }}"
                                                    style="--status-color: {{ $status->color }}">

                                                    <!-- Add badges container at the top -->
                                                    <div class="tsk-card-badges">
                                                        <!-- Status badge -->
                                                        <span class="tsk-card-status"
                                                            style="background-color: {{ $status->color }}15; color: {{ $status->color }}">
                                                            <i class="fas fa-circle fs-8"></i>
                                                            {{ $status->name }}
                                                        </span>
                                                        <!-- Active flag -->
                                                        <span
                                                            class="tsk-card-active-flag {{ $task_assigned->active ? 'active' : 'inactive' }}">
                                                            <i
                                                                class="fas {{ $task_assigned->active ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                                            {{ $task_assigned->active ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </div>

                                                    <div class="tsk-card-title">{{ $task_assigned->title }}</div>
                                                    <div class="tsk-card-description">
                                                        {{ Str::limit($task_assigned->description, 50) }}
                                                    </div>
                                                    <div class="tsk-card-meta">
                                                        <div class="tsk-card-dates">
                                                            @if ($task_assigned->start_date)
                                                                <div class="tsk-card-date">
                                                                    <i class="ki-duotone ki-calendar fs-6"></i>
                                                                    <span>Start:
                                                                        {{ $task_assigned->start_date->format('M d, Y') }}</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="tsk-card-actions mt-2">
                                                            <button type="button"
                                                                class="btn btn-sm btn-light-primary view-timeline-btn"
                                                                data-task-id="{{ $task_assigned->task->id }}"
                                                                data-task-title="{{ $task_assigned->task->title }}">
                                                                <i class="fas fa-stream"></i>
                                                                {{ t('View Timeline') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Content container-->

    <!-- Timeline Modal -->
    <div class="modal fade" id="taskTimelineModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Task Timeline</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="timeline-window-container">
                        <div class="stats-container d-none">
                            <!-- Stats will be injected here -->
                        </div>
                        <div id="timelineContent" class="timeline-container">
                            <!-- Timeline content will be injected here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="kt_modal_general" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-lg modal-dialog-centered">

        </div>
        <!--end::Modal dialog-->
    </div>



    <!-- Comments Modal -->
    <div class="modal fade tsk-comments-modal" id="processCommentsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bolder fs-1">{{ t('Comments') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div id="commentsContainer" class="tsk-comments-container">
                        <!-- Comments will be inserted here -->
                    </div>

                    <form id="commentForm" class="tsk-comment-form">
                        <div class="mb-5">
                            <textarea class="form-control tsk-comment-input" id="commentContent" rows="3"
                                placeholder="{{ t('Add a comment...') }}"></textarea>
                        </div>

                        <div class="mb-5">
                            <div class="tsk-dropzone" id="commentFileDropzone">
                                <div class="dz-message">
                                    <i class="ki-duotone ki-cloud-upload fs-2x text-primary"></i>
                                    <div class="text-gray-600 fs-5">{{ t('Drop files here or click to upload') }}</div>
                                    <div class="text-gray-400 fs-7 mt-1">{{ t('Maximum 5 files allowed') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-6">
                                <i class="ki-duotone ki-send-up fs-2 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                {{ t('Post Comment') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
    <script>
        const kt_modal_general = document.getElementById('kt_modal_general');
        const modal_kt_modal_general = new bootstrap.Modal(kt_modal_general);

        $(document).ready(function() {
            const currentEmployeeId = @json(auth()->user()->employee->id ?? null);
            const userRoles = {
                isAdmin: @json(auth()->user()->hasRole('super-admin')),
                isArtManager: @json(auth()->user()->hasRole('Art Manager')),
                isEmployee: @json(auth()->user()->hasRole('Trillionz Employees'))
            };

            // Constants
            const STATUSES = {
                PROCESSING: @json(getConstant(Modules::task_assignments_module, DropDownFields::employee_task_assignment_status, 'processing')->id),
                ART_MANAGER_APPROVAL: @json(getConstant(Modules::task_assignments_module,
                        DropDownFields::employee_task_assignment_status,
                        'art_manager_approval')->id),
                CUSTOMER_APPROVAL: @json(getConstant(Modules::task_assignments_module, DropDownFields::employee_task_assignment_status, 'customer_approval')->id),
                COMPLETED: @json(getConstant(Modules::task_assignments_module, DropDownFields::employee_task_assignment_status, 'completed')->id)
            };

            // Update the STATUS_NAMES object to include customer approval
            const STATUS_NAMES = {
                [STATUSES.PROCESSING]: 'Processing',
                [STATUSES.ART_MANAGER_APPROVAL]: 'Art Manager Approval',
                [STATUSES.CUSTOMER_APPROVAL]: 'Customer Approval',
                [STATUSES.COMPLETED]: 'Completed'
            };
            const currentUserId = @json(auth()->id());
            let lastErrorMessage = null; // Track last error to prevent duplicates

            // Update valid transitions to include all possible movements
            const validTransitions = {
                [STATUSES.PROCESSING]: [STATUSES.ART_MANAGER_APPROVAL],
                [STATUSES.ART_MANAGER_APPROVAL]: [STATUSES.CUSTOMER_APPROVAL, STATUSES.PROCESSING, STATUSES
                    .COMPLETED
                ],
                [STATUSES.CUSTOMER_APPROVAL]: [STATUSES.ART_MANAGER_APPROVAL, STATUSES.COMPLETED],
                [STATUSES.COMPLETED]: [STATUSES.CUSTOMER_APPROVAL, STATUSES.PROCESSING, STATUSES
                    .ART_MANAGER_APPROVAL
                ]
            };

            // Initialize Sortable for each list
            $('.list-cards').each(function() {
                new Sortable(this, {
                    group: {
                        name: 'shared',
                        pull: function(to, from, dragEl) {
                            return validateMovement(to, from, dragEl);
                        }
                    },
                    animation: 150,
                    onEnd: function(evt) {
                        handleTaskMove(evt);
                    }
                });
            });

            function showError(message) {
                // Prevent duplicate error messages
                if (lastErrorMessage === message) {
                    return;
                }
                lastErrorMessage = message;
                toastr.error(message);

                // Reset last error message after a delay
                setTimeout(() => {
                    lastErrorMessage = null;
                }, 1000);
            }

            function validateMovement(to, from, dragEl) {
                const newStatusId = Number($(to.el).attr('data-status-id'));
                const oldStatusId = Number($(from.el).attr('data-status-id'));
                const taskId = $(dragEl).data('id');

                // If user is admin or art manager, allow all movements
                if (userRoles.isAdmin || userRoles.isArtManager) {
                    return true;
                }

                // For Trillionz Employees
                if (userRoles.isEmployee) {
                    // Only allow movements between Processing and Art Manager Approval
                    const allowedTransitions = {
                        [STATUSES.PROCESSING]: [STATUSES.ART_MANAGER_APPROVAL],
                        [STATUSES.ART_MANAGER_APPROVAL]: [STATUSES.PROCESSING]
                    };

                    if (!allowedTransitions[oldStatusId] || !allowedTransitions[oldStatusId].includes(
                            newStatusId)) {
                        showError(
                            'As an employee, you can only move tasks between Processing and Art Manager Approval states'
                        );
                        return false;
                    }

                    // Verify the task is assigned to the current employee
                    const assignedEmployeeId = $(dragEl).data('employee-id');
                    if (assignedEmployeeId !== currentEmployeeId) {
                        showError('You can only move tasks assigned to you');
                        return false;
                    }

                    return true;
                }

                // If we reach here, user has no valid role
                showError('You do not have permission to move tasks');
                return false;
            }

            function getStatusFlow() {
                return "Task Flow: Processing → Art Manager Approval → Customer Approval → Completed";
            }

            function handleTaskMove(evt) {
                if (evt.from === evt.to) return;

                const $item = $(evt.item);
                const taskId = $item.data('id');
                const newStatusId = $(evt.to).data('status-id');
                const oldStatusId = $(evt.from).data('status-id');

                // Add loading class
                $item.addClass('tsk-loading');

                updateTaskStatus(taskId, newStatusId, oldStatusId, $item);
            }

            function updateTaskStatus(taskId, newStatusId, oldStatusId, $card) {
                $.ajax({
                    url: @json(route(Task::ui['route'] . '.move')),
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        task_id: taskId,
                        new_status_id: newStatusId,
                        old_status_id: oldStatusId
                    },
                    success: function(response) {
                        // Always remove loading state
                        $card.removeClass('tsk-loading');

                        if (response.success) {
                            toastr.success(response.message || 'Task moved successfully!');
                            if (response.task) {
                                updateTaskUI($card, response.task);
                            }
                        } else {
                            handleMovementError($card, oldStatusId, response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Always remove loading state
                        $card.removeClass('tsk-loading');

                        handleMovementError($card, oldStatusId,
                            xhr.responseJSON?.message || 'An error occurred while moving the task');
                    }
                });
            }


            function handleMovementError($card, originalStatusId, errorMessage) {
                // Show error message
                toastr.error(errorMessage);

                // Move card back to original position
                const $originalList = $(`[data-status-id="${originalStatusId}"]`);
                if ($originalList.length) {
                    $card.appendTo($originalList);
                }
            }

            function updateTaskUI($card, taskData) {
                if (taskData.status) {
                    // Update card border color
                    $card.css('--status-color', taskData.status.color);

                    // Update status badge - Fix for status name update
                    const $statusBadge = $card.find('.tsk-card-status');
                    if ($statusBadge.length) {
                        // Update both color and text content
                        $statusBadge
                            .css({
                                'background-color': `${taskData.status.color}15`,
                                'color': taskData.status.color
                            })
                            // Make sure to update the text content itself
                            .html(`
                    <i class="fas fa-circle fs-8"></i>
                    ${taskData.status.name}
                `);
                    }

                    // Rest of the updates...
                    if (taskData.title) {
                        $card.find('.tsk-card-title').text(taskData.title);
                    }
                    if (taskData.description) {
                        $card.find('.tsk-card-description').text(taskData.description);
                    }

                    // Update active status if it exists in the response
                    if (typeof taskData.active !== 'undefined') {
                        const $activeFlag = $card.find('.tsk-card-active-flag');
                        if ($activeFlag.length) {
                            $activeFlag
                                .removeClass('active inactive')
                                .addClass(taskData.active ? 'active' : 'inactive')
                                .html(`
                        <i class="fas ${taskData.active ? 'fa-check-circle' : 'fa-times-circle'}"></i>
                        ${taskData.active ? 'Active' : 'Inactive'}
                    `);
                        }
                    }

                    // Update data attributes
                    $card.attr('data-current-status-id', taskData.status.id);
                }
            }
            $('.list-cards').on('click', function(e) {
                // Get the clicked element and the closest task card and timeline button
                const $target = $(e.target);
                const $taskCard = $target.closest('.task-card');
                const $timelineBtn = $target.closest('.view-timeline-btn');

                // Handle timeline button click
                if ($timelineBtn.length > 0) {
                    e.preventDefault();
                    e.stopPropagation();

                    const taskId = $timelineBtn.data('task-id');
                    const taskTitle = $timelineBtn.data('task-title');

                    if (window.taskTimelineModal) {
                        window.taskTimelineModal.openTimelineModal(taskId, taskTitle);
                    }
                    return;
                }

                // Handle task card click if not clicking the timeline button
                if ($taskCard.length > 0 && !$timelineBtn.length) {
                    e.preventDefault();
                    const taskAssignmentId = $taskCard.data('id');
                    globalRenderModal(
                        "{{ route(Task::ui['route'] . '.details', [TaskAssignment::ui['s_lcf'] => ':taskAssignmentId']) }}"
                        .replace(':taskAssignmentId', taskAssignmentId),
                        $taskCard,
                        '#kt_modal_general',
                        modal_kt_modal_general
                    );
                }
            });





        });
    </script>
    <script>
        let currentProcessId = null;
        let commentDropzone = null;

        function openProcessComments(processId) {
            currentProcessId = processId;

            // Initialize Dropzone if not already initialized
            if (!commentDropzone) {
                commentDropzone = new Dropzone("#commentFileDropzone", {
                    url: "{{ route('projects.store_task_process_comments') }}",
                    autoProcessQueue: false,
                    addRemoveLinks: true,
                    maxFiles: 5,
                    acceptedFiles: 'image/*,.pdf,.doc,.docx,.xls,.xlsx',
                    dictDefaultMessage: 'Drop files here or click to upload'
                });
            }

            // Load comments
            loadProcessComments(processId);

            // Show modal
            $('#processCommentsModal').modal('show');
        }

        function renderCommentFiles(attachments) {
            if (!attachments?.length) return '';

            return `
        <div class="tsk-file-previews">
            ${attachments.map(attachment => `
                                                                                                                                        <div class="tsk-file-preview" id="attachment-${attachment.id}">
                                                                                                                                            <div class="tsk-file-preview-header">
                                                                                                                                                <div class="tsk-file-preview-icon">
                                                                                                                                                    <i class="ki-duotone ki-file fs-2">
                                                                                                                                                        <span class="path1"></span>
                                                                                                                                                        <span class="path2"></span>
                                                                                                                                                    </i>
                                                                                                                                                </div>
                                                                                                                                                <div class="tsk-file-preview-info">
                                                                                                                                                    <div class="tsk-file-preview-name" title="${attachment.file_name}">
                                                                                                                                                        ${attachment.file_name}
                                                                                                                                                    </div>
                                                                                                                                                    <div class="tsk-file-preview-size">
                                                                                                                                                        ${formatFileSize(attachment.file_size)}
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="tsk-file-preview-actions">
                                                                                                                                                <a href="${baseUrl}${attachment.file_path}"
                                                                                                                                                    class="btn btn-icon btn-sm btn-light-primary me-2"
                                                                                                                                                    target="_blank"
                                                                                                                                                    title="Download file">
                                                                                                                                                    <i class="ki-duotone ki-arrow-down fs-2">
                                                                                                                                                        <span class="path1"></span>
                                                                                                                                                        <span class="path2"></span>
                                                                                                                                                    </i>
                                                                                                                                                </a>
                                                                                                                                                <button type="button"
                                                                                                                                                        class="btn btn-icon btn-sm btn-light-danger"
                                                                                                                                                        onclick="deleteCommentFile(${attachment.id})"
                                                                                                                                                        title="Delete file">
                                                                                                                                                    <i class="ki-duotone ki-trash fs-2">
                                                                                                                                                        <span class="path1"></span>
                                                                                                                                                        <span class="path2"></span>
                                                                                                                                                        <span class="path3"></span>
                                                                                                                                                        <span class="path4"></span>
                                                                                                                                                        <span class="path5"></span>
                                                                                                                                                    </i>
                                                                                                                                                </button>
                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                    `).join('')}
        </div>
                `;
        }

        // Add the delete function
        function deleteCommentFile(attachmentId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                showLoaderOnConfirm: true,
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-active-light"
                },
                buttonsStyling: false,
                preConfirm: () => {
                    const url = "{{ route('remove-attachment', [':attachment']) }}"
                        // .replace(':project', projectId)
                        .replace(':attachment', attachmentId);

                    return $.ajax({
                        url: url,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).catch(error => {
                        Swal.showValidationMessage(
                            `Request failed: ${error.responseJSON?.message || 'Unknown error'}`
                        );
                    });
                }
            }).then((result) => {
                if (result.isConfirmed && result.value.success) {
                    // Remove the attachment element with animation
                    const attachmentElement = $(`#attachment-${attachmentId}`);
                    attachmentElement.addClass('fade-out');

                    setTimeout(() => {
                        attachmentElement.remove();

                        // If no more attachments, remove the container
                        const filePreviewsContainer = attachmentElement.closest('.tsk-file-previews');
                        if (filePreviewsContainer.children().length === 0) {
                            filePreviewsContainer.remove();
                        }

                        // Show success message
                        Swal.fire({
                            text: result.value.message || 'File has been deleted!',
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });

                        // Reload comments to ensure everything is in sync
                        loadProcessComments(currentProcessId);
                    }, 300);
                }
            });
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function loadProcessComments(processId) {
            $.ajax({
                url: "{{ route('projects.task_process_comments', ['task_process' => ':processId']) }}".replace(
                    ':processId', processId),
                method: 'GET',
                success: function(response) {
                    const commentsHtml = response.comments.map(comment => `
                <div class="tsk-comment">
                    <div class="tsk-comment-avatar">
                        ${comment.user.name.charAt(0)}
                    </div>
                    <div class="tsk-comment-content">
                        <div class="tsk-comment-header">
                            <span class="tsk-comment-user">${comment.user.name}</span>
                            <span class="tsk-comment-time">${moment(comment.created_at).fromNow()}</span>
                        </div>
                        <div class="tsk-comment-text">${comment.notes}</div>
                        ${renderCommentFiles(comment.attachments)}
                    </div>
                </div>
            `).join('');

                    $('#commentsContainer').html(commentsHtml);
                }
            });
        }
        // Handle comment form submission
        $('#commentForm').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData();
            formData.append('content', $('#commentContent').val());
            formData.append('task_process_id', currentProcessId);
            formData.append('_token', '{{ csrf_token() }}');

            // Add files from Dropzone
            if (commentDropzone?.files?.length) {
                commentDropzone.files.forEach((file, index) => {
                    formData.append(`files[${index}]`, file);
                });
            }

            $.ajax({
                url: "{{ route('projects.store_task_process_comments') }}",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        toastr.success('{{ t('Comment added successfully') }}');
                        $('#commentContent').val('');
                        commentDropzone.removeAllFiles();
                        loadProcessComments(currentProcessId);
                    } else {
                        toastr.error('{{ t('Failed to add comment') }}');
                    }
                },
                error: function(xhr) {
                    toastr.error('{{ t('An error occurred while adding the comment') }}');
                    console.error('Error:', xhr);
                }
            });
        });


        // Initialize Dropzone with enhanced configuration
        function initDropzone() {
            return new Dropzone("#commentFileDropzone", {
                url: "{{ route('projects.store_task_process_comments') }}",
                autoProcessQueue: false,
                addRemoveLinks: true,
                maxFiles: 5,
                maxFilesize: 10,
                acceptedFiles: 'image/*,.pdf,.doc,.docx,.xls,.xlsx',
                previewTemplate: `
            <div class="dz-preview">
                <span class="dz-success-mark">
                    <i class="ki-duotone ki-check fs-2 text-success">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </span>
                <span class="dz-error-mark">
                    <i class="ki-duotone ki-cross fs-2 text-danger">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </span>
                <div class="dz-details">
                    <div class="dz-filename">
                        <span data-dz-name></span>
                        <span class="dz-size" data-dz-size></span>
                    </div>
                </div>
                <a class="dz-remove" href="javascript:undefined;" data-dz-remove>
                    <i class="ki-duotone ki-trash fs-2 text-danger">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                        <span class="path4"></span>
                        <span class="path5"></span>
                    </i>
                </a>
            </div>
                `,
                dictDefaultMessage: `
                    <i class="ki-duotone ki-cloud-upload fs-2x text-primary mb-3">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <div class="text-gray-600 fs-5">Drop files here or click to upload</div>
                    <div class="text-gray-400 fs-7 mt-1">Maximum 5 files allowed</div>
                `,
                init: function() {
                    this.on("addedfile", function(file) {
                        // Add success mark by default since we're not uploading immediately
                        file.previewElement.classList.add('dz-success');
                    });

                    this.on("removedfile", function(file) {
                        // Handle file removal if needed
                    });
                }
            });
        }
    </script>


    <script>
        class TaskTimelineModal {
            constructor(config) {
                this.config = config;
                this.modal = null;
                this.currentTaskId = null;
                this.modalElement = document.getElementById('taskTimelineModal');
                this.initializeModal();
            }

            initializeModal() {
                if (!this.modalElement) {
                    console.error('Timeline modal element not found');
                    return;
                }
                this.modal = new bootstrap.Modal(this.modalElement);
            }

            openTimelineModal(taskId, taskTitle) {
                if (!this.modal) {
                    console.error('Timeline modal not initialized');
                    return;
                }

                this.currentTaskId = taskId;

                // Update modal title
                const modalTitle = this.modalElement.querySelector('.modal-title');
                if (modalTitle) {
                    modalTitle.textContent = `Task Timeline: ${taskTitle}`;
                }

                // Show loading state
                const timelineContent = this.modalElement.querySelector('#timelineContent');
                if (timelineContent) {
                    timelineContent.innerHTML = `
                <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>`;
                }

                // Show the modal
                this.modal.show();

                // Fetch timeline data
                const timelineUrl = this.config.routes.getTaskTimeline.replace(':taskId', taskId);

                $.ajax({
                    url: timelineUrl,
                    method: 'GET',
                    success: (response) => {
                        if (response.status) {
                            // Update stats
                            const statsContainer = this.modalElement.querySelector('.stats-container');
                            if (statsContainer) {
                                statsContainer.classList.remove('d-none');
                                statsContainer.innerHTML = `
                            <div class="stats-item">
                                <strong>Total Changes:</strong> ${response.stats.total_assignments}
                            </div>
                            <div class="stats-item">
                                <strong>Completed:</strong> ${response.stats.completed}
                            </div>
                            <div class="stats-item">
                                <strong>Processing:</strong> ${response.stats.processing}
                            </div>
                            <div class="stats-item">
                                <strong>Customer Approval:</strong> ${response.stats.customer_approval}
                            </div>
                            <div class="stats-item">
                                <strong>Art Manager Approval:</strong> ${response.stats.art_manager_approval}
                            </div>`;
                            }

                            // Update timeline content
                            if (timelineContent) {
                                timelineContent.innerHTML = response.timelineHtml;
                                this.initializeScrollSync();
                            }
                        } else {
                            if (timelineContent) {
                                timelineContent.innerHTML =
                                    '<div class="alert alert-danger">Failed to load timeline data</div>';
                            }
                        }
                    },
                    error: () => {
                        if (timelineContent) {
                            timelineContent.innerHTML =
                                '<div class="alert alert-danger">Failed to load timeline data</div>';
                        }
                    }
                });
            }

            initializeScrollSync() {
                const timelineContent = this.modalElement.querySelector('.timeline-content');
                if (timelineContent) {
                    timelineContent.addEventListener('scroll', (e) => {
                        // Add scroll synchronization logic if needed
                    });
                }
                $('.timeline-item').on('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const $taskAssignment = $(this);
                    const taskAssignmentId = $taskAssignment.data('task-assignment-id');

                    // Call the function to render the task assignment details modal
                    globalRenderModal(
                        "{{ route(Task::ui['route'] . '.details', [TaskAssignment::ui['s_lcf'] => ':taskAssignmentId']) }}"
                        .replace(':taskAssignmentId', taskAssignmentId),
                        $taskAssignment,
                        '#kt_modal_general',
                        modal_kt_modal_general
                    );
                });
            }
        }

        // Initialize the timeline modal handler when document is ready
        $(document).ready(() => {

            window.taskTimelineModal = new TaskTimelineModal({
                routes: {
                    getTaskTimeline: "{{ route(Task::ui['route'] . '.timeline', [':taskId']) }}"
                }
            });
        });
    </script>
@endpush

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Center Resource Reservation</title>
    <style>
        :root {
            --primary: #1e40af;
            --primary-dark: #1e3a8a;
            --primary-light: #3b82f6;
            --primary-lighter: #dbeafe;
            --secondary: #6366f1;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --white: #ffffff;
            --shadow-xs: 0 1px 1px rgba(0, 0, 0, 0.03);
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 16px;
            line-height: 1.6;
            color: var(--gray-700);
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
            min-height: 100vh;
        }

        /* Header Styles */
        .app-header {
            background: linear-gradient(to bottom, var(--white), var(--gray-50));
            border-bottom: 2px solid var(--primary-lighter);
            box-shadow: var(--shadow-md);
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(10px);
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 4rem;
        }

        .header-brand {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .header-brand:hover {
            opacity: 0.8;
            text-decoration: none;
        }

        .header-brand:hover {
            color: var(--primary-light);
        }

        /* User Avatar */
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 2px solid var(--gray-border);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
            background-color: var(--primary-light);
            color: var(--white);
            transition: all 0.2s ease;
            position: relative;
        }

        .user-avatar:hover {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Dropdown Menu */
        .user-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: var(--white);
            border: 1px solid var(--gray-border);
            border-radius: 0.5rem;
            box-shadow: var(--shadow-md);
            margin-top: 0.5rem;
            min-width: 280px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);
            transition: all 0.2s ease;
            z-index: 1000;
        }

        .user-menu.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .menu-header {
            padding: 1rem;
            border-bottom: 1px solid var(--gray-border);
            background-color: var(--gray-light);
            border-radius: 0.5rem 0.5rem 0 0;
        }

        .user-info {
            display: flex;
            gap: 0.75rem;
            align-items: center;
        }

        .user-info-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-light);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .user-info-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-details {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            font-size: 0.95rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-email {
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .menu-divider {
            height: 1px;
            background-color: var(--gray-border);
            margin: 0.5rem 0;
        }

        .menu-actions {
            padding: 0.5rem 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--text-primary);
            text-decoration: none;
            font-size: 0.95rem;
            transition: all 0.15s ease;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .menu-item:hover {
            background-color: var(--gray-light);
            color: var(--primary-dark);
        }

        .menu-item.logout {
            color: #ef4444;
            font-weight: 500;
        }

        .menu-item.logout:hover {
            background-color: rgba(239, 68, 68, 0.05);
        }

        /* Responsive */
        @media (max-width: 640px) {
            .header-container {
                padding: 0 0.75rem;
            }

            .header-brand {
                font-size: 1.1rem;
            }

            .user-menu {
                right: 0;
                left: auto;
            }
        }

        /* Auth Link */
        .auth-link {
            color: var(--primary-light);
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border: 1px solid var(--primary-light);
            border-radius: 0.375rem;
            transition: all 0.2s ease;
            display: inline-block;
        }

        .auth-link:hover {
            background-color: var(--primary-light);
            color: var(--white);
        }

        /* User Avatar Container */
        .user-avatar-wrapper {
            position: relative;
        }

        /* ============================================
           CUSTOM CSS - NO TAILWIND
           ============================================ */

        :root {
            --primary-color: #1e40af;
            --primary-dark: #1e3a8a;
            --primary-light: #3b82f6;
            --success-color: #16a34a;
            --danger-color: #dc2626;
            --warning-color: #ea580c;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-900: #111827;
            --border-color: #e5e7eb;
            --shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
            line-height: 1.5;
            color: var(--gray-900);
        }

        /* ============================================
           RESET & BASE STYLES
           ============================================ */

        a {
            color: var(--primary-color);
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* ============================================
           CONTAINER & LAYOUT
           ============================================ */

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .min-h-screen {
            min-height: 100vh;
        }

        .bg-gray-100 {
            background-color: var(--gray-100);
        }

        .bg-white {
            background-color: #ffffff;
        }

        .bg-gray-50 {
            background-color: var(--gray-50);
        }

        /* ============================================
           BUTTONS - IMPROVED
           ============================================ */

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            line-height: 1;
            box-shadow: var(--shadow-sm);
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: left 0.3s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            border: none;
        }

        .btn-primary:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
            text-decoration: none;
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background: var(--gray-100);
            color: var(--gray-700);
            border: 2px solid var(--gray-300);
        }

        .btn-secondary:hover {
            background: var(--white);
            border-color: var(--primary);
            color: var(--primary);
            text-decoration: none;
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: var(--white);
            border: none;
        }

        .btn-danger:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
            text-decoration: none;
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
            color: var(--white);
            border: none;
        }

        .btn-success:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
            text-decoration: none;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%);
            color: var(--white);
            border: none;
        }

        .btn-warning:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
            text-decoration: none;
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }

        .btn-lg {
            padding: 1rem 2rem;
            font-size: 1.1rem;
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
        }

        /* ============================================
           FORMS - IMPROVED
           ============================================ */

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.75rem;
            font-weight: 600;
            color: var(--gray-800);
            font-size: 0.95rem;
            letter-spacing: 0.3px;
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1.125rem;
            border: 2px solid var(--gray-200);
            border-radius: 0.5rem;
            font-family: inherit;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: var(--white);
        }

        .form-control::placeholder {
            color: var(--gray-400);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
            background: var(--white);
        }

        .form-control.is-invalid {
            border-color: var(--danger);
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        .invalid-feedback {
            display: block;
            color: var(--danger);
            font-size: 0.85rem;
            margin-top: 0.5rem;
            font-weight: 500;
        }

        /* ============================================
           CARDS & CONTAINERS - IMPROVED
           ============================================ */

        .card {
            background: var(--white);
            border: none;
            border-radius: 0.75rem;
            box-shadow: var(--shadow-md);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
        }

        .card-header {
            padding: 1.75rem;
            border-bottom: 2px solid var(--gray-100);
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
            font-weight: 700;
            color: var(--gray-800);
        }

        .card-body {
            padding: 1.75rem;
        }

        .card-footer {
            padding: 1.5rem 1.75rem;
            background: var(--gray-50);
            border-top: 2px solid var(--gray-100);
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        /* ============================================
           TABLES - IMPROVED
           ============================================ */

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95rem;
        }

        .table thead {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary) 100%);
            border-bottom: none;
        }

        .table th {
            padding: 1.25rem;
            text-align: left;
            font-weight: 700;
            color: var(--white);
            letter-spacing: 0.3px;
            text-transform: uppercase;
            font-size: 0.85rem;
        }

        .table td {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--gray-200);
            vertical-align: middle;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: var(--gray-50);
            box-shadow: inset 0 0 0 3px rgba(59, 130, 246, 0.05);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ============================================
           BADGES & LABELS - IMPROVED
           ============================================ */

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: var(--shadow-sm);
        }

        .badge-primary {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.15), rgba(59, 130, 246, 0.15));
            color: var(--primary-dark);
            border: 1.5px solid var(--primary-lighter);
        }

        .badge-success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(52, 211, 153, 0.15));
            color: var(--success);
            border: 1.5px solid #d1fae5;
        }

        .badge-danger {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.15), rgba(248, 113, 113, 0.15));
            color: var(--danger);
            border: 1.5px solid #fee2e2;
        }

        .badge-warning {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(251, 191, 36, 0.15));
            color: var(--warning);
            border: 1.5px solid #fef3c7;
        }

        .badge-secondary {
            background: linear-gradient(135deg, rgba(107, 114, 128, 0.15), rgba(156, 163, 175, 0.15));
            color: var(--gray-700);
            border: 1.5px solid var(--gray-200);
        }

        /* ============================================
           ALERTS - IMPROVED
           ============================================ */

        .alert {
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.5rem;
            border-radius: 0.75rem;
            border-left: 4px solid;
            display: flex;
            gap: 1rem;
            align-items: flex-start;
            box-shadow: var(--shadow-sm);
        }

        .alert-icon {
            font-size: 1.5rem;
            flex-shrink: 0;
            margin-top: 0.125rem;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(52, 211, 153, 0.1));
            border-color: var(--success);
            color: var(--success);
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(248, 113, 113, 0.1));
            border-color: var(--danger);
            color: var(--danger);
        }

        .alert-warning {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(251, 191, 36, 0.1));
            border-color: var(--warning);
            color: var(--warning);
        }

        .alert-info {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.1), rgba(59, 130, 246, 0.1));
            border-color: var(--primary);
            color: var(--primary-dark);
        }

        /* ============================================
           GRID LAYOUT - IMPROVED
           ============================================ */

        .grid {
            display: grid;
            gap: 2rem;
        }

        .grid-cols-1 {
            grid-template-columns: 1fr;
        }

        .grid-cols-2 {
            grid-template-columns: repeat(2, 1fr);
        }

        .grid-cols-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        .grid-cols-4 {
            grid-template-columns: repeat(4, 1fr);
        }

        /* ============================================
           FLEX UTILITIES - IMPROVED
           ============================================ */

        .flex {
            display: flex;
        }

        .flex-column {
            flex-direction: column;
        }

        @media (max-width: 768px) {
            .flex-md-row {
                flex-direction: column;
            }
        }

        @media (min-width: 769px) {
            .flex-md-row {
                flex-direction: row;
            }
        }

        @media (max-width: 768px) {
            .grid-md-cols-2 {
                grid-template-columns: 1fr;
            }
            .grid-md-cols-3 {
                grid-template-columns: 1fr;
            }
            .grid-md-cols-4 {
                grid-template-columns: 1fr;
            }
        }

        @media (min-width: 769px) {
            .grid-md-cols-2 {
                grid-template-columns: repeat(2, 1fr);
            }
            .grid-md-cols-3 {
                grid-template-columns: repeat(3, 1fr);
            }
            .grid-md-cols-4 {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        /* ============================================
           WIDTH UTILITIES
           ============================================ */

        .w-full { width: 100%; }
        .w-10 { width: 2.5rem; }
        .w-12 { width: 3rem; }
        .w-16 { width: 4rem; }
        .max-w-md { max-width: 28rem; }
        .max-w-lg { max-width: 32rem; }
        .max-w-2xl { max-width: 42rem; }
        .max-w-4xl { max-width: 56rem; }

        /* ============================================
           HEIGHT UTILITIES
           ============================================ */

        .h-10 { height: 2.5rem; }
        .h-12 { height: 3rem; }
        .h-16 { height: 4rem; }

        /* ============================================
           OVERFLOW UTILITIES
           ============================================ */

        .overflow-x-auto {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .overflow-hidden { overflow: hidden; }

        /* ============================================
           POSITION UTILITIES
           ============================================ */

        .fixed { position: fixed; }
        .absolute { position: absolute; }
        .relative { position: relative; }
        .sticky { position: sticky; }

        .inset-0 {
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        /* ============================================
           Z-INDEX UTILITIES
           ============================================ */

        .z-10 { z-index: 10; }
        .top-0 { top: 0; }
        .top-16 { top: 4rem; }
        .right-0 { right: 0; }
        .left-0 { left: 0; }

        /* ============================================
           PADDING EDGE UTILITIES
           ============================================ */

        .pb-4 { padding-bottom: 1rem; }

        /* ============================================
           JUSTIFY CONTENT
           ============================================ */

        .justify-end { justify-content: flex-end; }

        /* ============================================
           SPACE UTILITIES
           ============================================ */

        .space-y-4 > * + * { margin-top: 1rem; }

        /* ============================================
           OPACITY UTILITIES
           ============================================ */

        .bg-opacity-50 { background-color: rgba(0, 0, 0, 0.5); }

        /* ============================================
           FLEX SHRINK
           ============================================ */

        .flex-shrink-0 { flex-shrink: 0; }

        .flex-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .flex-center {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .flex-start {
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }

        .flex-end {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .gap-1 { gap: 0.25rem; }
        .gap-2 { gap: 0.5rem; }
        .gap-3 { gap: 0.75rem; }
        .gap-4 { gap: 1rem; }
        .gap-6 { gap: 1.5rem; }
        .gap-8 { gap: 2rem; }

        /* ============================================
           CONTAINER
           ============================================ */

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .container-sm {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .min-h-screen {
            min-height: 100vh;
        }

        /* ============================================
           SPACING UTILITIES - EXTENDED
           ============================================ */

        .m-0 { margin: 0; }
        .m-1 { margin: 0.25rem; }
        .m-2 { margin: 0.5rem; }
        .m-3 { margin: 0.75rem; }
        .m-4 { margin: 1rem; }
        .m-6 { margin: 1.5rem; }
        .m-8 { margin: 2rem; }

        .mb-0 { margin-bottom: 0; }
        .mb-1 { margin-bottom: 0.25rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-3 { margin-bottom: 0.75rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mb-8 { margin-bottom: 2rem; }

        .mt-1 { margin-top: 0.25rem; }
        .mt-2 { margin-top: 0.5rem; }
        .mt-3 { margin-top: 0.75rem; }
        .mt-4 { margin-top: 1rem; }
        .mt-6 { margin-top: 1.5rem; }
        .mt-8 { margin-top: 2rem; }

        .mx-auto { margin-left: auto; margin-right: auto; }

        .px-2 { padding-left: 0.5rem; padding-right: 0.5rem; }
        .px-3 { padding-left: 0.75rem; padding-right: 0.75rem; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
        .px-8 { padding-left: 2rem; padding-right: 2rem; }

        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
        .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
        .py-6 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
        .py-8 { padding-top: 2rem; padding-bottom: 2rem; }

        .p-2 { padding: 0.5rem; }
        .p-3 { padding: 0.75rem; }
        .p-4 { padding: 1rem; }
        .p-6 { padding: 1.5rem; }
        .p-8 { padding: 2rem; }

        /* ============================================
           TEXT UTILITIES - EXTENDED
           ============================================ */

        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .text-justify { text-align: justify; }

        .text-xs { font-size: 0.75rem; }
        .text-sm { font-size: 0.875rem; }
        .text-base { font-size: 1rem; }
        .text-lg { font-size: 1.125rem; }
        .text-xl { font-size: 1.25rem; }
        .text-2xl { font-size: 1.5rem; }
        .text-3xl { font-size: 1.875rem; }
        .text-4xl { font-size: 2.25rem; }

        .font-light { font-weight: 300; }
        .font-normal { font-weight: 400; }
        .font-medium { font-weight: 500; }
        .font-semibold { font-weight: 600; }
        .font-bold { font-weight: 700; }
        .font-extrabold { font-weight: 800; }

        .text-gray-600 { color: var(--gray-600); }
        .text-gray-700 { color: var(--gray-700); }
        .text-gray-800 { color: var(--gray-800); }
        .text-gray-900 { color: var(--gray-900); }
        .text-primary { color: var(--primary); }
        .text-primary-dark { color: var(--primary-dark); }
        .text-secondary { color: var(--secondary); }
        .text-danger { color: var(--danger); }
        .text-success { color: var(--success); }
        .text-warning { color: var(--warning); }
        .text-info { color: var(--info); }
        .text-white { color: var(--white); }

        /* ============================================
           BACKGROUND UTILITIES
           ============================================ */

        .bg-white { background-color: var(--white); }
        .bg-gray-50 { background-color: var(--gray-50); }
        .bg-gray-100 { background-color: var(--gray-100); }
        .bg-gray-200 { background-color: var(--gray-200); }
        .bg-primary { background-color: var(--primary); }
        .bg-primary-light { background-color: var(--primary-lighter); }
        .bg-secondary { background-color: var(--secondary); }
        .bg-danger { background-color: var(--danger); }
        .bg-success { background-color: var(--success); }
        .bg-warning { background-color: var(--warning); }
        .bg-info { background-color: var(--info); }

        /* ============================================
           SHADOW UTILITIES
           ============================================ */

        .shadow-none { box-shadow: none; }
        .shadow-xs { box-shadow: var(--shadow-xs); }
        .shadow-sm { box-shadow: var(--shadow-sm); }
        .shadow-md { box-shadow: var(--shadow-md); }
        .shadow-lg { box-shadow: var(--shadow-lg); }
        .shadow-xl { box-shadow: var(--shadow-xl); }

        /* ============================================
           BORDER UTILITIES
           ============================================ */

        .border { border: 1px solid var(--gray-200); }
        .border-0 { border: none; }
        .border-t { border-top: 1px solid var(--gray-200); }
        .border-r { border-right: 1px solid var(--gray-200); }
        .border-b { border-bottom: 1px solid var(--gray-200); }
        .border-l { border-left: 1px solid var(--gray-200); }
        .border-l-4 { border-left: 4px solid; }

        .border-primary { border-color: var(--primary); }
        .border-danger { border-color: var(--danger); }
        .border-success { border-color: var(--success); }
        .border-warning { border-color: var(--warning); }

        .rounded { border-radius: 0.375rem; }
        .rounded-sm { border-radius: 0.25rem; }
        .rounded-md { border-radius: 0.5rem; }
        .rounded-lg { border-radius: 0.75rem; }
        .rounded-full { border-radius: 9999px; }

        /* ============================================
           DISPLAY UTILITIES
           ============================================ */

        .hidden { display: none !important; }
        .block { display: block; }
        .inline { display: inline; }
        .inline-block { display: inline-block; }
        .inline-flex { display: inline-flex; }

        /* ============================================
           RESPONSIVE
           ============================================ */

        @media (max-width: 1024px) {
            .grid-cols-4 {
                grid-template-columns: repeat(2, 1fr);
            }

            .grid-cols-3 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 1rem;
            }

            .container-sm {
                padding: 0 1rem;
            }

            .grid-cols-2,
            .grid-cols-3,
            .grid-cols-4 {
                grid-template-columns: 1fr;
            }

            .btn {
                width: 100%;
            }

            .card-body,
            .card-header {
                padding: 1.25rem;
            }

            .table {
                font-size: 0.85rem;
            }

            .table th,
            .table td {
                padding: 0.75rem;
            }

            .header-container {
                padding: 0 1rem;
            }

            .flex-between {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
        }

        @media (max-width: 480px) {
            body {
                font-size: 14px;
            }

            .text-lg { font-size: 1rem; }
            .text-xl { font-size: 1.125rem; }
            .text-2xl { font-size: 1.25rem; }

            .header-brand {
                font-size: 1.25rem;
            }

            .grid {
                gap: 1rem;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="app-header">
        <div class="header-container">
            <!-- Brand -->
            <a href="{{ route('resources.index') }}" class="header-brand">
                📊 DataCenter Reservation
            </a>

            <!-- User Section -->
            <div>
                @auth
                    <div class="user-avatar-wrapper" id="userAvatarWrapper">
                        <button 
                            class="user-avatar" 
                            id="userAvatarBtn" 
                            aria-label="User menu"
                            aria-expanded="false"
                            aria-haspopup="true"
                            title="{{ Auth::user()->name }}">
                            @if(Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}">
                            @else
                                @php
                                    $name = Auth::user()->name;
                                    $parts = explode(' ', trim($name));
                                    $initials = strtoupper($parts[0][0]);
                                    if (count($parts) > 1 && !empty($parts[1])) {
                                        $initials .= strtoupper($parts[1][0]);
                                    } else if (strlen($parts[0]) > 1) {
                                        $initials .= strtoupper($parts[0][1]);
                                    }
                                @endphp
                                {{ $initials }}
                            @endif
                        </button>

                        <!-- Dropdown Menu -->
                        <div class="user-menu" id="userMenu" role="menu">
                            <!-- Menu Header -->
                            <div class="menu-header">
                                <div class="user-info">
                                    <div class="user-info-avatar">
                                        @if(Auth::user()->avatar)
                                            <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}">
                                        @else
                                            @php
                                                $name = Auth::user()->name;
                                                $parts = explode(' ', trim($name));
                                                $initials = strtoupper($parts[0][0]);
                                                if (count($parts) > 1 && !empty($parts[1])) {
                                                    $initials .= strtoupper($parts[1][0]);
                                                } else if (strlen($parts[0]) > 1) {
                                                    $initials .= strtoupper($parts[0][1]);
                                                }
                                            @endphp
                                            {{ $initials }}
                                        @endif
                                    </div>
                                    <div class="user-details">
                                        <p class="user-name">{{ Auth::user()->name }}</p>
                                        <p class="user-email">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="menu-divider"></div>

                            <!-- Menu Actions -->
                            <div class="menu-actions">
                                <a href="{{ route('resources.index') }}" class="menu-item" role="menuitem">
                                    🏠 Resources
                                </a>
                                <a href="{{ route('reservations.index') }}" class="menu-item" role="menuitem">
                                    📅 My Reservations
                                </a>

                                @if(Auth::user()->isAdmin())
                                    <div class="menu-divider"></div>
                                    <a href="{{ route('admin.dashboard') }}" class="menu-item" role="menuitem">
                                        ⚙️ Admin Dashboard
                                    </a>
                                @endif

                                <div class="menu-divider"></div>

                                <!-- Logout -->
                                <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                                    @csrf
                                    <button 
                                        type="submit" 
                                        class="menu-item logout" 
                                        role="menuitem"
                                        title="Logout">
                                        🚪 Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="auth-link">
                        🔐 Login
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Content -->
    @yield('content')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userAvatarBtn = document.getElementById('userAvatarBtn');
            const userMenu = document.getElementById('userMenu');
            const userAvatarWrapper = document.getElementById('userAvatarWrapper');

            if (!userAvatarBtn) return;

            // Toggle menu on avatar click
            userAvatarBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const isActive = userMenu.classList.contains('active');
                userMenu.classList.toggle('active');
                userAvatarBtn.setAttribute('aria-expanded', !isActive);
            });

            // Close menu when clicking outside
            document.addEventListener('click', function(e) {
                if (userAvatarWrapper && !userAvatarWrapper.contains(e.target)) {
                    userMenu.classList.remove('active');
                    userAvatarBtn.setAttribute('aria-expanded', 'false');
                }
            });

            // Close menu on ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    userMenu.classList.remove('active');
                    userAvatarBtn.setAttribute('aria-expanded', 'false');
                }
            });

            // Handle menu item clicks
            const menuItems = userMenu.querySelectorAll('.menu-item');
            menuItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    // If it's the logout button, allow form submission
                    if (this.tagName === 'BUTTON' && this.classList.contains('logout')) {
                        return; // Allow default form submission
                    }
                    // For links, close the menu
                    if (this.tagName === 'A') {
                        userMenu.classList.remove('active');
                        userAvatarBtn.setAttribute('aria-expanded', 'false');
                    }
                });
            });
        });
    </script>
</body>
</html>

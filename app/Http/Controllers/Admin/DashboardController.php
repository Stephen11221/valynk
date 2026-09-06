<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the main admin dashboard overview.
     */
    public function index(Request $request): View
    {
        $kpis = [
            [
                'title' => 'Total Users',
                'value' => '18,540',
                'growth' => '21% from last month',
                'icon' => 'fa-users',
                'bg' => 'bg-purple-50 text-purple-600',
                'chart_color' => '#8B5CF6',
                'sparkline' => [20, 35, 25, 45, 30, 55, 40, 60],
            ],
            [
                'title' => 'Active Families',
                'value' => '7,842',
                'growth' => '18% from last month',
                'icon' => 'fa-user-group',
                'bg' => 'bg-emerald-50 text-emerald-600',
                'chart_color' => '#10B981',
                'sparkline' => [15, 25, 20, 38, 32, 45, 39, 52],
            ],
            [
                'title' => 'Verified Providers',
                'value' => '2,156',
                'growth' => '19% from last month',
                'icon' => 'fa-user-doctor',
                'bg' => 'bg-sky-50 text-sky-600',
                'chart_color' => '#0EA5E9',
                'sparkline' => [10, 18, 28, 22, 35, 30, 48, 42],
            ],
            [
                'title' => 'Partner Institutions',
                'value' => '328',
                'growth' => '16% from last month',
                'icon' => 'fa-building-columns',
                'bg' => 'bg-amber-50 text-amber-600',
                'chart_color' => '#F59E0B',
                'sparkline' => [12, 20, 16, 28, 24, 38, 30, 40],
            ],
            [
                'title' => 'Successful Matches',
                'value' => '5,432',
                'growth' => '24% from last month',
                'icon' => 'fa-link',
                'bg' => 'bg-indigo-50 text-indigo-600',
                'chart_color' => '#6366F1',
                'sparkline' => [22, 30, 28, 42, 36, 50, 48, 62],
            ],
            [
                'title' => 'Total Revenue',
                'value' => 'KES 7,842,500',
                'growth' => '23% from last month',
                'icon' => 'fa-wallet',
                'bg' => 'bg-emerald-50 text-emerald-600',
                'chart_color' => '#10B981',
                'sparkline' => [18, 26, 34, 40, 38, 52, 46, 58],
            ],
        ];

        $matchesOverview = [
            'total' => '5,432',
            'completed' => ['count' => '2,856', 'percent' => '52.6%', 'color' => 'bg-emerald-500', 'hex' => '#10B981'],
            'in_progress' => ['count' => '1,642', 'percent' => '30.2%', 'color' => 'bg-sky-500', 'hex' => '#0EA5E9'],
            'pending' => ['count' => '584', 'percent' => '10.7%', 'color' => 'bg-amber-500', 'hex' => '#F59E0B'],
            'cancelled' => ['count' => '350', 'percent' => '6.5%', 'color' => 'bg-rose-500', 'hex' => '#EF4444'],
        ];

        $recentAlerts = [
            [
                'title' => 'High dispute volume detected',
                'desc' => '12 disputes require urgent attention.',
                'time' => '10:25 AM',
                'type' => 'danger',
                'icon' => 'fa-shield-halved',
                'bg' => 'bg-rose-50 border-rose-200 text-rose-600',
            ],
            [
                'title' => 'Provider verification pending',
                'desc' => '18 providers awaiting document review.',
                'time' => '09:40 AM',
                'type' => 'warning',
                'icon' => 'fa-triangle-exclamation',
                'bg' => 'bg-amber-50 border-amber-200 text-amber-600',
            ],
            [
                'title' => 'Payment failure alert',
                'desc' => '5 payments failed in the last 24 hours.',
                'time' => '08:15 AM',
                'type' => 'info',
                'icon' => 'fa-circle-info',
                'bg' => 'bg-purple-50 border-purple-200 text-purple-600',
            ],
            [
                'title' => 'System backup completed',
                'desc' => 'Daily backup completed successfully.',
                'time' => 'Yesterday',
                'type' => 'success',
                'icon' => 'fa-circle-check',
                'bg' => 'bg-emerald-50 border-emerald-200 text-emerald-600',
            ],
        ];

        $topCategories = [
            ['name' => 'Academic Support', 'matches' => '1,245', 'growth' => '28%', 'rating' => '4.8', 'icon' => 'fa-graduation-cap', 'bg' => 'text-sky-600 bg-sky-50'],
            ['name' => 'Wellness & Counseling', 'matches' => '982', 'growth' => '22%', 'rating' => '4.7', 'icon' => 'fa-heart-pulse', 'bg' => 'text-emerald-600 bg-emerald-50'],
            ['name' => 'Career Guidance', 'matches' => '876', 'growth' => '26%', 'rating' => '4.6', 'icon' => 'fa-compass', 'bg' => 'text-amber-600 bg-amber-50'],
            ['name' => 'Skills Development', 'matches' => '754', 'growth' => '17%', 'rating' => '4.5', 'icon' => 'fa-paperclip', 'bg' => 'text-purple-600 bg-purple-50'],
            ['name' => 'Technology & Digital', 'matches' => '532', 'growth' => '15%', 'rating' => '4.4', 'icon' => 'fa-laptop-code', 'bg' => 'text-indigo-600 bg-indigo-50'],
        ];

        $revenueData = [
            'total' => 'KES 7,842,500',
            'growth' => '23% from last month',
            'months' => [
                ['name' => 'Dec', 'val' => 4.2],
                ['name' => 'Jan', 'val' => 5.1],
                ['name' => 'Feb', 'val' => 6.2],
                ['name' => 'Mar', 'val' => 6.8],
                ['name' => 'Apr', 'val' => 7.2],
                ['name' => 'May', 'val' => 7.8],
            ],
        ];

        $systemHealth = [
            'uptime' => '99.9%',
            'services' => [
                ['name' => 'Database', 'status' => 'Operational'],
                ['name' => 'Payment Gateway', 'status' => 'Operational'],
                ['name' => 'Email Service', 'status' => 'Operational'],
                ['name' => 'File Storage', 'status' => 'Operational'],
                ['name' => 'API Services', 'status' => 'Operational'],
            ],
        ];

        return view('admin.dashboard', compact(
            'kpis',
            'matchesOverview',
            'recentAlerts',
            'topCategories',
            'revenueData',
            'systemHealth'
        ));
    }

    /**
     * Manage Users (Families, Providers, Institutions).
     */
    public function users(Request $request): View
    {
        $role = $request->query('role', 'all');
        $search = $request->query('search', '');

        $allUsers = collect([
            [
                'id' => 101,
                'name' => 'Dr. Elena Rostova',
                'email' => 'elena.rostova@valynk-providers.org',
                'role' => 'Provider',
                'category' => 'Pediatrics Specialist',
                'status' => 'Verified',
                'matches_count' => 48,
                'rating' => 4.9,
                'joined' => '2025-03-12',
            ],
            [
                'id' => 102,
                'name' => 'Sarah & James Miller',
                'email' => 's.miller@gmail.com',
                'role' => 'Family',
                'category' => 'Child & Family Care',
                'status' => 'Active',
                'matches_count' => 3,
                'rating' => 5.0,
                'joined' => '2025-11-04',
            ],
            [
                'id' => 103,
                'name' => 'St. Jude Children Hospital',
                'email' => 'admin@stjude-partner.org',
                'role' => 'Institution',
                'category' => 'Hospital Network',
                'status' => 'Verified Partner',
                'matches_count' => 312,
                'rating' => 4.8,
                'joined' => '2024-08-15',
            ],
            [
                'id' => 104,
                'name' => 'Marcus Vance',
                'email' => 'm.vance@behavioralhealth.com',
                'role' => 'Provider',
                'category' => 'Behavioral Health',
                'status' => 'Verified',
                'matches_count' => 29,
                'rating' => 4.7,
                'joined' => '2025-06-20',
            ],
            [
                'id' => 105,
                'name' => 'Oakridge Academy District',
                'email' => 'partnerships@oakridge.edu',
                'role' => 'Institution',
                'category' => 'Educational Institution',
                'status' => 'Pending Verification',
                'matches_count' => 84,
                'rating' => 4.9,
                'joined' => '2026-01-10',
            ],
            [
                'id' => 106,
                'name' => 'David & Linda Chen',
                'email' => 'dlchen@outlook.com',
                'role' => 'Family',
                'category' => 'Eldercare Support',
                'status' => 'Active',
                'matches_count' => 2,
                'rating' => 4.9,
                'joined' => '2026-02-18',
            ],
            [
                'id' => 107,
                'name' => 'Aura Elderly Care Services',
                'email' => 'contact@auracare.com',
                'role' => 'Provider',
                'category' => 'Geriatric Care Provider',
                'status' => 'Verified',
                'matches_count' => 64,
                'rating' => 4.8,
                'joined' => '2025-01-29',
            ],
            [
                'id' => 108,
                'name' => 'Apex Tech Solutions',
                'email' => 'hr@apextech.com',
                'role' => 'Institution',
                'category' => 'Corporate Partner',
                'status' => 'Verified Partner',
                'matches_count' => 120,
                'rating' => 4.6,
                'joined' => '2025-09-01',
            ],
        ]);

        if ($role !== 'all') {
            $allUsers = $allUsers->filter(fn ($u) => strtolower($u['role']) === strtolower($role));
        }

        if (! empty($search)) {
            $allUsers = $allUsers->filter(fn ($u) => str_contains(strtolower($u['name']), strtolower($search)) || str_contains(strtolower($u['email']), strtolower($search)));
        }

        return view('admin.users', [
            'users' => $allUsers,
            'currentRole' => $role,
            'search' => $search,
        ]);
    }

    /**
     * Display Provider Management page.
     */
    public function providers(Request $request): View
    {
        $kpis = [
            [
                'title' => 'Total Providers',
                'value' => '4,156',
                'growth' => '22% from last month',
                'icon' => 'fa-users',
                'bg' => 'bg-purple-50 text-purple-600',
                'chart_color' => '#8B5CF6',
                'sparkline' => [20, 35, 25, 45, 30, 55, 40, 60],
            ],
            [
                'title' => 'Approved Providers',
                'value' => '2,856',
                'growth' => '18% from last month',
                'icon' => 'fa-circle-check',
                'bg' => 'bg-emerald-50 text-emerald-600',
                'chart_color' => '#10B981',
                'sparkline' => [15, 25, 20, 38, 32, 45, 39, 52],
            ],
            [
                'title' => 'Pending Review',
                'value' => '842',
                'growth' => '12% from last month',
                'icon' => 'fa-clock',
                'bg' => 'bg-amber-50 text-amber-600',
                'chart_color' => '#F59E0B',
                'sparkline' => [10, 18, 28, 22, 35, 30, 48, 42],
            ],
            [
                'title' => 'Rejected Providers',
                'value' => '458',
                'growth' => '5% from last month',
                'growth_is_down' => true,
                'icon' => 'fa-circle-xmark',
                'bg' => 'bg-rose-50 text-rose-600',
                'chart_color' => '#EF4444',
                'sparkline' => [30, 25, 20, 18, 15, 12, 10, 8],
            ],
            [
                'title' => 'Verified Providers',
                'value' => '2,156',
                'growth' => '19% from last month',
                'icon' => 'fa-shield-halved',
                'bg' => 'bg-sky-50 text-sky-600',
                'chart_color' => '#0EA5E9',
                'sparkline' => [22, 30, 28, 42, 36, 50, 48, 62],
            ],
            [
                'title' => 'Total Payouts',
                'value' => 'KES 3,842,500',
                'growth' => '24% from last month',
                'icon' => 'fa-wallet',
                'bg' => 'bg-emerald-50 text-emerald-600',
                'chart_color' => '#10B981',
                'sparkline' => [18, 26, 34, 40, 38, 52, 46, 58],
            ],
        ];

        $providersList = collect([
            [
                'id' => 1,
                'initials' => 'MW',
                'avatar_bg' => 'bg-teal-700 text-white',
                'name' => 'MindWell Center',
                'email' => 'info@mindwell.co.ke',
                'service' => 'Counseling & Therapy',
                'category' => 'Wellness & Counseling',
                'category_bg' => 'bg-purple-100 text-purple-700',
                'status' => 'Approved',
                'status_bg' => 'bg-emerald-100 text-emerald-800',
                'verification' => 'Verified',
                'verification_icon' => 'fa-circle-check text-emerald-500',
                'verification_color' => 'text-emerald-700',
                'rating' => '4.8',
                'stars' => 5,
                'joined' => '18 Jan 2025',
            ],
            [
                'id' => 2,
                'initials' => 'CA',
                'avatar_bg' => 'bg-blue-600 text-white',
                'name' => 'Career Academy',
                'email' => 'hello@careeracademy.co.ke',
                'service' => 'Career Coaching',
                'category' => 'Career Guidance',
                'category_bg' => 'bg-amber-100 text-amber-800',
                'status' => 'Pending',
                'status_bg' => 'bg-amber-100 text-amber-800',
                'verification' => 'Under Review',
                'verification_icon' => 'fa-clock text-amber-500',
                'verification_color' => 'text-amber-700',
                'rating' => '4.6',
                'stars' => 4,
                'joined' => '25 May 2025',
            ],
            [
                'id' => 3,
                'initials' => 'LT',
                'avatar_bg' => 'bg-slate-800 text-white',
                'name' => 'LearnTech Solutions',
                'email' => 'contact@learntech.co.ke',
                'service' => 'STEM Education',
                'category' => 'Academic Support',
                'category_bg' => 'bg-sky-100 text-sky-700',
                'status' => 'Approved',
                'status_bg' => 'bg-emerald-100 text-emerald-800',
                'verification' => 'Verified',
                'verification_icon' => 'fa-circle-check text-emerald-500',
                'verification_color' => 'text-emerald-700',
                'rating' => '4.7',
                'stars' => 4,
                'joined' => '10 Feb 2025',
            ],
            [
                'id' => 4,
                'initials' => 'FL',
                'avatar_bg' => 'bg-amber-600 text-white',
                'name' => 'Future Leaders Hub',
                'email' => 'admin@futureleaders.co.ke',
                'service' => 'Leadership Training',
                'category' => 'Skills Development',
                'category_bg' => 'bg-purple-100 text-purple-700',
                'status' => 'Rejected',
                'status_bg' => 'bg-rose-100 text-rose-800',
                'verification' => 'Not Verified',
                'verification_icon' => 'fa-circle-xmark text-rose-500',
                'verification_color' => 'text-rose-700',
                'rating' => '—',
                'stars' => 0,
                'joined' => '12 May 2025',
            ],
            [
                'id' => 5,
                'initials' => 'BE',
                'avatar_bg' => 'bg-emerald-600 text-white',
                'name' => 'Bright Energy Studio',
                'email' => 'hello@brightenergy.co.ke',
                'service' => 'Life Coaching',
                'category' => 'Wellness & Counseling',
                'category_bg' => 'bg-purple-100 text-purple-700',
                'status' => 'Approved',
                'status_bg' => 'bg-emerald-100 text-emerald-800',
                'verification' => 'Verified',
                'verification_icon' => 'fa-circle-check text-emerald-500',
                'verification_color' => 'text-emerald-700',
                'rating' => '4.9',
                'stars' => 5,
                'joined' => '05 Jan 2025',
            ],
            [
                'id' => 6,
                'initials' => 'KC',
                'avatar_bg' => 'bg-sky-600 text-white',
                'name' => 'Kids Code Academy',
                'email' => 'info@kidscode.co.ke',
                'service' => 'Coding for Kids',
                'category' => 'Academic Support',
                'category_bg' => 'bg-sky-100 text-sky-700',
                'status' => 'Pending',
                'status_bg' => 'bg-amber-100 text-amber-800',
                'verification' => 'Under Review',
                'verification_icon' => 'fa-clock text-amber-500',
                'verification_color' => 'text-amber-700',
                'rating' => '4.5',
                'stars' => 4,
                'joined' => '27 May 2025',
            ],
            [
                'id' => 7,
                'initials' => 'HR',
                'avatar_bg' => 'bg-rose-600 text-white',
                'name' => 'HealthRise Services',
                'email' => 'contact@healthrise.co.ke',
                'service' => 'Nutrition & Wellness',
                'category' => 'Wellness & Counseling',
                'category_bg' => 'bg-purple-100 text-purple-700',
                'status' => 'Approved',
                'status_bg' => 'bg-emerald-100 text-emerald-800',
                'verification' => 'Verified',
                'verification_icon' => 'fa-circle-check text-emerald-500',
                'verification_color' => 'text-emerald-700',
                'rating' => '4.6',
                'stars' => 4,
                'joined' => '03 Mar 2025',
            ],
            [
                'id' => 8,
                'initials' => 'AI',
                'avatar_bg' => 'bg-purple-600 text-white',
                'name' => 'Art Inspire Studio',
                'email' => 'studio@artinspire.co.ke',
                'service' => 'Creative Arts',
                'category' => 'Skills Development',
                'category_bg' => 'bg-purple-100 text-purple-700',
                'status' => 'Rejected',
                'status_bg' => 'bg-rose-100 text-rose-800',
                'verification' => 'Not Verified',
                'verification_icon' => 'fa-circle-xmark text-rose-500',
                'verification_color' => 'text-rose-700',
                'rating' => '—',
                'stars' => 0,
                'joined' => '22 May 2025',
            ],
        ]);

        $statusDonut = [
            'total' => '4,156',
            'approved' => ['count' => '2,856', 'percent' => '68.7%'],
            'pending' => ['count' => '842', 'percent' => '20.3%'],
            'rejected' => ['count' => '458', 'percent' => '11.0%'],
        ];

        $verificationDonut = [
            'total' => '4,156',
            'verified' => ['count' => '2,156', 'percent' => '51.9%'],
            'under_review' => ['count' => '1,184', 'percent' => '28.5%'],
            'not_verified' => ['count' => '816', 'percent' => '19.6%'],
        ];

        $recentRegistrations = [
            [
                'initials' => 'CA',
                'avatar_bg' => 'bg-blue-600 text-white',
                'name' => 'Career Academy',
                'service' => 'Career Coaching',
                'date' => '27 May 2025',
                'time' => '11:20 AM',
            ],
            [
                'initials' => 'KC',
                'avatar_bg' => 'bg-sky-600 text-white',
                'name' => 'Kids Code Academy',
                'service' => 'Coding for Kids',
                'date' => '27 May 2025',
                'time' => '10:05 AM',
            ],
            [
                'initials' => 'MW',
                'avatar_bg' => 'bg-teal-700 text-white',
                'name' => 'MindWell Center',
                'service' => 'Counseling & Therapy',
                'date' => '27 May 2025',
                'time' => '09:15 AM',
            ],
            [
                'initials' => 'BE',
                'avatar_bg' => 'bg-emerald-600 text-white',
                'name' => 'Bright Energy Studio',
                'service' => 'Life Coaching',
                'date' => '26 May 2025',
                'time' => '04:45 PM',
            ],
            [
                'initials' => 'HR',
                'avatar_bg' => 'bg-rose-600 text-white',
                'name' => 'HealthRise Services',
                'service' => 'Nutrition & Wellness',
                'date' => '26 May 2025',
                'time' => '02:30 PM',
            ],
        ];

        return view('admin.providers', compact(
            'kpis',
            'providersList',
            'statusDonut',
            'verificationDonut',
            'recentRegistrations'
        ));
    }

    /**
     * Manage Evidence-Backed Matches.
     */
    public function matches(Request $request): View
    {
        $status = $request->query('status', 'all');

        $matches = collect([
            [
                'id' => 'M-1001',
                'family' => 'Sarah & James Miller',
                'provider' => 'Dr. Elena Rostova',
                'institution' => 'St. Jude Children Hospital',
                'match_score' => 98,
                'evidence_factors' => ['Geographic Proximity', 'Specialist Clinical Outcome 99%', 'Insurance Alignment'],
                'status' => 'Active',
                'created_at' => '2026-09-04',
            ],
            [
                'id' => 'M-1002',
                'family' => 'Oakridge Academy',
                'provider' => 'Marcus Vance',
                'institution' => 'Oakridge District',
                'match_score' => 94,
                'evidence_factors' => ['Specialized Education Certification', 'Student Outcome Tracking'],
                'status' => 'Pending Review',
                'created_at' => '2026-09-04',
            ],
            [
                'id' => 'M-1003',
                'family' => 'David & Linda Chen',
                'provider' => 'Aura Elderly Care Services',
                'institution' => 'Pacific Healthcare Network',
                'match_score' => 96,
                'evidence_factors' => ['In-Home Care Specialty', 'Geriatric Board Certified', 'High Patient Satisfaction'],
                'status' => 'Active',
                'created_at' => '2026-09-03',
            ],
            [
                'id' => 'M-1004',
                'family' => 'Apex Tech Solutions',
                'provider' => 'WellnessFirst Enterprise',
                'institution' => 'Corporate Wellness Alliance',
                'match_score' => 91,
                'evidence_factors' => ['Corporate Wellbeing Metric', 'Scalable Employee Program'],
                'status' => 'Active',
                'created_at' => '2026-09-02',
            ],
            [
                'id' => 'M-1005',
                'family' => 'Rachel Thompson',
                'provider' => 'Dr. Aris Thorne',
                'institution' => 'Metro Health Center',
                'match_score' => 99,
                'evidence_factors' => ['Pediatric Neuro Specialty', 'Verified Clinical Protocols', 'Direct Referral'],
                'status' => 'Completed',
                'created_at' => '2026-08-28',
            ],
        ]);

        if ($status !== 'all') {
            $matches = $matches->filter(fn ($m) => strtolower(str_replace(' ', '_', $m['status'])) === strtolower(str_replace(' ', '_', $status)));
        }

        return view('admin.matches', [
            'matches' => $matches,
            'currentStatus' => $status,
        ]);
    }

    /**
     * Transaction Management page.
     */
    public function transactions(): View
    {
        $stats = [
            ['title' => 'Total Transactions', 'value' => '25,842', 'change' => '+23% from last month', 'positive' => true, 'color' => 'bg-purple-50 text-purple-600', 'icon' => 'fa-arrow-right-arrow-left', 'sparkline' => [10, 22, 18, 30, 24, 42, 36, 52]],
            ['title' => 'Total Volume', 'value' => 'KES 12,845,300', 'change' => '+28% from last month', 'positive' => true, 'color' => 'bg-emerald-50 text-emerald-600', 'icon' => 'fa-wallet', 'sparkline' => [20, 28, 24, 38, 44, 46, 52, 58]],
            ['title' => 'Successful Transactions', 'value' => '23,716', 'change' => '+22% from last month', 'positive' => true, 'color' => 'bg-emerald-50 text-emerald-600', 'icon' => 'fa-circle-check', 'sparkline' => [18, 27, 20, 33, 44, 40, 57, 68]],
            ['title' => 'Failed Transactions', 'value' => '1,142', 'change' => '-4% from last month', 'positive' => false, 'color' => 'bg-rose-50 text-rose-600', 'icon' => 'fa-circle-xmark', 'sparkline' => [70, 62, 60, 48, 45, 40, 35, 30]],
            ['title' => 'Refunds Issued', 'value' => '482', 'change' => '+16% from last month', 'positive' => true, 'color' => 'bg-sky-50 text-sky-600', 'icon' => 'fa-rotate-left', 'sparkline' => [18, 24, 20, 28, 26, 35, 30, 39]],
            ['title' => 'Average Transaction Value', 'value' => 'KES 497', 'change' => '+5% from last month', 'positive' => true, 'color' => 'bg-blue-50 text-blue-600', 'icon' => 'fa-chart-simple', 'sparkline' => [21, 26, 25, 22, 30, 35, 38, 41]],
        ];

        $transactions = collect([
            ['id' => 'TRX-2025-05270', 'date' => '27 May 2025', 'time' => '10:24 AM', 'user' => 'Mary Wanjiku', 'user_role' => 'Parent', 'provider' => 'MindWell Center', 'provider_tag' => 'Counseling & Therapy', 'type' => 'Service Payment', 'amount' => 'KES 3,500', 'method' => 'M-Pesa', 'status' => 'Completed', 'status_class' => 'bg-emerald-100 text-emerald-800', 'institution' => 'MindWell Center'],
            ['id' => 'TRX-2025-05269', 'date' => '27 May 2025', 'time' => '09:58 AM', 'user' => 'John Kamau', 'user_role' => 'Parent', 'provider' => 'Career Academy', 'provider_tag' => 'Career Coaching', 'type' => 'Service Payment', 'amount' => 'KES 4,200', 'method' => 'Card (Visa)', 'status' => 'Completed', 'status_class' => 'bg-emerald-100 text-emerald-800', 'institution' => 'Career Academy'],
            ['id' => 'TRX-2025-05268', 'date' => '27 May 2025', 'time' => '09:31 AM', 'user' => 'Grace Achieng', 'user_role' => 'Parent', 'provider' => 'Bright Future Academy', 'provider_tag' => 'Academic Coaching', 'type' => 'Subscription', 'amount' => 'KES 7,000', 'method' => 'Card (Mastercard)', 'status' => 'Completed', 'status_class' => 'bg-emerald-100 text-emerald-800', 'institution' => 'Bright Future Academy'],
            ['id' => 'TRX-2025-05267', 'date' => '27 May 2025', 'time' => '09:12 AM', 'user' => 'David Ochieng', 'user_role' => 'Parent', 'provider' => 'LearnTech Solutions', 'provider_tag' => 'STEM Education', 'type' => 'Service Payment', 'amount' => 'KES 8,200', 'method' => 'M-Pesa', 'status' => 'Completed', 'status_class' => 'bg-emerald-100 text-emerald-800', 'institution' => 'LearnTech Solutions'],
            ['id' => 'TRX-2025-05266', 'date' => '26 May 2025', 'time' => '04:45 PM', 'user' => 'Esther Njeri', 'user_role' => 'Parent', 'provider' => 'Kids Code Academy', 'provider_tag' => 'Coding for Kids', 'type' => 'Service Payment', 'amount' => 'KES 3,000', 'method' => 'Card (Visa)', 'status' => 'Failed', 'status_class' => 'bg-rose-100 text-rose-800', 'institution' => 'Kids Code Academy'],
            ['id' => 'TRX-2025-05265', 'date' => '26 May 2025', 'time' => '03:20 PM', 'user' => 'Peter Mwangi', 'user_role' => 'Parent', 'provider' => 'Skills & More Institute', 'provider_tag' => 'Skills Development', 'type' => 'Subscription', 'amount' => 'KES 5,500', 'method' => 'M-Pesa', 'status' => 'Completed', 'status_class' => 'bg-emerald-100 text-emerald-800', 'institution' => 'Skills & More Institute'],
            ['id' => 'TRX-2025-05264', 'date' => '26 May 2025', 'time' => '02:15 PM', 'user' => 'Amina Hassan', 'user_role' => 'Parent', 'provider' => 'HealthRise Services', 'provider_tag' => 'Nutrition & Wellness', 'type' => 'Service Payment', 'amount' => 'KES 2,200', 'method' => 'Card (Visa)', 'status' => 'Refunded', 'status_class' => 'bg-amber-100 text-amber-800', 'institution' => 'HealthRise Services'],
            ['id' => 'TRX-2025-05263', 'date' => '26 May 2025', 'time' => '11:05 AM', 'user' => 'Brian Otieno', 'user_role' => 'Parent', 'provider' => 'Future Leaders Hub', 'provider_tag' => 'Leadership Training', 'type' => 'Service Payment', 'amount' => 'KES 3,800', 'method' => 'Card (Mastercard)', 'status' => 'Completed', 'status_class' => 'bg-emerald-100 text-emerald-800', 'institution' => 'Future Leaders Hub'],
        ]);

        return view('admin.transactions', compact('stats', 'transactions'));
    }

    /**
     * Payment Management page.
     */
    public function payments(): View
    {
        $stats = [
            ['title' => 'Total Volume', 'value' => 'KES 12,845,300', 'change' => '+28% from last month', 'positive' => true, 'icon' => 'fa-wallet', 'color' => 'bg-purple-50 text-purple-600', 'sparkline' => [16, 18, 24, 29, 26, 38, 44, 52]],
            ['title' => 'Successful Payments', 'value' => 'KES 11,928,700', 'change' => '+26% from last month', 'positive' => true, 'icon' => 'fa-circle-check', 'color' => 'bg-emerald-50 text-emerald-600', 'sparkline' => [20, 26, 30, 28, 38, 42, 52, 60]],
            ['title' => 'Pending Payments', 'value' => 'KES 643,200', 'change' => '+12% from last month', 'positive' => true, 'icon' => 'fa-clock', 'color' => 'bg-amber-50 text-amber-600', 'sparkline' => [15, 18, 22, 19, 27, 31, 27, 35]],
            ['title' => 'Refunds Processed', 'value' => 'KES 273,400', 'change' => '-8% from last month', 'positive' => false, 'icon' => 'fa-rotate-left', 'color' => 'bg-rose-50 text-rose-600', 'sparkline' => [28, 26, 24, 20, 18, 16, 14, 12]],
            ['title' => 'Payouts to Providers', 'value' => 'KES 9,856,100', 'change' => '+22% from last month', 'positive' => true, 'icon' => 'fa-paper-plane', 'color' => 'bg-sky-50 text-sky-600', 'sparkline' => [18, 20, 22, 32, 40, 37, 48, 55]],
            ['title' => 'Average Transaction Value', 'value' => 'KES 497', 'change' => '+5% from last month', 'positive' => true, 'icon' => 'fa-chart-simple', 'color' => 'bg-blue-50 text-blue-600', 'sparkline' => [21, 25, 27, 22, 30, 35, 39, 42]],
        ];

        $payments = collect([
            ['id' => 'PAY-2025-05270', 'date' => '27 May 2025', 'time' => '10:24 AM', 'user' => 'Mary Wanjiku', 'user_role' => 'Parent', 'provider' => 'MindWell Center', 'provider_tag' => 'Counseling & Therapy', 'type' => 'Service Payment', 'amount' => 'KES 3,500', 'method' => 'M-Pesa', 'status' => 'Completed', 'status_class' => 'bg-emerald-100 text-emerald-800', 'institution' => 'MindWell Center'],
            ['id' => 'PAY-2025-05269', 'date' => '27 May 2025', 'time' => '09:58 AM', 'user' => 'John Kamau', 'user_role' => 'Parent', 'provider' => 'Career Academy', 'provider_tag' => 'Career Coaching', 'type' => 'Service Payment', 'amount' => 'KES 4,200', 'method' => 'Card (Visa)', 'status' => 'Completed', 'status_class' => 'bg-emerald-100 text-emerald-800', 'institution' => 'Career Academy'],
            ['id' => 'PAY-2025-05268', 'date' => '27 May 2025', 'time' => '09:31 AM', 'user' => 'Grace Achieng', 'user_role' => 'Parent', 'provider' => 'Bright Future Academy', 'provider_tag' => 'Academic Coaching', 'type' => 'Subscription', 'amount' => 'KES 7,000', 'method' => 'Card (Mastercard)', 'status' => 'Completed', 'status_class' => 'bg-emerald-100 text-emerald-800', 'institution' => 'Bright Future Academy'],
            ['id' => 'PAY-2025-05267', 'date' => '27 May 2025', 'time' => '09:12 AM', 'user' => 'David Ochieng', 'user_role' => 'Parent', 'provider' => 'LearnTech Solutions', 'provider_tag' => 'STEM Education', 'type' => 'Service Payment', 'amount' => 'KES 8,200', 'method' => 'M-Pesa', 'status' => 'Completed', 'status_class' => 'bg-emerald-100 text-emerald-800', 'institution' => 'LearnTech Solutions'],
            ['id' => 'PAY-2025-05266', 'date' => '26 May 2025', 'time' => '04:45 PM', 'user' => 'Esther Njeri', 'user_role' => 'Parent', 'provider' => 'Kids Code Academy', 'provider_tag' => 'Coding for Kids', 'type' => 'Service Payment', 'amount' => 'KES 3,000', 'method' => 'Card (Visa)', 'status' => 'Failed', 'status_class' => 'bg-rose-100 text-rose-800', 'institution' => 'Kids Code Academy'],
            ['id' => 'PAY-2025-05265', 'date' => '26 May 2025', 'time' => '03:20 PM', 'user' => 'Peter Mwangi', 'user_role' => 'Parent', 'provider' => 'Skills & More Institute', 'provider_tag' => 'Skills Development', 'type' => 'Subscription', 'amount' => 'KES 5,500', 'method' => 'M-Pesa', 'status' => 'Completed', 'status_class' => 'bg-emerald-100 text-emerald-800', 'institution' => 'Skills & More Institute'],
            ['id' => 'PAY-2025-05264', 'date' => '26 May 2025', 'time' => '02:15 PM', 'user' => 'Amina Hassan', 'user_role' => 'Parent', 'provider' => 'HealthRise Services', 'provider_tag' => 'Nutrition & Wellness', 'type' => 'Service Payment', 'amount' => 'KES 2,200', 'method' => 'Card (Visa)', 'status' => 'Refunded', 'status_class' => 'bg-amber-100 text-amber-800', 'institution' => 'HealthRise Services'],
            ['id' => 'PAY-2025-05263', 'date' => '26 May 2025', 'time' => '11:05 AM', 'user' => 'Brian Otieno', 'user_role' => 'Parent', 'provider' => 'Future Leaders Hub', 'provider_tag' => 'Leadership Training', 'type' => 'Service Payment', 'amount' => 'KES 3,800', 'method' => 'Card (Mastercard)', 'status' => 'Completed', 'status_class' => 'bg-emerald-100 text-emerald-800', 'institution' => 'Future Leaders Hub'],
        ]);

        return view('admin.payments', compact('stats', 'payments'));
    }

    /**
     * Subscription Management page.
     */
    public function subscriptions(): View
    {
        $stats = [
            ['title' => 'Total Subscriptions', 'value' => '8,642', 'change' => '+15% from last month', 'positive' => true, 'icon' => 'fa-user', 'color' => 'bg-purple-50 text-purple-600', 'sparkline' => [15, 20, 18, 26, 22, 36, 30, 42]],
            ['title' => 'Active Subscriptions', 'value' => '6,725', 'change' => '+20% from last month', 'positive' => true, 'icon' => 'fa-circle-check', 'color' => 'bg-emerald-50 text-emerald-600', 'sparkline' => [18, 24, 28, 30, 35, 40, 48, 56]],
            ['title' => 'New Subscriptions', 'value' => '1,254', 'change' => '+15% from last month', 'positive' => true, 'icon' => 'fa-user-plus', 'color' => 'bg-sky-50 text-sky-600', 'sparkline' => [10, 16, 20, 18, 25, 32, 28, 38]],
            ['title' => 'Expiring Soon', 'value' => '312', 'change' => '+8% from last month', 'positive' => true, 'icon' => 'fa-circle-exclamation', 'color' => 'bg-amber-50 text-amber-600', 'sparkline' => [30, 22, 26, 21, 18, 24, 20, 14]],
            ['title' => 'Cancelled', 'value' => '351', 'change' => '-5% from last month', 'positive' => false, 'icon' => 'fa-circle-xmark', 'color' => 'bg-rose-50 text-rose-600', 'sparkline' => [42, 36, 29, 22, 18, 16, 12, 9]],
            ['title' => 'MRR (This Month)', 'value' => 'KES 4,256,800', 'change' => '+2% from last month', 'positive' => true, 'icon' => 'fa-dollar-sign', 'color' => 'bg-green-50 text-green-600', 'sparkline' => [18, 24, 20, 28, 32, 37, 41, 46]],
        ];

        $subscriptions = collect([
            ['id' => 'SUB-2025-05264', 'subscriber' => 'Mary Wanjiku', 'email' => 'mary.wanjiku@gmail.com', 'userType' => 'Family', 'plan' => 'Family Premium', 'amount' => 'KES 2,950', 'billing' => 'Monthly', 'startDate' => '01 May 2025', 'nextBilling' => '01 Jun 2025', 'status' => 'Active', 'status_class' => 'bg-emerald-100 text-emerald-800'],
            ['id' => 'SUB-2025-05263', 'subscriber' => 'John Kamau', 'email' => 'john.kamau@gmail.com', 'userType' => 'Individual', 'plan' => 'Individual Plus', 'amount' => 'KES 1,500', 'billing' => 'Monthly', 'startDate' => '15 Apr 2025', 'nextBilling' => '15 May 2025', 'status' => 'Active', 'status_class' => 'bg-emerald-100 text-emerald-800'],
            ['id' => 'SUB-2025-05262', 'subscriber' => 'MindWell Center', 'email' => 'info@mindwell.co.ke', 'userType' => 'Provider', 'plan' => 'Provider Growth', 'amount' => 'KES 4,500', 'billing' => 'Monthly', 'startDate' => '10 Apr 2025', 'nextBilling' => '10 May 2025', 'status' => 'Active', 'status_class' => 'bg-emerald-100 text-emerald-800'],
            ['id' => 'SUB-2025-05261', 'subscriber' => 'Bright Future Academy', 'email' => 'admin@brightfuture.ac.ke', 'userType' => 'Institution', 'plan' => 'Institution Pro', 'amount' => 'KES 7,500', 'billing' => 'Monthly', 'startDate' => '05 Apr 2025', 'nextBilling' => '05 Jun 2025', 'status' => 'Active', 'status_class' => 'bg-emerald-100 text-emerald-800'],
            ['id' => 'SUB-2025-05260', 'subscriber' => 'Career Academy', 'email' => 'hello@careeracademy.co.ke', 'userType' => 'Provider', 'plan' => 'Provider Starter', 'amount' => 'KES 2,500', 'billing' => 'Monthly', 'startDate' => '28 Apr 2025', 'nextBilling' => '28 May 2025', 'status' => 'Expiring Soon', 'status_class' => 'bg-amber-100 text-amber-800'],
            ['id' => 'SUB-2025-05259', 'subscriber' => 'Grace Achieng', 'email' => 'grace@gmail.com', 'userType' => 'Individual', 'plan' => 'Individual Basic', 'amount' => 'KES 800', 'billing' => 'Monthly', 'startDate' => '27 Mar 2025', 'nextBilling' => '27 May 2025', 'status' => 'Active', 'status_class' => 'bg-emerald-100 text-emerald-800'],
            ['id' => 'SUB-2025-05258', 'subscriber' => 'Skills & More Institute', 'email' => 'info@skillsandmore.co.ke', 'userType' => 'Institution', 'plan' => 'Institution Standard', 'amount' => 'KES 4,000', 'billing' => 'Monthly', 'startDate' => '12 Apr 2025', 'nextBilling' => '12 Jun 2025', 'status' => 'Active', 'status_class' => 'bg-emerald-100 text-emerald-800'],
            ['id' => 'SUB-2025-05257', 'subscriber' => 'Kids Code Academy', 'email' => 'info@kidscode.co.ke', 'userType' => 'Provider', 'plan' => 'Provider Growth', 'amount' => 'KES 4,500', 'billing' => 'Monthly', 'startDate' => '01 May 2025', 'nextBilling' => '01 Jun 2025', 'status' => 'Cancelled', 'status_class' => 'bg-rose-100 text-rose-800'],
        ]);

        return view('admin.subscriptions', compact('stats', 'subscriptions'));
    }

    /**
     * Content Management page.
     */
    public function content(): View
    {
        $content = collect([
            ['title' => 'Homepage Hero Banner', 'type' => 'Banner', 'section' => 'Homepage', 'status' => 'Published', 'status_class' => 'bg-emerald-100 text-emerald-800', 'language' => 'English', 'updated' => '26 May 2025', 'updated_by' => 'Admin User'],
            ['title' => 'Our Story', 'type' => 'Page', 'section' => 'About Us', 'status' => 'Published', 'status_class' => 'bg-emerald-100 text-emerald-800', 'language' => 'English', 'updated' => '25 May 2025', 'updated_by' => 'Admin User'],
            ['title' => 'How It Works', 'type' => 'Page', 'section' => 'How It Works', 'status' => 'Published', 'status_class' => 'bg-emerald-100 text-emerald-800', 'language' => 'English', 'updated' => '25 May 2025', 'updated_by' => 'Kevin O.'],
            ['title' => 'For Families', 'type' => 'Page', 'section' => 'For Families', 'status' => 'Published', 'status_class' => 'bg-emerald-100 text-emerald-800', 'language' => 'English', 'updated' => '23 May 2025', 'updated_by' => 'Alice M.'],
            ['title' => 'For Providers', 'type' => 'Page', 'section' => 'For Providers', 'status' => 'Published', 'status_class' => 'bg-emerald-100 text-emerald-800', 'language' => 'English', 'updated' => '23 May 2025', 'updated_by' => 'Yusuf A.'],
            ['title' => 'For Institutions', 'type' => 'Page', 'section' => 'For Institutions', 'status' => 'Published', 'status_class' => 'bg-emerald-100 text-emerald-800', 'language' => 'English', 'updated' => '22 May 2025', 'updated_by' => 'Kevin O.'],
            ['title' => 'Solutions Overview', 'type' => 'Page', 'section' => 'Solutions', 'status' => 'Draft', 'status_class' => 'bg-amber-100 text-amber-800', 'language' => 'English', 'updated' => '21 May 2025', 'updated_by' => 'Beth N.'],
            ['title' => 'Pricing Plans', 'type' => 'Page', 'section' => 'Pricing', 'status' => 'Scheduled', 'status_class' => 'bg-sky-100 text-sky-800', 'language' => 'English', 'updated' => '20 May 2025', 'updated_by' => 'Admin User'],
            ['title' => 'Contact Us', 'type' => 'Page', 'section' => 'Contact', 'status' => 'Published', 'status_class' => 'bg-emerald-100 text-emerald-800', 'language' => 'English', 'updated' => '20 May 2025', 'updated_by' => 'Admin User'],
            ['title' => 'Blog: Building Strong Families', 'type' => 'Blog Post', 'section' => 'Resources / Blog', 'status' => 'Published', 'status_class' => 'bg-emerald-100 text-emerald-800', 'language' => 'English', 'updated' => '19 May 2025', 'updated_by' => 'Maureen N.'],
        ]);

        $stats = [
            ['title' => 'Total Content Items', 'value' => '1,248', 'change' => '+18% from last month', 'positive' => true, 'icon' => 'fa-newspaper', 'color' => 'bg-purple-50 text-purple-600', 'sparkline' => [12, 18, 16, 22, 24, 28, 32, 38]],
            ['title' => 'Published Items', 'value' => '986', 'change' => '+20% from last month', 'positive' => true, 'icon' => 'fa-earth-africa', 'color' => 'bg-emerald-50 text-emerald-600', 'sparkline' => [16, 20, 19, 25, 27, 34, 31, 43]],
            ['title' => 'Draft Items', 'value' => '142', 'change' => '+8% from last month', 'positive' => true, 'icon' => 'fa-pen-to-square', 'color' => 'bg-amber-50 text-amber-600', 'sparkline' => [20, 18, 15, 19, 21, 22, 18, 24]],
            ['title' => 'Scheduled Items', 'value' => '68', 'change' => '-5% from last month', 'positive' => false, 'icon' => 'fa-calendar', 'color' => 'bg-sky-50 text-sky-600', 'sparkline' => [22, 18, 16, 14, 13, 12, 11, 10]],
            ['title' => 'Archived Items', 'value' => '52', 'change' => '+10% from last month', 'positive' => true, 'icon' => 'fa-box-archive', 'color' => 'bg-rose-50 text-rose-600', 'sparkline' => [12, 16, 15, 18, 17, 20, 19, 24]],
            ['title' => 'Total Page Views', 'value' => '245,680', 'change' => '+22% from last month', 'positive' => true, 'icon' => 'fa-eye', 'color' => 'bg-green-50 text-green-600', 'sparkline' => [20, 26, 22, 28, 30, 35, 40, 46]],
        ];

        return view('admin.content', compact('stats', 'content'));
    }

    /**
     * Reports & Analytics page.
     */
    public function reports(): View
    {
        $stats = [
            ['title' => 'Total Users', 'value' => '23,856', 'change' => '+15% from last month', 'positive' => true, 'icon' => 'fa-users', 'color' => 'bg-purple-50 text-purple-600', 'sparkline' => [18, 20, 22, 26, 28, 30, 32, 38]],
            ['title' => 'Active Matches', 'value' => '2,856', 'change' => '+22% from last month', 'positive' => true, 'icon' => 'fa-link', 'color' => 'bg-emerald-50 text-emerald-600', 'sparkline' => [15, 18, 24, 28, 32, 34, 39, 45]],
            ['title' => 'Total Transactions', 'value' => '25,842', 'change' => '+23% from last month', 'positive' => true, 'icon' => 'fa-credit-card', 'color' => 'bg-sky-50 text-sky-600', 'sparkline' => [12, 20, 18, 26, 30, 32, 36, 42]],
            ['title' => 'Total Revenue (KES)', 'value' => '12,845,300', 'change' => '+28% from last month', 'positive' => true, 'icon' => 'fa-wallet', 'color' => 'bg-amber-50 text-amber-600', 'sparkline' => [15, 20, 18, 28, 24, 32, 39, 48]],
            ['title' => 'Conversion Rate', 'value' => '11.2%', 'change' => '+4% from last month', 'positive' => true, 'icon' => 'fa-chart-line', 'color' => 'bg-rose-50 text-rose-600', 'sparkline' => [10, 15, 14, 17, 20, 23, 27, 31]],
            ['title' => 'Customer Satisfaction', 'value' => '4.7 / 5', 'change' => '+6% from last month', 'positive' => true, 'icon' => 'fa-star', 'color' => 'bg-green-50 text-green-600', 'sparkline' => [18, 20, 17, 22, 26, 32, 35, 38]],
        ];

        $performance = [
            ['segment' => 'Families', 'users' => 12458, 'matches' => 1842, 'transactions' => 84542, 'revenue' => 2568000],
            ['segment' => 'Providers', 'users' => 6324, 'matches' => 756, 'transactions' => 1642, 'revenue' => 3856200],
            ['segment' => 'Institutions', 'users' => 3256, 'matches' => 186, 'transactions' => 2856, 'revenue' => 2145600],
            ['segment' => 'Individual Users', 'users' => 1818, 'matches' => 72, 'transactions' => 1542, 'revenue' => 586700],
        ];

        return view('admin.reports', compact('stats', 'performance'));
    }

    /**
     * Communication Management page.
     */
    public function communications(): View
    {
        $stats = [
            ['title' => 'Message Sent', 'value' => '12,845', 'change' => '+26% from last month', 'positive' => true, 'icon' => 'fa-envelope', 'color' => 'bg-purple-50 text-purple-600', 'sparkline' => [14, 18, 22, 20, 28, 30, 35, 41]],
            ['title' => 'Delivery Rate', 'value' => '98.6%', 'change' => '+2.4% from last month', 'positive' => true, 'icon' => 'fa-paper-plane', 'color' => 'bg-emerald-50 text-emerald-600', 'sparkline' => [20, 24, 22, 27, 29, 32, 35, 39]],
            ['title' => 'Open Rate', 'value' => '42.7%', 'change' => '+6.8% from last month', 'positive' => true, 'icon' => 'fa-envelope-open', 'color' => 'bg-sky-50 text-sky-600', 'sparkline' => [12, 16, 18, 15, 20, 23, 28, 31]],
            ['title' => 'Click Rate', 'value' => '8.3%', 'change' => '+1.9% from last month', 'positive' => true, 'icon' => 'fa-mouse-pointer', 'color' => 'bg-amber-50 text-amber-600', 'sparkline' => [8, 9, 10, 11, 13, 15, 16, 18]],
            ['title' => 'Unsubscribes', 'value' => '186', 'change' => '+5% from last month', 'positive' => false, 'icon' => 'fa-user-slash', 'color' => 'bg-rose-50 text-rose-600', 'sparkline' => [50, 42, 36, 28, 24, 18, 14, 10]],
            ['title' => 'Engagement Score', 'value' => '4.6 / 5', 'change' => '+8% from last month', 'positive' => true, 'icon' => 'fa-star', 'color' => 'bg-green-50 text-green-600', 'sparkline' => [16, 18, 19, 22, 25, 29, 33, 34]],
        ];

        $communications = collect([
            ['id' => 'MSG-2025-05270', 'subject' => 'Welcome to VALYNK', 'type' => 'Welcome', 'audience' => 'Families', 'channel' => 'Email', 'sentOn' => '27 May 2025 10:30 AM', 'status' => 'Sent', 'status_class' => 'bg-emerald-100 text-emerald-800', 'performance' => 'Open 42.7%', 'openRate' => '42.7%'],
            ['id' => 'MSG-2025-05269', 'subject' => 'New Matching Available', 'type' => 'Alert', 'audience' => 'Families', 'channel' => 'Email', 'sentOn' => '27 May 2025 09:15 AM', 'status' => 'Sent', 'status_class' => 'bg-emerald-100 text-emerald-800', 'performance' => 'Open 41.3%', 'openRate' => '41.3%'],
            ['id' => 'MSG-2025-05268', 'subject' => 'Provider Spotlight', 'type' => 'Newsletter', 'audience' => 'All Users', 'channel' => 'Email', 'sentOn' => '26 May 2025 04:20 PM', 'status' => 'Sent', 'status_class' => 'bg-emerald-100 text-emerald-800', 'performance' => 'Open 39.3%', 'openRate' => '39.3%'],
            ['id' => 'MSG-2025-05267', 'subject' => 'Payment Receipt', 'type' => 'Transactional', 'audience' => 'Customers', 'channel' => 'Email', 'sentOn' => '26 May 2025 02:10 PM', 'status' => 'Sent', 'status_class' => 'bg-emerald-100 text-emerald-800', 'performance' => 'Open 86.6%', 'openRate' => '86.6%'],
            ['id' => 'MSG-2025-05266', 'subject' => 'Upcoming Webinar', 'type' => 'Campaign', 'audience' => 'Parents', 'channel' => 'Email', 'sentOn' => '25 May 2025 11:10 AM', 'status' => 'Sent', 'status_class' => 'bg-emerald-100 text-emerald-800', 'performance' => 'Open 45.9%', 'openRate' => '45.9%'],
            ['id' => 'MSG-2025-05265', 'subject' => 'System Maintenance Notice', 'type' => 'System', 'audience' => 'All Users', 'channel' => 'Email', 'sentOn' => '25 May 2025 06:30 PM', 'status' => 'Delivered', 'status_class' => 'bg-sky-100 text-sky-800', 'performance' => 'Open 98.7%', 'openRate' => '98.7%'],
            ['id' => 'MSG-2025-05264', 'subject' => 'Account Security Check', 'type' => 'Security', 'audience' => 'All Users', 'channel' => 'Email', 'sentOn' => '24 May 2025 02:30 PM', 'status' => 'Sent', 'status_class' => 'bg-emerald-100 text-emerald-800', 'performance' => 'Open 41.1%', 'openRate' => '41.1%'],
            ['id' => 'MSG-2025-05263', 'subject' => 'Feedback Request', 'type' => 'Survey', 'audience' => 'All Users', 'channel' => 'Email', 'sentOn' => '23 May 2025 03:45 PM', 'status' => 'Draft', 'status_class' => 'bg-amber-100 text-amber-800', 'performance' => 'Open 0%', 'openRate' => '0%'],
        ]);

        return view('admin.communications', compact('stats', 'communications'));
    }

    /**
     * Analytics and Reports page.
     */
    public function analytics(): View
    {
        $analytics = [
            'total_volume' => '14,820 Matches',
            'accuracy' => '98.2%',
            'avg_matching_time' => '1.4 hours',
            'retention_rate' => '94.5%',
            'sectors' => [
                ['name' => 'Pediatrics & Family Care', 'percentage' => 38, 'color' => 'bg-emerald-500'],
                ['name' => 'Behavioral & Mental Health', 'percentage' => 26, 'color' => 'bg-blue-500'],
                ['name' => 'Geriatric & Elderly Care', 'percentage' => 20, 'color' => 'bg-amber-500'],
                ['name' => 'Corporate & Institutional Wellness', 'percentage' => 16, 'color' => 'bg-purple-500'],
            ],
        ];

        return view('admin.analytics', compact('analytics'));
    }

    /**
     * Platform Settings page.
     */
    public function settings(): View
    {
        return view('admin.settings');
    }
}

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

<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Services\Dashboard\AdminDashboardService;
use App\Services\Dashboard\MemberDashboardService;
use App\Services\Dashboard\SuperAdminDashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $filter = $request->input('date_filter', 'this_month');

        return match ($user->role) {

            UserRole::SUPER_ADMIN => view(
                'dashboard.super-admin',
                app(SuperAdminDashboardService::class)->handleDashboard($filter)
            ),

            UserRole::ADMIN => view(
                'dashboard.admin',
                app(AdminDashboardService::class)->handleDashboard($user, $filter)
            ),

            UserRole::MEMBER => view(
                'dashboard.member',
                app(MemberDashboardService::class)->handleDashboard($user, $filter)
            ),
        };
    }
}

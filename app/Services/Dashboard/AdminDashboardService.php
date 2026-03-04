<?php

namespace App\Services\Dashboard;

use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminDashboardService
{
    public function handleDashboard($user, $filter)
    {
        $companyId = $user->company_id;

        $shortUrls = ShortUrl::with('user')
            ->where('company_id', $companyId)
            ->latest()
            ->paginate(config('app.pagination_limit'), ['*'], 'urls_page');

        $adminMembers = User::where('company_id', $companyId)
            ->where('id', '!=', $user->id)
            ->withCount('shortUrls')
            ->withSum('shortUrls as total_hits', 'hits')
            ->latest()
            ->paginate(config('app.pagination_limit'), ['*'], 'admin_members_page');

        return [
            'adminMembers' => $adminMembers,
            'shortUrls' => $shortUrls,
            'filter' => $filter,
        ];
    }
}

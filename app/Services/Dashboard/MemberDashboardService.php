<?php

namespace App\Services\Dashboard;

use App\Models\ShortUrl;

class MemberDashboardService
{
    public function handleDashboard($user, $filter)
    {

        $shortUrls = ShortUrl::with('user')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(config('app.pagination_limit'));

        return [
            'shortUrls' => $shortUrls,
            'filter' => $filter,
        ];
    }
}

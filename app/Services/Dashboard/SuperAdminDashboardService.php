<?php

namespace App\Services\Dashboard;

use App\Models\Company;
use App\Models\ShortUrl;

class SuperAdminDashboardService
{
    public function handleDashboard($filter): array
    {
        $companies  = Company::withCount('users')
            ->withCount('shortUrls')
            ->withSum('shortUrls as total_hits', 'hits')
            ->latest()
            ->paginate(config('app.pagination_limit'), ['*'], 'companies_page');

        $shortUrls = ShortUrl::with(['user', 'company'])
            ->latest()
            ->paginate(config('app.pagination_limit'), ['*'], 'urls_page');;

        return [
            'companies' => $companies,
            'shortUrls' => $shortUrls,
            'filter' => $filter,
        ];
    }
}

@extends('layouts.app')

@section('content')
    <style>
        span.relative.z-0.inline-flex {
            display: none !important;
        }
    </style>

    <table width="100%" cellpadding="5">
        <tr>
            <td>
                <strong>Generated Short URLs</strong> &nbsp; &nbsp;
                <a href="{{ route('urls.generate') }}">
                    <button type="button">Generate</button>
                </a>
            </td>

            <td align="right">
                <select name="date_filter">
                    <option value="today">Today</option>
                    <option value="last_week">Last Week</option>
                    <option value="this_month" selected>This Month</option>
                    <option value="last_month">Last Month</option>
                </select>

                <a href="#">
                    <button type="button">Download</button>
                </a>
            </td>
        </tr>
    </table>

    <table border="1" width="100%" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Short URL</th>
                <th>Long URL</th>
                <th>Hits</th>
                <th>Created On</th>
            </tr>
        </thead>

        <tbody>
            @forelse($shortUrls as $url)
                <tr>
                    <td>
                        <a href="{{ url($url->short_code) }}" target="_blank">
                            {{ config('app.url') }}/{{ $url->short_code }}
                        </a>
                    </td>
                    <td>
                        <span title="{{ $url->url }}">
                            {{ Str::limit($url->url, 50) }}
                        </span>
                    </td>
                    <td>{{ $url->hits }}</td>

                    <td>{{ $url->created_at->format('M d, Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" align="center">No URLs found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <br>
    {{ $shortUrls->links() }}
@endsection

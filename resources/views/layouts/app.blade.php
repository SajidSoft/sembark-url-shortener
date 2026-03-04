<!DOCTYPE html>
<html>

<head>
    <title>{{ $title ?? 'Dashboard' }}</title>
</head>

<body>

    @auth
        <table width="100%" cellpadding="10">
            <tr>
                <td>
                    <strong>
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </strong>
                </td>

                <td>
                    <strong>
                        @if (session('success'))
                            <span style="color:green;">
                                {{ session('success') }}
                            </span>
                        @endif

                        @if (session('error'))
                            <span style="color:red;">
                                {{ session('error') }}
                            </span>
                        @endif

                        @if ($errors->any())
                            <div style="color: red;">
                                {{ $errors->first() }}
                            </div>
                            <br>
                        @endif
                    </strong>
                </td>

                <td align="right">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </td>
            </tr>

            @auth
                <tr>
                    <td>
                        <p>Welcome, <strong>{{ Auth::user()->name }}</strong></p>
                        Role: <span>{{ Auth::user()->role }}</span>
                    </td>
                </tr>
            @endauth
            <tr>
                <td>

                </td>
            </tr>
        </table>

        <hr>
    @endauth

    <div>
        @yield('content')
    </div>

</body>

</html>

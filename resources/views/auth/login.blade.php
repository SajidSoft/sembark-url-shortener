<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>

    <div style="height:100vh; display:flex; align-items:center; justify-content:center;">
        <div>

            <h3>Sembark URL Shortner</h3>

            @if ($errors->any())
                <div>{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="/login">
                @csrf

                <div>
                    <label>Email</label><br>
                    <input type="email" name="email" required>
                </div>

                <br>

                <div>
                    <label>Password</label><br>
                    <input type="password" name="password" required>
                </div>

                <br>

                <button type="submit">Login</button>
            </form>

        </div>
    </div>

</body>

</html>

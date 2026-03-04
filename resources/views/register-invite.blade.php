@extends('layouts.app')

@section('content')
    <h3>Registration</h3>

    <hr>

    <form method="POST" action="{{ route('process.invite', $token) }}">
        @csrf

        <div>
            <label>Email</label><br>
            <input type="email" value="{{ $invitation->email }}" disabled>
        </div>
        <br>

        <div>
            <label>Your Name</label><br>
            <input type="text" name="name" required>
        </div>
        <br>

        <div>
            <label>Password</label><br>
            <input type="password" name="password" required>
        </div>
        <br>
        <div>
            <label>Confirm Password</label><br>
            <input type="password" name="password_confirmation" required>
        </div>
        <br>
        <button type="submit">Complete Registration</button>
    </form>
@endsection

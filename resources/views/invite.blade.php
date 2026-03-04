@extends('layouts.app')

@section('content')
    <h3>New Invitation</h3>
    <hr>
    <form method="POST" action="{{ route('invite') }}">
        @csrf

        <div>
            <label>Name</label><br>
            <input type="text" name="name" required>
        </div>

        <br>

        <div>
            <label>Email</label><br>
            <input type="email" name="email" required>
        </div>

        <br>

        @if (Auth::user()->role == \App\Enums\UserRole::ADMIN)
            <div>
                <label>Role</label><br>
                <select name="role" required>
                    <option value="admin">Admin</option>
                    <option value="member">Member</option>
                </select>
            </div>

            <br>
        @endif

        <button type="submit">Send Invitation</button>
    </form>
@endsection

@extends('layouts.app')

@section('content')
    <h3>Generate Short URL</h3>

    <form action="{{ route('urls.generate') }}" method="POST">
        @csrf
        <div>
            <label>Long URL: </label> <br>
            <input type="url" name="long_url" required placeholder="Enter Long url here...">
        </div>

        <br>
        <button type="submit"> Generate </button>
    </form>
@endsection

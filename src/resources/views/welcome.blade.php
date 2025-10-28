<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <h1>Register</h1>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div>
            <label>Username</label>
            <input name="username" value="{{ old('username') }}" required>
        </div>
        <div>
            <label>Phonenumber</label>
            <input name="phonenumber" value="{{ old('phonenumber') }}" required>
        </div>
        <button type="submit">Register</button>
    </form>

    @if($errors->any())
        <div class="alert alert-error">{{ implode(', ', $errors->all()) }}</div>
    @endif
</div>
</body>
</html>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Link Page</title>
    <link rel="stylesheet" href="{{ asset('css/link.css') }}">
</head>
<body data-token="{{ $link->token }}" data-csrf="{{ csrf_token() }}">
<h1>Link Page</h1>

@if($invalid)
    <p class="error">This link is invalid or expired.</p>
@endif

<p><strong>Link token:</strong> {{ $link->token }}</p>
<p><strong>Expires at:</strong> {{ $link->expires_at }}</p>

<div style="text-align:center; margin-top:15px;">
    <form method="POST" action="{{ route('link.regen', ['token' => $link->token]) }}">
        @csrf
        <button type="submit">Generate new link</button>
    </form>

    <form method="POST" action="{{ route('link.deactivate', ['token' => $link->token]) }}">
        @csrf
        <button type="submit" style="background-color:#dc3545;">Deactivate</button>
    </form>
</div>

<div class="btn-group">
    <button id="luckyBtn">I'm feeling lucky</button>
    <button id="historyBtn" style="background-color:#6c757d;">History</button>
</div>

<div id="result"></div>
<div id="history"></div>

<script src="{{ asset('js/link.js') }}"></script>
</body>
</html>

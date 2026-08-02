<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>99 Bottles</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css" />
    <script defer="defer" src="{{ asset('js/script.js') }}" type="text/javascript"></script>
    @stack('scripts')
</head>
<body>
<div id="header">
    <h1>99 Bottles</h1>
    <ul id="header-navigation">
        <li><a href="{{ route('home') }}">Main (sing)</a></li>
        <li><a href="{{ route('filled-bottles.index') }}">Filled Bottles</a></li>
        <li><a href="{{ route('bottles.index') }}">Bottles</a></li>
        <li><a href="{{ route('beverages.index') }}">Beverages</a></li>
    </ul>
</div>
<div id="search-form-block">@include('partials.search-form')</div>
@if (session('flashmessage'))
    <div class="flashmessage">{{ session('flashmessage') }}</div>
@endif
@yield('content')
<div id="footer">especially for bankir.ru</div>
</body>
</html>

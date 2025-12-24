<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Edufa')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('logo-header.png') }}">

    <style>
        :root {
            --primary:#800000;
            --bg:#f7f7f7;
            --card:#ffffff;
            --text:#333;
        }
        * { box-sizing:border-box;margin:0;padding:0 }
        body {
            font-family: Inter, Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
        }
    </style>
</head>
<body>

{{-- @include('layouts.frontend.header') --}}

@yield('content')

@include('layouts.frontend.footer')

</body>
</html>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script>
        window.userID = "{{ auth()->id() }}" || null;
    </script>
    @vite(['resources/sass/app.scss', 'resources/vue/main.ts'])
</head>
<body>
    <div id="app"></div>
</body>
</html>

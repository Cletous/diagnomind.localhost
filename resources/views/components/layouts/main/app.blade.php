<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>DiagnoMind</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/icons/bootstrap-icons/bootstrap-icons.min.css') }}" rel="stylesheet">
    @livewireStyles
</head>

<body>
    @includeIf('components.layouts.main.header')

    <main class="container py-4">
        {{ $slot }}
    </main>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    @livewireScripts
</body>

</html>

<!-- resources/views/components/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>DiagnoMind</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    @livewireStyles
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">DiagnoMind</a>
        </div>
    </nav>

    <main class="container py-4">
        {{ $slot }}
    </main>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    @livewireScripts
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ !empty($title) ? $title . ' - ' . config('app.name') : config('app.name') }} &reg;
    </title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/icons/bootstrap-icons/bootstrap-icons.min.css') }}" rel="stylesheet">
    @livewireStyles
</head>

<body>
    @includeIf('components.toasts._messages')

    @includeIf('components.layouts.main.header')

    <main class="container py-4">
        @yield('content')
    </main>
</body>

</html>

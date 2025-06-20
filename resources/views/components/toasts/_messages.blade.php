@if (!empty(session('success')))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'center',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            showCloseButton: true,
            timer: 4000,
            timerProgressBar: true,
        });
        Toast.fire({
            icon: 'success',
            title: @json(session('success')),
        });
    </script>
@endif

@if (!empty(session('error')))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'center',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            showCloseButton: true,
            timer: 4000,
            timerProgressBar: true,
        });
        Toast.fire({
            icon: 'error',
            title: @json(session('error')),
        });
    </script>
@endif


@if (!empty(session('alert')))
    <script>
        alert("{{ session('alert') }}")
    </script>
@endif

@if (!empty(session('warning')))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'center',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            showCloseButton: true,
            timer: 4000,
            timerProgressBar: true,
        });
        Toast.fire({
            icon: 'warning',
            title: @json(session('warning')),
        });
    </script>
@endif

@if (!empty(session('info')))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'center',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            showCloseButton: true,
            timer: 4000,
            timerProgressBar: true,
        });
        Toast.fire({
            icon: 'info',
            title: @json(session('info')),
        });
    </script>
@endif

@if (!empty(session('secondary')))
    <div class="alert alert-secondary" role="alert">
        {{ session('secondary') }}
    </div>
@endif

@if (!empty(session('primary')))
    <div class="alert alert-primary" role="alert">
        {{ session('primary') }}
    </div>
@endif

@if (!empty(session('light')))
    <div class="alert alert-light" role="alert">
        {{ session('light') }}
    </div>
@endif

{{-- @if ($errors->any())
    <h5 class="text-danger">The following errors were encountered:</h5>
    <ul class="list-group list-group-numbered">
        @foreach ($errors->all() as $error)
        <li class="text-danger"><i class="fas fa-angle-right"></i> {{ $error }}</li>
        @endforeach
    </ul>
@endif --}}

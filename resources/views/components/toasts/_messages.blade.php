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
        })
        Toast.fire({
            icon: 'success',
            title: "{{ session('success') }}",
        })
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
        })
        Toast.fire({
            icon: 'error',
            title: "{{ session('error') }}",
        })
    </script>
@endif

@if (!empty(session('alert')))
    <script>
        alert("{{ session('alert') }}")
    </script>
@endif

@if (!empty(session('warning')))
    <div class="position-relative">
        <div style="z-index:9991; top:150px"
            class="toast align-items-center fade show position-absolute start-50 translate-middle bg-warning shadow"
            role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body text-white">{{ session('warning') }}</div>
                <button type="button" class="btn-close me-2 m-auto btn-close-white" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif

@if (!empty(session('info')))
    <div class="position-relative">
        <div style="z-index:9991; top:150px"
            class="toast align-items-center fade show position-absolute start-50 translate-middle bg-info shadow"
            role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body text-white">{{ session('info') }}</div>
                <button type="button" class="btn-close me-2 m-auto btn-close-white" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
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

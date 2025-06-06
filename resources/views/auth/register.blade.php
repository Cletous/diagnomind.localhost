@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>Register</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3"><label>First Name</label><input type="text" name="first_name" class="form-control" required>
            </div>
            <div class="mb-3"><label>Last Name</label><input type="text" name="last_name" class="form-control" required>
            </div>
            <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3"><label>National ID</label><input type="text" name="national_id_number"
                    class="form-control" required></div>
            <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3"><label>Confirm Password</label><input type="password" name="password_confirmation"
                    class="form-control" required></div>
            <div class="mb-3">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="patient">Patient</option>
                    <option value="doctor">Doctor</option>
                </select>
            </div>
            <button class="btn btn-success">Register</button>
        </form>
    </div>
@endsection

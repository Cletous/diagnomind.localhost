@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Verify Your Email</h3>
        <p>A verification link has been sent to {{ auth()->user()->email }}.</p>
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button class="btn btn-primary mt-2">Resend Verification Email</button>
        </form>
    </div>
@endsection

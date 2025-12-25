@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="card" style="max-width: 400px; margin: 4rem auto;">
    <h2 style="margin-bottom: 2rem; text-align: center;">Login</h2>
    
    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="remember"> Remember me
            </label>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
        </div>

        <div style="text-align: center; margin-top: 1rem;">
            <a href="{{ route('register') }}">Don't have an account? Register here</a>
        </div>
    </form>
</div>
@endsection


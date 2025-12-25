@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="card" style="max-width: 500px; margin: 4rem auto;">
    <h2 style="margin-bottom: 2rem; text-align: center;">Register</h2>
    
    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="role">Register as</label>
            <select id="role" name="role" class="form-control" required>
                <option value="user">User</option>
                <option value="vendor">Vendor</option>
            </select>
        </div>

        <div class="form-group" id="store-name-group" style="display: none;">
            <label for="store_name">Store Name</label>
            <input type="text" id="store_name" name="store_name" class="form-control" value="{{ old('store_name') }}">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary" style="width: 100%;">Register</button>
        </div>

        <div style="text-align: center; margin-top: 1rem;">
            <a href="{{ route('login') }}">Already have an account? Login here</a>
        </div>
    </form>
</div>

<script>
    document.getElementById('role').addEventListener('change', function() {
        const storeNameGroup = document.getElementById('store-name-group');
        if (this.value === 'vendor') {
            storeNameGroup.style.display = 'block';
            document.getElementById('store_name').required = true;
        } else {
            storeNameGroup.style.display = 'none';
            document.getElementById('store_name').required = false;
        }
    });
</script>
@endsection


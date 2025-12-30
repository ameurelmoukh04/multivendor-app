<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        // dd('the user role is normal user');
        return match($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'vendor' => redirect()->route('vendor.dashboard'),
            'user' => redirect()->route('user.products.index'),
            default => redirect()->route('login'),
        };
    }
}

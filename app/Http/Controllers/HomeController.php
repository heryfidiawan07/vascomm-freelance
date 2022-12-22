<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // dd(auth()->user()->hasRole('Customer'));
        if(! auth()->user()->status) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $request->session()->flash('status', 'Akun menunggu approve dari admin !');
            return redirect('login');
        }
        if(auth()->user()->hasRole('Customer')) {
            return view('customer.profile');
        }
        return view('home');
    }

    public function profile()
    {
        return view('customer.profile');
    }
}

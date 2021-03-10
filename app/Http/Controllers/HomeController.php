<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::guard('web')->user()->status_user == 'nonAktif'){
            return view('auth.login')->with('msg', 'Mohon Maaf akun anda belum diverifikasi! harap sabar!');
        }
        return view('home');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('auth:petugas');
    }
    public function index(){
        if(Auth::guard('petugas')->user()->level == 'admin'){
            return view('admin');
        }
        return view('dashboard');
    }
}

<?php

namespace App\Http\Controllers;
use Auth;

class RouteController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function test()
    {
        return view('test');
    }

    public function admin()
    {
        return view('admin');
    }
}

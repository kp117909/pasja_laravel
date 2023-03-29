<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function calendar(){
        return view('calendar');
    }

    public function index(){
        return view('index');
    }

    public function login(){
        return view('login');
    }
}

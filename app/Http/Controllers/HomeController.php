<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Events;
use App\Models\User;
use App\Models\Workers;
use App\Models\Services;
use App\Models\ServicesEvents;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function calendar(){
        return view('calendar');
    }

    public function index(){
        return view('index');
    }

    public function info(){
        return view('info');
    }
//
//    public function profile(){
//
//        $id = Auth::id();
//
//        $services_events = Services::leftJoin('services_events', function($join) {$join->on('id', '=', 'id_service');})->where('id_client', '=', $id)->get();
////         return response()->json($services_events);
//
//        return view('profile', [
//        'events' => Events::where('client_id', $id)->get(),
//            'services_events' => $services_events,
//        ]);
//    }


    public function login(){
        return view('login');
    }
}

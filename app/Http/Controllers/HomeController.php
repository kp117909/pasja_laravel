<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Events;
use App\Models\User;
use App\Models\Workers;
use App\Models\Services;
use App\Models\ServicesEvents;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function calendar(){
        return view('calendar');
    }

    public function index(){
        $events = Events::where('client_id', auth()->user()->id)->get();
        if ($events->isEmpty()) {
            $closestEvent = null;
        } else {
            $currentTime = now();
            $closestEvent = $events->where('start', '>', $currentTime)->sortBy('start')->first();
            if($closestEvent){
                $closestEvent->start = \Carbon\Carbon::parse($closestEvent->start);
            }
        }

        $eventsWorker = Events::where('worker_id', auth()->user()->id)->get();
        if ($eventsWorker->isEmpty()) {
            $closestEventWorker = null;
        } else {
            $currentTime = now();
            $closestEventWorker = $eventsWorker->where('start', '>', $currentTime)->sortBy('start')->first();
            if($closestEventWorker){
                $closestEventWorker->start = \Carbon\Carbon::parse($closestEventWorker->start);
                $closestEventWorker->icon_photo = User::getIconPhoto($closestEventWorker->client_id);
            }
        }

        return view('index', [
            'event' => $closestEvent,
            'eventWorker' => $closestEventWorker
        ]);
    }

    public function info() {

        $totalClients = Events::where('end', '<', now())->count();
        $totalEarnings = Events::where('end', '<', now())->sum('overal_price');

        $currentMonth = now()->format('Y-m');
        $currentMonthClients = Events::where(DB::raw("DATE_FORMAT(start, '%Y-%m')"), '=', $currentMonth)
            ->where('end', '<', now())
            ->count();

        $currentMonthEarnings = Events::where(DB::raw("DATE_FORMAT(start, '%Y-%m')"), '=', $currentMonth)
            ->where('end', '<', now())
            ->sum('overal_price');


        $allServicesWithStart = ServicesEvents::join('events', 'services_events.id_event', '=', 'events.id')
            ->select('services_events.*', 'events.start')
            ->where('events.start', '<', now())
            ->get();


        $currentServicesWithStart = ServicesEvents::join('events', 'services_events.id_event', '=', 'events.id')
            ->select('services_events.*', 'events.start')
            ->where(DB::raw("DATE_FORMAT(start, '%Y-%m')"), '=', $currentMonth)
            ->get();

        $totalServices = $allServicesWithStart->count();

        $currentServices = $currentServicesWithStart->count();

        $workers = Workers::all();

        return view('info', compact('totalClients', 'totalEarnings', 'totalServices', 'currentMonthClients', 'currentMonthEarnings', 'currentServices', 'workers'));
    }
    public function workerAnalytics(Request $request){

        $workerId = $request->id;

        $totalClients = Events::where('end', '<', now())->where('worker_id','=',$workerId)->count();

        $totalEarnings = Events::where('end', '<', now())->where('worker_id','=',$workerId)->sum('overal_price');

        $currentMonth = now()->format('Y-m');
        $currentMonthClients = Events::where(DB::raw("DATE_FORMAT(start, '%Y-%m')"), '=', $currentMonth)
            ->where('end', '<', now())
            ->where('worker_id','=',$workerId)
            ->count();

        $currentMonthEarnings = Events::where(DB::raw("DATE_FORMAT(start, '%Y-%m')"), '=', $currentMonth)
            ->where('end', '<', now())
            ->where('worker_id','=',$workerId)
            ->sum('overal_price');


        $allServicesWithStart = ServicesEvents::join('events', 'services_events.id_event', '=', 'events.id')
            ->select('services_events.*', 'events.start')
            ->where('events.start', '<', now())
            ->where('worker_id','=',$workerId)
            ->get();


        $currentServicesWithStart = ServicesEvents::join('events', 'services_events.id_event', '=', 'events.id')
            ->select('services_events.*', 'events.start')
            ->where(DB::raw("DATE_FORMAT(start, '%Y-%m')"), '=', $currentMonth)
            ->where('worker_id','=',$workerId)
            ->get();

        $totalServices = $allServicesWithStart->count();

        $currentServices = $currentServicesWithStart->count();

        $workers = Workers::all();

        $currentWorker = Workers::findOrFail($workerId);

        return view('info', compact('totalClients', 'totalEarnings', 'totalServices', 'currentMonthClients', 'currentMonthEarnings', 'currentServices', 'workers', 'currentWorker'));
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

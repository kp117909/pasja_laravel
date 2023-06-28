<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Events;
use App\Models\User;
use App\Models\Workers;
use App\Models\Services;
use App\Models\ServicesEvents;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class CalendarController extends Controller
{
    public function index(Request $request)
    {

        return view('calendar/index',
         [
         'visit_sorting' => session('values'),
         'events_all' =>Events::all(),
         'clients' => User::all(),
         'workers' => Workers::all(),
         'services' => Services::all(),
         'services_events' => ServicesEvents::all(),
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {

        $record_client = User::findOrFail($request->client);
        $record_worker = Workers::findOrFail($request->worker);
        $services_temp = implode(',', array_column($request->services, 'id'));
        $services_array = explode(',', $services_temp);


        $dateStartValue = $request->date_start;
        $dateStartDay = Carbon::parse($dateStartValue);
        $dayOfWeek = (int)$dateStartDay->isoFormat('E');
        $accessibility = $record_worker->accessibility;

        $workerId = $request->worker;
        $dateStart = $request->date_start;
        $dateEnd = $request->date_end;

        $existingEvents = Events::where('worker_id', $workerId)
            ->where(function ($query) use ($dateStart, $dateEnd) {
                $query->whereBetween('start', [$dateStart, $dateEnd])
                    ->orWhereBetween('end', [$dateStart, $dateEnd])
                    ->orWhere(function ($query) use ($dateStart, $dateEnd) {
                        $query->where('start', '<=', $dateStart)
                            ->where('end', '>=', $dateEnd);
                    });
            })
            ->get();

        if ($existingEvents->isNotEmpty()) {
            return response()->json(['accessibility' => $accessibility, 'type' => 'error_other']);
        }


        if (isset($accessibility[$dayOfWeek])) {
            $start_time = Carbon::parse($accessibility[$dayOfWeek]['start_time'])->format('H:i');
            $end_time = Carbon::parse($accessibility[$dayOfWeek]['end_time'])->format('H:i');

            $timeStart = Carbon::parse($request->date_start)->format('H:i');
            $timeEnd = Carbon::parse($request->date_end)->format('H:i');

            if ($timeStart >= $start_time && $timeEnd <= $end_time) {
                $event = Events::create([
                    'title' => $record_client->last_name,
                    'name_c' => $record_client->first_name,
                    'surname_c' => $record_client->last_name,
                    'phone_c' => $record_client->phone,
                    'client_id' => $record_client->id,
                    'name_w' => $record_worker->first_name,
                    'surname_w' => $record_worker->last_name,
                    'worker_id' => $record_worker->id,
                    'worker_icon' => $record_worker->icon_photo,
                    'overal_price' => $request->overall_price,
                    'start' => $request->date_start,
                    'end' => $request->date_end,
                    'color' =>$record_worker->color,
                ]);

                foreach($services_array as $service){
                    ServicesEvents::create([
                        'id_service' => $service,
                        'id_event' => $event->id,
                        'id_client' => $record_client->id,
                        'id_worker' => $record_worker->id,
                    ]);
                }

                return response()->json(['event' => $event, 'type' => 'success']);
            } else {
                return response()->json(['accessibility' => $accessibility, 'type' => 'error']);
            }

        }
        return response()->json(['accessibility' => $accessibility, 'type' => 'error']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return JsonResponse
     */
    public function edit(Request $request)
    {
        $record_worker = Workers::findOrFail($request->w_id);

        $event = Events::where('id', $request->event_id)->update(
            [
                'name_w' => $record_worker->first_name,
                'surname_w' =>$record_worker->last_name,
                'worker_id' =>$record_worker->id,
                'worker_icon' =>$record_worker->icon_photo,
                'color' => $record_worker->color,
                'start' =>$request->start,
                'end'=>$request->end
            ]
            );

        return response()->json($event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $event = Events::where('id', $request->event_id)->update(
            [
                'start' =>$request->start,
                'end'=>$request->end
            ]
            );

        return response()->json($event);
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Database\Eloquent\Collection|JsonResponse
     */
    public function destroy(Request $request)
    {
        $event = Events::find($request->event_id);
        if(! $event){
            return response()->json([
                'error'=>  "Nie znaleziono wizity"
            ], 404);
        }
        $getEvents = Events::all();
        if($request->isAdmin){
           $event->delete();
        }else{
            $startDateTime = Carbon::parse($event->start);
            $currentDateTime = Carbon::now()->addHours(2);
            $remainingTime = $startDateTime->diffInMinutes($currentDateTime);

            if ($startDateTime->isPast()) {
                $remainingTime *= -1;
            }
            if ($remainingTime > 60) {
                $event->delete();
                return response()->json(['getEvents' => $getEvents, "type" => "success"]);
            } else {
                return response()->json(['getEvents' => $getEvents, "type" => "error"]);
            }
        }
        return response()->json(['getEvents' => $getEvents, "type" => "success"]);
    }

    public function getEvents()
    {
        $events = array();
            $bookings = Events::all();
            foreach($bookings as $booking){
            $services = Services::leftJoin('services_events', function($join) {$join->on('id', '=', 'id_service');})->where('id_event', '=', $booking->id)->get();
                $events[] = [
                    'id' => $booking->id,
                    'title' => $booking->title,
                    'client_id'=> $booking->client_id,
                    'name_c' => $booking->name_c,
                    'surname_c' => $booking->surname_c,
                    'name_w' => $booking->name_w,
                    'surname_w' => $booking->surname_w,
                    'overal_price' => $booking->overal_price,
                    'start' => $booking->start,
                    'end' => $booking->end,
                    'color' => $booking->color,
                    'worker_id' =>$booking->worker_id,
                    'worker_icon' =>$booking->worker_icon,
                    'events' => $services,
                ];
            }
        return response()->json($events);
    }

    //OLD FUNCTION TO FILTER WORKERS IN CALENDAR
//    public function status(Request $request){
//        $events = array();
//        $bookings = Events::all();
//        $services = array();
////        return response()->json($request->values);
//        foreach($bookings as $booking){
//            $services = Services::leftJoin('services_events', function($join) {$join->on('id', '=', 'id_service');})->where('id_event', '=', $booking->id)->get();
//            foreach($request->values as $value)
//            if($booking->worker_id == $value){
//                $events[] =[
//                    'id' => $booking->id,
//                    'title' => $booking->title,
//                    'name_c' => $booking->name_c,
//                    'surname_c' => $booking->surname_c,
//                    'name_w' => $booking->name_w,
//                    'surname_w' => $booking->surname_w,
//                    'overal_price' => $booking -> overal_price,
//                    'start' => $booking->start,
//                    'end' => $booking-> end,
//                    'color' => $booking-> color,
//                    'events' =>$services,
//                ];
//            }
//        }
//
//        return view('calendar/index',
//            [
//                'events' => $events,
//                'current_status' =>$request->values,
//                'events_all' =>Events::all(),
//                'clients' => User::all(),
//                'workers' => Workers::all(),
//                'services' => Services::all(),
//                'services_events' => ServicesEvents::all(),
//            ]);
//    }
}

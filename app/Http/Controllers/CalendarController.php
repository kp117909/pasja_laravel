<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Events;
use App\Models\Clients;
use App\Models\Workers;
use App\Models\Services;
use App\Models\ServicesEvents;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $events = array();
        $bookings = Events::all();
        $services = array();
        foreach($bookings as $booking){
            $services = Services::leftJoin('services_events', function($join) {$join->on('id', '=', 'id_service');})->where('id_event', '=', $booking->id)->get();
            $events[] =[
                'id' => $booking->id,
                'title' => $booking->title,
                'name_c' => $booking->name_c,
                'surname_c' => $booking->surname_c,
                'name_w' => $booking->name_w,
                'surname_w' => $booking->surname_w,
                'overal_price' => $booking -> overal_price,
                'start' => $booking->start,
                'end' => $booking-> end,
                'events' =>$services,
            ];
        }

        // return response()->json($services);

        return view('calendar/index',
         [
         'events' => $events,
         'events_all' =>Events::all(),
         'clients' => Clients::all(),
         'workers' => Workers::all(),
         'services' => Services::all(),
         'services_events' => ServicesEvents::all(),
        ]);
    
    }

    // public function calendar(){

    //     return view('calendar');
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $record_client = Clients::findOrFail($request->c_id);
        $record_worker = Workers::findOrFail($request->w_id);
        
        // $event = new Events();

        // $event->title = "Event X";
        // $event->name_c = "kamil";
        // $event->surname_c = 'polak';
        // $event->phone_c = "555-123-612";
        // $event->name_w = "Pan";
        // $event->surname_w = "Admin";
        // $event->overal_price = $request->price;
        // $event->start = $request->start;
        // $event->end = $request->end;

        // $event ->save();
        $services = $request->service_events;

        $event = Events::create([
            'title' => $record_client->last_name,
            'name_c' => $record_client->first_name,
            'surname_c' => $record_client->last_name,
            'phone_c' => $record_client->phone,
            'name_w' => $record_worker->first_name,
            'surname_w' => $record_worker->last_name,
            'overal_price' => $request->price,
            'start' => $request->start,
            'end' => $request->end,
        ]);



        foreach($services as $service){
            $event_services = ServicesEvents::create([
                'id_service' => $service['label_value'],
                'id_event' => $event->id,
                'id_client' => $record_client->id,
                'id_worker' => $record_worker->id,
            ]);
        }

        return response()->json($event);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $record_worker = Workers::findOrFail($request->w_id);

        $event = Events::where('id', $request->event_id)->update(
            [
                'name_w' => $record_worker->first_name,
                'surname_w' =>$record_worker->last_name,
                'start' =>$request->start,
                'end'=>$request->end
            ]
            );

        return response()->json($event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $events = Events::find($request->event_id);
        if(! $events){
            return response()->json([
                'error'=>  "Nie znaleziono wizity"
            ], 404);
        }
            $events->delete();
            return $events;
    }
}

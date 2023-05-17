<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;
use App\Models\Services;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        Services::create([
            'service_name' => $request['service_name'],
            'price' => $request['price'],
            'time' => $request['time'],
            'img' => $request['select_icon_service']
            ]);

        return Redirect('client.profile');
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $service = Services::findOrFail($request->id_service);

        $service->service_name = $request->service_name;
        $service->price = $request->price;
        $service->time = $request->time;

        $service-> save();
        return Redirect('client.profile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $services = Services::find($request->id);
        if(! $services){
            return response()->json([
                'error'=>  "Nie znaleziono usługi"
            ], 404);
        }
        $services->delete();
        return $services;
    }
}

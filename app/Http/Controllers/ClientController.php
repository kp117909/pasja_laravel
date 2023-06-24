<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Services;
use App\Models\Events;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ClientController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $client = User::findOrFail($request->id_client);
//        $role = Role::create(['name' => 'employee']);
//
//        $permission_admins = Permission::create(['name' => 'add Admins']);
//        $permission_employees = Permission::create(['name' => 'add Employees']);
//
//        $role->givePermissionTo($permission_admins);
//
//
//        $role->givePermissionTo($permission_employees);

//        $client->assignRole('admin');

        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->phone = $request->phone;
        $client->adress = $request->adress;
        $client->postcode = $request->postcode;

        if($request->hasFile('icon_photo')){
            $file = $request->file('icon_photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('png/', $filename);
            $client->icon_photo  = $filename;
        }
        $client-> save();
        return Redirect('client.profile');
    }

    public function profile(Request $request){

        $id = Auth::id();

        $services_events = Services::leftJoin('services_events', function($join) {$join->on('id', '=', 'id_service');})->where('id_client', '=', $id)->get();

        return view('profile', [
        'events' => Events::where('client_id', $id)->get(),
            'services_events' => $services_events,
            'services'=>Services::all(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

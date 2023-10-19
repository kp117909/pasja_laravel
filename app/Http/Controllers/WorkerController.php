<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Events;
use App\Models\Services;
use App\Models\ServicesEvents;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Workers;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\ServerBag;

class WorkerController extends Controller
{
    public function saveAvailability(Request $request): \Illuminate\Http\JsonResponse
    {
        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');
        $day = $request->input('day');

        $employee = Workers::find(Auth::user()->id);

        if (is_null($employee->accessibility)) {
            $employee->accessibility = [
                '1' => ['start_time' => '8:00', 'end_time' => '21:00'],
                '2' => ['start_time' => '8:00', 'end_time' => '21:00'],
                '3' => ['start_time' => '8:00', 'end_time' => '21:00'],
                '4' => ['start_time' => '8:00', 'end_time' => '21:00'],
                '5' => ['start_time' => '8:00', 'end_time' => '21:00'],
                '6' => ['start_time' => '8:00', 'end_time' => '21:00'],
                '7' => ['start_time' => '8:00', 'end_time' => '21:00'],
            ];
        }

        $accessibility = $employee->accessibility;
        $accessibility[$day] = ['start_time' => $startTime, 'end_time' => $endTime];
        $employee->accessibility = $accessibility;
        $employee->save();

        return response()->json(['message' => 'Godziny dyspozycyjności zostały zapisane.'], 200);
     }

    public function update(Request $request)
    {
        $worker = Workers::findOrFail($request->id_client);


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

        $worker->first_name = $request->first_name;
        $worker->last_name = $request->last_name;
        $worker->phone = $request->phone;
        $worker->color = $request->color;

        $filename = null;
        if($request->hasFile('icon_photo')){
            $file = $request->file('icon_photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('png/', $filename);
            $worker->icon_photo  = $filename;
        }
        $worker-> save();

        $filteredEvents = Events::where('worker_id', $request->id_client)->get();

        foreach ($filteredEvents as $event) {
            $event->name_w = $worker->first_name;
            $event->surname_w = $worker->last_name;
            $event->worker_icon = $worker->icon_photo;
            $event->color = $worker->color;
            $event->save();
        }

        return Redirect('worker.profile');
    }

    public function profile(Request $request){

        return view('profile_worker', [
            'services'=>Services::all(),
        ]);
    }

    public function getWorkerList(Request $request){
        $workers = User::getAdminsAndEmployees();
;
        return view('profile_worker_list',[
            'workers' => $workers,
        ]);
    }

    public function getUsersList(Request $request){
        $users = User::all();

        return view('profile_worker_list',[
            'users' => $users
        ]);
    }


    public function updateUser(Request $request): \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {

        $user = User::findOrFail($request->user_id);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;

        $user->syncRoles([$request->permission_select]);

        $user->save();

        return Redirect('users.list');

    }

    public function cardProfile(Request $request){

        $worker = Workers::findOrFail($request->id);

        $workerEvents = Events::where('worker_id', $worker->id)->count();

        $workerServices = ServicesEvents::where('id_worker', $worker->id)->count();

        return view('user.profile.workercard', [
            'worker' => $worker,
            'eventsCount' => $workerEvents,
            'servicesCount' => $workerServices,
        ]);
    }
}

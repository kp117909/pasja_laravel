<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Notifications;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function notifyAdd(){
        $events = Events::all();

        foreach ($events as $event) {
            if ($event->end < now()) {
                $existingNotification = Notifications::where('event_id', $event->id)
                    ->where('client_id', $event->client_id)
                    ->first();

                if (!$existingNotification) {
                    $notification = new Notifications();
                    $notification->event_id = $event->id;
                    $notification->client_id = $event->client_id;
                    $notification->worker_id = $event->worker_id;
                    $notification->save();
                }
            }
        }

        return redirect()->back();

    }
}

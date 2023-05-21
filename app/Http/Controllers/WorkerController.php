<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Workers;
use Illuminate\Http\Request;

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



}

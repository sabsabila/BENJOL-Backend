<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Motorcycle;
use App\Models\Booking;
use DateTime;

class ProgressController extends Controller
{
    public function index($id){
        $data = [];
        $user = auth('api')->account()->user;
        $booking = Booking::where('booking_id', $id)->where('user_id', $user->user_id)->first();
        date_default_timezone_set("Asia/Jakarta");
        $current_time = new DateTime(date("H:i:s"));
        if($booking != null){
            $motorcycle = Motorcycle::where('motorcycle_id', $booking->motorcycle_id)->first();
            if($booking->start_time != null && $booking->end_time != null){
                $start_time = new DateTime($booking->start_time);
                $end_time = new DateTime($booking->end_time);
                $estimate = $current_time->diff($end_time);
                $minutesLeft = ($end_time->diff($current_time))->format('%H') *60 + ($end_time->diff($current_time))->format('%i');
                $totalTime = ($end_time->diff($start_time))->format('%H') *60 + ($end_time->diff($start_time))->format('%i');
                $progress = round((($totalTime - $minutesLeft) / $totalTime)*100);

                if($estimate->invert == 1){
                    $estimate->h = 0;
                    $estimate->i = 0;
                    $minutesLeft = 0;
                    $progress = 100;
                }

                $timeUntilService = $current_time->diff($start_time);
                if($timeUntilService->invert == 0){
                    $progress = 0;
                    $estimate->h = 0;
                    $estimate->i = 0;
                    $minutesLeft = 0;
                }
                
                $data =[
                    $booking->start_time,
                    $booking->end_time,
                    $percentage = strval($progress),
                    $hour = strval($estimate->h),
                    $minute = strval($estimate->i),
                    $plate_number = $motorcycle->plate_number
                ];
            }else{
                $data =[
                    $start = null,
                    $end = null,
                    $percentage = null,
                    $hour = null,
                    $minute = null,
                    $plate_number = $motorcycle->plate_number
                ];
            }
        }else{
            $data = null;
        }

        return response()->json(['progress' => $data]);
    }
}

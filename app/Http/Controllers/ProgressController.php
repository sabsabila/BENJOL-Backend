<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Motorcycle;
use DateTime;

class ProgressController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     
    public function index(){
        $data = [];
        $user = auth('api')->account()->user;
        $booking = $user->booking->sortByDesc('booking_id')->first();
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
                $progress = round(($minutesLeft / $totalTime)*100);

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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

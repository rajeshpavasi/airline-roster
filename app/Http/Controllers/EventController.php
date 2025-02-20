<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Roster;

class EventController extends Controller
{
    public function getEventsBetweenDates(Request $request)
    {
        
        $events = Roster::whereBetween('start_time', [$request->start, $request->end])->get();
        if($events){
            return response()->json(['Statuscode' =>200,'data'=>$events]);
        }else{
            return response()->json(['Statuscode' =>200,'messsage'=>'No data found']);
        }
    }

    public function getFlightsNextWeek()
    {
        $start = now()->setDate(2022, 1, 14);
        $end = $start->copy()->addWeek();
        $flights = Roster::where('type', 'FLT')->whereBetween('start_time', [$start, $end])->get();
        if($flights){
            return response()->json(['Statuscode' =>200,'data'=>$flights]);
        }else{
            return response()->json(['Statuscode' =>200,'messsage'=>'No data found']);
        }
    }

    public function getStandbyNextWeek()
    {
        $start = now()->setDate(2022, 1, 14);
        $end = $start->copy()->addWeek();
        $standby = Roaster::where('type', 'SBY')->whereBetween('start_time', [$start, $end])->get();
        if($standby){
            return response()->json(['Statuscode' =>200,'data'=>$standby]);
        }else{
            return response()->json(['Statuscode' =>200,'messsage'=>'No data found']);
        }
    }

    public function getFlightsFromLocation(Request $request)
    {
        $flights = Roster::where('type', 'FLT')->where('location', $request->location)->get();
        if($flights){
            return response()->json(['Statuscode' =>200,'data'=>$flights]);
        }else{
            return response()->json(['Statuscode' =>200,'messsage'=>'No data found']);
        }
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Controllers\Controller;
use App\Library\ApiResponse;
use App\Http\Resources\EventResource;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = Event::query();
        $nowDates = Carbon::today();
        // dd($nowDate);
        $nowDate = date('Y-m-d');
        if($request->name == 'finished'){
            $q->whereDate('endDate', '<', $nowDate);
        }
        if($request->name == 'upcomming'){
            $q->whereDate('endDate', '>', $nowDate);
        }
        if($request->name == 'upcomming_seven_days'){
            // dd($nowDate);
            $addSevenDays = $nowDates->add(7,'days');
            
            $q->whereBetween('endDate', [$nowDate, $addSevenDays]);
        }
        if($request->name == 'finished_seven_days'){
            $passedSevenDays = $nowDates->sub(7,'days');
           
            $q->whereDate('endDate', '<', $passedSevenDays);
        }

        $events = $q->orderBy('startDate')->get();
        $results = EventResource::collection($events);
        
        return ApiResponse::sendResponse(false,'success',['data' => $results, 'total' => 8, 'page' => 20],200);
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
     * @param  \App\Http\Requests\StoreEventRequest  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(StoreEventRequest $request)
    {
        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
        ]);
        return ApiResponse::sendResponse(false,'success',['results' => ''],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return ApiResponse::sendResponse(false,'success',['results' => $event->first()],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return ApiResponse::sendResponse(false,'success',['results' => $event->first()],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEventRequest  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        
        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
        ]);
        return ApiResponse::sendResponse(false,'success',['results' => ''],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();
    }
}

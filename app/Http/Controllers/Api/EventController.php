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
       
        $nowDate = date('Y-m-d');

        $q = $q->when($request->name=='finished', function($query) use($nowDate){
            $query->whereDate('endDate', '<', $nowDate); 
        });
        $q = $q->when($request->name=='upcomming', function($query) use($nowDate){
            $query->whereDate('startDate', '>', $nowDate); 
        });

        $q = $q->when($request->name=='upcomming_seven_days', function($query) use( $nowDates){
            $query->whereBetween('startDate', [$nowDates->copy()->addDays(1), $nowDates->addDays(7)]);
        });


        $q = $q->when($request->name=='finished_seven_days', function($query) use($nowDates){
            
            $query->whereBetween('endDate', [$nowDates->copy()->addDays(1), $nowDates->addDays(7)]);
        });

        $events = $q->orderBy('created_at', 'desc')->get();
        $results = EventResource::collection($events);
        
        return ApiResponse::sendResponse(false,'success',['data' => $results, 'total' => 8, 'page' => 20],200);
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
        return ApiResponse::sendResponse(false,'success',['results' => ''],200);
    }
}

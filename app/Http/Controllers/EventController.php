<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;

class EventController extends Controller
{



    ////

    public function index()
    {
        $all = $this->eventsToArray(Event::all());
        return response()->json([
            'status' => 200,
            'all' => $all,
        ]);
    }

    public function eventsToArray($events)
    {
        $eventArray = [];
        foreach ($events as $event) {
            $data = [
                "id" => $event->_id,
                "title" => $event->title,
                "start" => $event->start,
                "end" => $event->end,

            ];
            array_push($eventArray, $data);
        }
        return response()->json($eventArray);
    }


    public function store(Request $request)
    {
        Event::create([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,

        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Action est ajouté avec succées',
        ]);
    }

    public function update(Request $request, event $event)
    {
        /*   $event->update([
           'start'=> $request->start,
           'end'=> $request->end,
         ]); 
       */

        $event->update($request->all());
        return response()->json([
            'status' => 200,
            'message' => 'Action est modifié avec succées',
            'start' => $request->start,
            'end' => $request->end,

        ]);
    }


    public function destroy($id)
    {
        $event = Event::find($id);
        $event->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Action est supprimé avec succées',
        ]);
    }


    public function show(event $event)
    {


        return response()->json([
            'status' => 200,
            'event' => $event

        ]);
    }
}

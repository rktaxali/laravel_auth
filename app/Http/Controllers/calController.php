<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Redirect,Response;

class CalController extends Controller
{
	
	public function __construct()
    {
       // $this->middleware('auth');
    }
	

	public function test()
	{

		return view('testCalendar');

	}

	 public function index($user_id= null)
    {

		$events = [];

		$events[] = \Calendar::event(
			'Event One', //event title
			false, //full day event?
			'2020-02-11T0800', //start time (you can also use Carbon instead of DateTime)
			'2020-02-12T0800', //end time (you can also use Carbon instead of DateTime)
			0 //optionally, you can specify an event ID
		);

		$events[] = \Calendar::event(
			"Valentine's Day", //event title
			true, //full day event?
			new \DateTime('2020-02-14'), //start time (you can also use Carbon instead of DateTime)
			new \DateTime('2020-02-14'), //end time (you can also use Carbon instead of DateTime)
			'stringEventId' //optionally, you can specify an event ID
		);

		$eloquentEvent = EventModel::first(); //EventModel implements LaravelFullcalendar\Event

		$calendar = \Calendar::addEvents($events) //add an array with addEvents
			->addEvent($eloquentEvent, [ //set custom color fo this event
				'color' => '#800',
			])->setOptions([ //set fullcalendar options
				'firstDay' => 1
			])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
				'viewRender' => 'function() {alert("Callbacks!");}'
			]);

		return view('helloCalendar', compact('calendar'));
    }
    
   
    public function create(Request $request)
    {  
        $insertArr = [ 'title' => $request->title,
                       'start' => $request->start,
                       'end' => $request->end,
					   'user_id' => auth()->user->id,
                    ];

        $event = Event::insert($insertArr);   
        return Response::json($event);
    }
     
 
    public function update(Request $request)
    {   
        $where = array('id' => $request->id);
        $updateArr = ['title' => $request->title,'start' => $request->start, 'end' => $request->end];
        $event  = Event::where($where)->update($updateArr);
 
        return Response::json($event);
    } 
 
 
    public function destroy(Request $request)
    {
        $event = Event::where('id',$request->id)->delete();
   
        return Response::json($event);
    }
}

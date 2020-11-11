<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\Client;
use Redirect,Response;
use Illuminate\Support\Facades\DB;

class FullCalendarEventMasterController extends Controller
{
	
	public function __construct()
    {
        $this->middleware('auth');
    }
	
  

	/**
	 * Returns the logged-in user_id to the view fullcalendarDates.blade.php 
	 * The view will make an Ajax call to fetch the events for the logged in user 
	 * and render the calendar 
	 * NOTE: Initially tried to return the events data back to the view. 
	 *       However, the events data could not be returned in the object format 
	 *       that could be used by the javaSccript calendar object.
	 *       To return the data in the acceptable format, we need to use 
	 *       Response::json($events); through an Ajax call (from the view file)
	 *       as used in getEvents() in this classvar_dump();die;
	 */
	 public function index()
    {
		$user_id = auth()->user()->id ;
		$clients = Client::where('status','=','active')
			->where('user_id','=',$user_id)
			->get();
		return view('fullcalendarDates',compact('user_id','clients'));
    }
    
   
    public function create(Request $request)
    { 
	
	
        $insertArr = [ 'title' => $request->title,
                       'start' => $request->start,
                       'end' => $request->end,
					   'description'=> $request->description,
					   'client_id' => $request->client_id,
					   'user_id' => $request->user_id,
                    ];

        $event = Event::insert($insertArr);   
        return Response::json($event);
    }
     
 
    public function update(Request $request)
    {
        $where = array('id' => session()->get('event_id') );
        $updateArr = [	
						'title' => $request->title,
						'start' => $request->start,
						'end' => $request->end,
						'event_status_id' => $request->event_status_id, 
						'description' => $request->description
					];
        $event  = Event::where($where)->update($updateArr);
 
        return Response::json($event);
    } 
 
 
    public function destroy(Request $request)
    {
        $event = Event::where('id',$request->id)->delete();
   
        return Response::json($event);
	}
	

	public function getEvents(Request $request)
	{
		//$events = Event::where('user_id','=',$request->user_id)->get();
		$response['events'] = DB::table('events')
			->join('event_status', 'event_status.id', '=', 'events.event_status_id')
			->select('events.*','event_status.color', 'event_status.status')
			->where('events.user_id','=',$request->user_id)
			->get();
			
		$query = "SELECT id, `status` AS text
				FROM event_status ORDER BY sortorder";
		$response['status_array'] =  DB::select( DB::raw($query));  

		return Response::json($response);
	}
	
	
	// Returns details for the passed eventID
	public function getEvent(Request $request)
	{
		//Save event_it in session. We will need this at the time of event_update
		session()->put('event_id', $request->event_id); 
		$event = DB::table('events')
			->join('event_status', 'event_status.id', '=', 'events.event_status_id')
			->join('clients','events.client_id', '=', 'clients.id')
			->select('events.*','event_status.color', 'event_status.status', 'clients.firstname', 'clients.lastname')
			->where('events.id','=',$request->event_id)
			->first();
		return Response::json($event);
	}


	public function index_org($user_id= null)
    {

		// return events for the passed user_id or the current (logged-in user)
		
		$user_id = empty($user_id ) ? auth()->user()->id : $user_id ;
		$user_id = (int) $user_id;
//		session(['user_id_for_calendar' =>  $user_id]);
//		$value =  session('user_id_for_calendar');
		
        if(request()->ajax()) 
        {
 
			 $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
			 $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');
			 
			 $data = Event::whereDate('start', '>=', $start)
					->whereDate('end',   '<=', $end)
					->where('user_id','=', $user_id)
					->get(['id','title','start', 'end']); 
			 
			/*
			 if ($showAll)
			 {
				 $data = Event::whereDate('start', '>=', $start)
					->whereDate('end',   '<=', $end)
					->get(['id','title','start', 'end']); 
			 }
			 else
			 {
				 $data = Event::whereDate('start', '>=', $start)
					->whereDate('end',   '<=', $end)
					->where('user_id','=', session('user_id_for_calendar'))
					->get(['id','title','start', 'end']); 
			 }
			*/
			
			
			 return Response::json($data);
        }
        return view('fullcalendarDates_org',compact('user_id'));
    }

	

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\Client;
use App\Models\Note;
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
		
		$query = "SELECT id, firstname, lastname
				FROM clients
				WHERE user_id = 2
				UNION 
					SELECT null, '--SELECT--',''
					ORDER BY 2";
		$clients =  DB::select( DB::raw($query));  
		$repeatFrequency = [
								['value'=>'', 'text'=>'None'],
								['value'=>'Weekly', 'text'=>'Weekly'],
						//		['value'=>'Monthly', 'text'=>'Monthly'],
							];
				
		return view('fullcalendarDates',compact('user_id','clients','repeatFrequency'));
    }
    
   
    /**
	  * Created event record(s)
	  * If $request->frequency and $request->enddate are passed, create a record in repeat_events and 
	  *   then create required records in the events table. 
	  * If  $request->frequency and $request->enddate  are not passed, create a record in the events table 
	  */
    public function create(Request $request)
    { 
		if ($request->frequency && $request->enddate)
		{
			if (DB::table('repeat_events')->insert( 
					[
						'title' => $request->title,
						'user_id' => $request->user_id,
						'client_id' => $request->client_id,
						'frequency' => $request->frequency,
						'startdate' =>$request->startDate,
						'enddate' =>$request->enddate
					]
				))
			{
				$repeat_events_id = DB::getPdo()->lastInsertId();
				$i=0;
				
				$event_start_time = substr($request->start,10);
				$event_end_time = substr($request->end,10);
				$event_date = $request->startDate;
				
				while ($request->enddate > $event_date)
				{
					$start = $event_date . ' ' . $event_start_time;
					$end = $event_date . ' ' . $event_end_time;
					
					
					$insertArr = [ 'title' => $request->title,
						'date' =>$event_date,
						'repeat_events_id' => $repeat_events_id,
                       'start' => $start,
                       'end' => $end,
					   'description'=> $request->description,
					   'client_id' => $request->client_id,
					   'user_id' => $request->user_id,
                    ];

					$event = Event::insert($insertArr);  
					$event_date =   date ("Y-m-d", strtotime ($event_date ."+7 days"));
				}
				
			}
		}
		else
		{
			$insertArr = [ 'title' => $request->title,
						'date' => $request->startDate,
                       'start' => $request->start,
                       'end' => $request->end,
					   'description'=> $request->description,
					   'client_id' => $request->client_id,
					   'user_id' => $request->user_id,
                    ];

			$event = Event::insert($insertArr);   		
		}
      
        return Response::json($event);
    }
     
 
	/**
	  * Update current event
	  * if $request->note is passed, create a record in the client_notes table
	  */
    public function update(Request $request)
    {
		$event_id = session()->get('event_id');
        $where = array('id' => $event_id );
        $updateArr = [	
						'title' => $request->title,
						'start' => $request->start,
						'end' => $request->end,
						'event_status_id' => $request->event_status_id, 
						'description' => $request->description
					];
        $event  = Event::where($where)->update($updateArr);
		
		// create client_notes record
		if ($request->note)
		{
			$insertArr = [ 
						'event_id' => $event_id,
					   'note'=> $request->note,
					   'client_id' => session()->get('client_id'),
					   'create_user_id' => auth()->user()->id,
                    ];
			$event = Note::insert($insertArr);   
		}
 
        return Response::json($event);
    } 
	
	
	public function moveEvent(Request $request)
	{
		 $where = array('id' => $request->event_id );
        $updateArr = [	
						'start' => $request->start,
						'end' => $request->end,
						'date' => $request->date, 
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
	
	
	// Returns data for creating SELECT Options for Event status codes (Pending, Completed, Cancelled, etc. )
	public function getEventStatusCodes(Request $requset)
	{
		$query = "SELECT id, `status` AS text
				FROM event_status ORDER BY sortorder";
		$response =  DB::select( DB::raw($query));  

		return Response::json($response);	
	}
	
	
	// Returns details for the passed eventID
	public function getEvent(Request $request)
	{
		//Save event_it in session. We will need this at the time of event_update
		session()->put('event_id', $request->event_id); 
		$event['event'] = DB::table('events')
			->join('event_status', 'event_status.id', '=', 'events.event_status_id')
			->join('clients','events.client_id', '=', 'clients.id')
			->select('events.*','event_status.color', 'event_status.status', 'clients.firstname', 'clients.lastname')
			->where('events.id','=',$request->event_id)
			->first();
		session()->put('client_id', $event['event']->client_id);   // save client_id. Will be used in update()
		// get current note
		$query = "
					SELECT event_id, note, 	 CONCAT(firstname, ' ', lastname, ' at ', c.created_at) AS created_by  
					FROM client_notes c
					INNER JOIN `users` u ON c.create_user_id = u.id
					WHERE c.event_id = " . $request->event_id . "
					ORDER BY c.id
				
				";
		$event['note'] =  DB::select( DB::raw($query)); 
		
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

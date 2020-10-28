<?php
namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Note;
use Illuminate\Http\Request;

class clientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    // Dashboard. User passes an client.id 
    /** 
     * Client Dashboard 
     * The calling program passes client.id 
     * We will save this in session with key 'client_id'
     *  Later, it can be used with other methods, e.g. to displays notes for the current client 
     * 
     */ 
    public function show($id, Request $request)
    {
        $request->session()->put('client_id', $id);     // save in session variable 
        $client = Client::where('id',$id)->get()->first();
        $request->session()->put('client_name',  $client->firstname . ' '. $client->lastname);
     //   $notes =Client::getNotes($id);
        $notes = Note::where('client_id', $id)->orderBy('id', 'desc')->take(2)->get();

        return view('client.show', compact('client','notes'));
    }

    public function create()
    {
        return view('client.create');
    }

    public function store(Request $request)
    {
        $validation  = $this->validateClient($request);
        $user_id = auth()->user()->id;

        $client = new Client(['firstname'=>$request->input('firstname'),
                             'lastname'=>$request->input('lastname'),
                             'address'=>$request->input('address'),
                             'city'=>$request->input('city'),
                             'postalcode'=>$request->input('postalcode'),
                             'email'=>$request->input('email'),
                             'phone'=>$request->input('phone'),
                             'user_id' => $user_id,
                 ] );
        $client->save();
        return redirect('/home');
    }
    
    public function edit($id, Request $request)
    {
        // 
        $client_id = $request->session()->get('client_id');
        $client = Client::find($id);
        return view('client.edit',['client'=>$client]);
    }

    public function update($id, Request $request)
    {
        $this->validateClient($request);
        $client = Client::find($id);

        $client->firstname = request('firstname');
        $client->lastname = request('lastname');
        $client->address = request('address');
        $client->city = request('city');
        $client->postalcode = request('postalcode');
        $client->email = request('email');
        $client->phone = request('phone');
        $client->save();

       return redirect('/client/show/' . $id);
    }

    public function validateClient(Request $request)
    {
        return $request->validate([
            'firstname' => ['required'],
            'lastname' => ['required'],
            'email' => ['email'],
        ]);
    }

    public function notes(Request $request)
    {
        $client_id = $request->session()->get('client_id');
        $client_name = $request->session()->get('client_name');
        $notes = Note::where('client_id',$client_id)->orderBy('created_at', 'desc')->paginate(3);
        return view('client.notes', compact('client_name','notes','client_id'));
        
    }

    public function noteCreate(Request $request)
    {
        $client_id = $request->session()->get('client_id');
        $client_name = $request->session()->get('client_name');
        return view('client.createNote', compact('client_name','client_id'));
    }

    public function noteStore(Request $request)
    {
        $request->validate([
            'note' => ['required'],
        ]);
        $note  = $request->input('note');
        $updated_note = preg_replace("/\r\n|\r|\n/", '<br>', $note);
        
        $prefix = "Created by " . auth()->user()->firstname . ' ' . auth()->user()->lastname . 
                  ' at ' . date("D M d, Y G:i") . '<br>';


        $note = new Note(['note'=>$prefix . $updated_note,
                                'client_id'=>$request->session()->get('client_id'),
                               'create_user_id' => auth()->user()->id,
                 ] );
        $note->save();
        return redirect('/client/notes');
    }

    public function noteEdit($id )
    {
        $client_name =  session()->get('client_name');
        // save note id in session for use with noteUpdate
        session()->put('note_id', $id); 
        $note = Note::where('id', $id)->get()->first();
        $note->note  = preg_replace( '/<br>/',"\r\n",$note->note);
        return view('client.noteEdit', compact('client_name','note'));
    }

    // saves updated note in client_notes table
    public function noteUpdate(Request $request)
    {
        $request->validate(['addNote' => ['required'], ]);
        $note_id =  session()->get('note_id');
        $note  =  $request->input('note');
        $note =  preg_replace("/\r\n|\r|\n/", '<br>', $note);

        $addNote  = $request->input('addNote');
        $prefix = "<br><br>Updated by " . auth()->user()->firstname . ' ' . auth()->user()->lastname . 
                  ' at ' . date("D M d, Y G:i") . '<br>';
        $addNote =  $note.   $prefix . $addNote;
       
        // Load Existing Note from table 
        $noteObject = Note::find($note_id);

        $noteObject->note = $addNote;
        $noteObject->update_user_id = auth()->user()->id;
        $noteObject->save();
        return  redirect( url()->previous());

    }
}

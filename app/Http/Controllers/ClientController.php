<?php
namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class clientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    // Dashboard 
    public function show($id)
    {
        $client = Client::where('id',$id)->get()->first();
        $notes =Client::getNotes($id);
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
    
    public function edit($id)
    {
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

}

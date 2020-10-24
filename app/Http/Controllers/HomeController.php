<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
       // dd($request);
        $allClients = $request->allClients;
        $searchText = $request->searchText;
		// Data that will be passed to the home controller 
        $fruit = array('Banana','Orange','Mango','Apple');  // for x-header (header) comonent 
        // Fetch clients for logged in user 
        $user_id = auth()->user()->id;
        $user = \App\Models\User::find($user_id);
        $clients =$allClients ? $user->getAllClients( $searchText): $user->getClients( $searchText);
        return view('home',compact('fruit','clients','allClients','searchText'));
           
    }


}

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


    public function show($id)
    {
        $client = Client::where('id',$id)->get()->first();
        $notes =Client::getNotes($id);
        return view('client.show', compact('client','notes'));
    }


}

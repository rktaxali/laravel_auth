<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    // Displays permissions for all users
    // We will all the users's list to be filtered by first/last name
    public function index(Request $request)
    {
        if(auth()->user()->hasPermissionTo('Permission'))
        {
            return 'Permission list';
        }
        else
        {
            return view('notAuthorized');
        }
   
    }
}

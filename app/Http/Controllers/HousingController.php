<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Housing;


class HousingController extends Controller
{
    /**
     * Display all housings and linked client's details 
     */
    public function index()
    {
       $housings =  Housing::getAllHousing();
       return view('housing',compact('housings'));
    }
    

    public function store()
    {
        return "Housing store";
    }
}

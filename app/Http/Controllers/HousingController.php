<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Housing;
use App\Models\Client;


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

    public function allot($housing_id = null)
    {
   

        $housing = Housing::where('id',$housing_id)->get()->first();
        // clients who are without housing 
        $clients = Client::clientsWithoutHousing();
        return view ('allotHousing',compact('housing','clients','housing_id'));
    }

    public function manage(Request $request)
    {
        $housing_id = $request->input('allot_housing_id');
        $revoke_housing_id = $request->input('revoke_housing_id');
    
        
        if (! empty( $housing_id))
        {
            $housing = Housing::where('id',$housing_id)->get()->first();
            // clients who are without housing 
            $clients = Client::clientsWithoutHousing();
            return view ('allotHousing',compact('housing','clients','housing_id'));
        }

        if (! empty( $revoke_housing_id))
        {
            $housing = Housing::where('id',$revoke_housing_id)->get()->first();
            $client = Housing::getClient($revoke_housing_id);
            return view ('client.revokeHousing',compact('housing','client','revoke_housing_id'));
        }
        
    }


    public function storeAllotment(Request $request, $housing_id)
    {
        $request->validate([
            'start_date' => ['required'],
        ]);

        Housing::allocateHousing($housing_id, $request->input('client_id'),  $request->input('start_date'));

      //  $this->index();  // redisplay housing allocated  page. This does not work 
        
        // The idea is to display the success message, however, how do we clear this ?
        //$request->session()->put('success', 'Housing has been allotted to the Client'); 
        $success_message = 'Housing has been allotted to the Client';
        $housings =  Housing::getAllHousing();
       return view('housing',compact('housings','success_message')); 
    }

 
    public function revokeAllotment(Request $request)
    {
      //  dd('in revole allotment');
        
        $request->validate([
            'end_date' => ['required'],
        ]);
        Housing::revokeHousing($request->input('revoke_housing_id'),  $request->input('end_date'));
        $success_message = 'Housing has been revoked';
        $housings =  Housing::getAllHousing();
       return view('housing',compact('housings','success_message')); 

      
    }

    
}

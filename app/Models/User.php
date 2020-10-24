<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // gets all clients for the current user 
    public function getClients( $searchText = null)
    {
        if ( $searchText)
        {
           /*  $client =  DB::table("clients")
                ->where("user_id","=",$this->id)
                ->where(function($query,$searchText) {
                    $query->where('firstname','LIKE', '%'. $searchText .'%')
                          ->orWhere('lastname','LIKE', '%'. $searchText .'%');
                })
                ->get(); 
                */ 
                
                $client = DB::select( DB::raw("SELECT * FROM clients WHERE user_id = :id 
                        AND ( firstname LIKE :firstname
                              or lastname like :lastname )
                "), 
                    [
                        'id'=> $this->id, 
                        'firstname'=> '%'.$searchText.'%', 
                        'lastname'=> '%'.$searchText.'%', 
                        
                    ]
                    );
                 


        }
        else
        {
            $client =  DB::table("clients")->where("user_id","=",$this->id)->get();  
        }
       
        
        return  $client;
    }

    // gets all clients for all users
    public function getAllClients($searchText = null)
    {
        if ( $searchText)
        {
           /*  
            $client =  DB::table("clients")
                ->where('firstname','LIKE', '%'. $searchText .'%')
                ->get();  
 */

                $client =  DB::table("clients")
                ->where('firstname','LIKE', '%'. $searchText .'%')
                ->orWhere('lastname','LIKE', '%'. $searchText .'%')
                ->get();                  
        }
        else
        {
            $client =  DB::table("clients")->get();  
        }
        return  $client;
    }
}

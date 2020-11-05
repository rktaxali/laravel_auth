<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use \Spatie\Permission\Traits\HasRoles;   // for Spatie roles


use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;  // 'HasRoles' added for Spatie 


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'firstname',
        'lastname',
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
                
                $client = DB::select( DB::raw("SELECT clients.*,
                            concat(users.firstname,' ',users.lastname) as username  
                        FROM clients 
                        INNER JOIN users ON clients.user_id = users.id
                        WHERE user_id = :id 
                        AND ( clients.firstname LIKE :firstname
                              or clients.lastname like :lastname )
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
             $client = DB::select( DB::raw("SELECT clients.*,
                                    concat(users.firstname,' ',users.lastname) as username 
                                FROM clients 
                                INNER JOIN users ON clients.user_id = users.id
                                WHERE user_id = :id 
                                "),
                                ['id'=> $this->id, ]
                         );
        }
       
        
        return  $client;
    }

    // gets all clients for all users
    public function getAllClients($searchText = null)
    {
        if ( $searchText)
        {
            $client = DB::select( DB::raw("SELECT clients.*,
                        concat(users.firstname,' ',users.lastname) as username  
                        FROM clients 
                        INNER JOIN users ON clients.user_id = users.id
                        WHERE ( clients.firstname LIKE :firstname
                                or clients.lastname like :lastname )
                        "), 
                        [
                            'firstname'=> '%'.$searchText.'%', 
                            'lastname'=> '%'.$searchText.'%', 

                        ]
                 );                 
        }
        else
        {
            //$client =  DB::table("clients")->get(); 
            // Besides data from the "clients" table, also return client owner name. For that, we will use DB::Raw 
            $client = DB::select( DB::raw("SELECT clients.*,
                                concat(users.firstname,' ',users.lastname) as username 
                            FROM clients 
                            INNER JOIN users ON clients.user_id = users.id")
                        );
        }
        return  $client;
    }
}

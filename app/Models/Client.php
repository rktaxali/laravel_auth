<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;



class Client extends Model
{
    use HasFactory;
    protected $table = 'clients';

    //protected $fillable =['firstname','lastname','excerpt'];  // all mass assignment for these fields 
    protected $guarded = [];  // or don't gaurd any field, allow mass assignment 

    // Returns notes for the passed clientID
    public static function getNotes($id)
    {
        $clientNotes = DB::table("client_notes")
                ->leftJoin('users AS u1', 'u1.id', '=', 'client_notes.create_user_id')
                ->leftJoin('users AS u2', 'u2.id', '=', 'client_notes.update_user_id')
                ->select('client_notes.*', 'u1.name AS create_username', 'u2.name AS update_username' )
                ->where("client_id","=",$id)
                ->get();
        return $clientNotes;
    }
   

}

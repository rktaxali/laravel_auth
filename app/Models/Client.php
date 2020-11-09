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
	

    /**
     * Returns details about the current housing for the client
     */
    public function getCurrentHousing($id = null)
    {
        $id = ! empty($id) ? $id : $this->id;
        $housing = DB::table("client_housing AS ch")
                ->leftJoin('housing AS h', 'h.id', '=', 'ch.housing_id')
                ->where("ch.client_id","=",$id)
                ->where("ch.allotment_status","=",'Current')
                ->get()->first();
        return $housing;
    }

    /**
     * Returns details about the All housing(s) for the client
     */
    public function getAllHousing($id = null)
    {
        $id = ! empty($id) ? $id : $this->id;
        $housing = DB::table("client_housing AS ch")
                ->leftJoin('housing AS h', 'h.id', '=', 'ch.housing_id')
                ->where("ch.client_id","=",$id)
                ->orderBy('start_date','desc')
                ->get();
        return $housing;
    }

    // returns clients with status = "active' who don't have housing alloted 
    public static function clientsWithoutHousing()
    {
        $query = " SELECT c.id as client_id, concat(c.firstname, ' ',c.lastname) as client_name
            FROM clients c
            WHERE c.`status` = 'Active'
                AND NOT EXISTS (
                                SELECT DISTINCT client_id
                                FROM client_housing ch 
                                WHERE ch.allotment_status = 'Current'
                                    AND c.id = ch.client_id
                            )
        ";

        return DB::select( DB::raw($query));
               
    }

   

}

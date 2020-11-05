<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Housing extends Model
{
    use HasFactory;
    protected $table = 'housing';


    // returns information about the client that is currently holding the allotment for
    // the passed $housing_id
    public static function getClient($housing_id)
    {
        $query = "SELECT ch.housing_id, ch.client_id, ch.start_date, CONCAT(c.firstname, ' ', c.lastname) AS client_name 
            FROM client_housing ch 
            INNER JOIN `clients` c ON ch.client_id = c.id
            WHERE ch.housing_id = '" . $housing_id . "'
                AND ch.allotment_status = 'Current';
            ";
        $result =  DB::select( DB::raw($query));  
        return $result[0];
    }

    public static  function getAllHousing()
    {
        $query = "SELECT h.id, h.address, h.city, h.postalcode, h.province, h.availability_status, 
                        ch.client_id , 
                    CONCAT(c.firstname, ' ', c.lastname) AS client_name, ch.start_date
                FROM housing h
                LEFT JOIN client_housing ch  ON ch.housing_id = h.id and ch.allotment_status = 'Current'
                LEFT JOIN clients c ON ch.client_id = c.id ";
        return  DB::select( DB::raw($query));  
    }


    public static function getAvailableHousing()
    {
        $availableHousing =  DB::table("housing")
            ->where("availability_status","=",'Available')
            ->get();
        return $availableHousing ;
    }

    public static function getOccupiedHousing()
    {
        $occpiedHousing = DB::select( DB::raw("SELECT h.id, ch.client_id , 
                            CONCAT(c.firstname, ' ', c.lastname) AS client_name, ch.start_date,
                    h.address, h.city, h.postalcode, h.province
                    FROM client_housing ch 
                    INNER JOIN housing h ON ch.housing_id = h.id
                    INNER JOIN clients c ON ch.client_id = c.id 
                    WHERE ch.allotment_status = 'Current'
                    ")
                );  
        return $occpiedHousing ;
    }

   

    /**
     * Allocate passed $housing_id  to $cleint_id*/  
    public static function allocateHousing($housing_id, $client_id, $start_date = null)
    {
        $allotment_start_user_id = auth()->user()->id; 
        // TO DO: Passing allotment_start_date <---
        DB::insert('insert into client_housing( housing_id,client_id, allotment_start_user_id, start_date) 
                values (?,?, ?,?)', [$housing_id,$client_id, $allotment_start_user_id, $start_date]);
        $id = DB::getPdo()->lastInsertId();  // returns id of the inserted record, Not Used 
        // update availability_status in the housing table 
        DB::select( DB::raw("UPDATE housing 
                SET availability_status = 'Allotted'
                  WHERE id = $housing_id")
                );  

    }

    // revoke housing for the passed housing_id
    public static function revokeHousing($housing_id, $end_date)
    {
        $user_id = auth()->user()->id; 

        $query = "UPDATE housing h
            INNER JOIN client_housing ch ON h.id = ch.housing_id
            SET h.availability_status = 'Available',
                ch.allotment_status = 'Past',
                ch.end_date = '$end_date',
                ch.allotment_end_user_id = $user_id
            WHERE h.id = ?";
        $affected = DB::update($query, [$housing_id]);

    }

}

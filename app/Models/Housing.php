<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Housing extends Model
{
    use HasFactory;
    protected $table = 'housing';


    public static  function getAllHousing()
    {
        $query = "SELECT h.id, h.address, h.city, h.postalcode, h.province, h.availability_status, 
                        ch.client_id , 
                    CONCAT(c.firstname, ' ', c.lastname) AS client_name, ch.start_date
                FROM housing h
                LEFT JOIN client_housing ch  ON ch.housing_id = h.id
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
    public static function allocateHousing($housing_id, $client_id)
    {
        $allotment_start_user_id = auth()->user()->id; 
        // TO DO: Passing allotment_start_date <---
        DB::insert('insert into client_housing( housing_id,client_id, allotment_start_user_id) 
                values (?,?, ?)', [$housing_id,$client_id, $allotment_start_user_id]);
        $id = DB::getPdo()->lastInsertId();  // returns id of the inserted record, Not Used 
        // update availability_status in the housing table 
        DB::select( DB::raw("UPDATE housing 
                SET availability_status = 'Allotted'
                  WHERE id = $housing_id")
                );  

    }

}

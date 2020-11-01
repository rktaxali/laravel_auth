<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

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
            $users =  DB::table("users")->orderBy('id')->get(); 
              
            $permissions =  DB::table("permissions")->get();
            foreach ( $permissions  AS  $permission)
            {
                $permission_id = $permission->id;
                $query = "SELECT u.id, if(mp.permission_id,1,0) As has_permission, permissions.name
                    FROM users u
                    LEFT JOIN permissions ON permissions.id =  $permission_id
                    LEFT  JOIN model_has_permissions mp ON u.id = mp.model_id AND mp.permission_id =  $permission_id
                   ORDER BY u.id 
                    ";
                $user_permissions   =  $client = DB::select( DB::raw($query));
                // $user_permissions contains user_ids and has_permission= 1 if user has permission for permissions.name
                $i=0;
                foreach ( $user_permissions AS $user_permission)
                {
                    $user_id = $user_permission->id;
                    $permission_name =  $user_permission->name;
                    $users[$i]->$permission_name =  $user_permission->has_permission;
                    $i++;
                }
                
            }
            return view('permissions',compact('users'));
       


        }
        else
        {
            return view('notAuthorized');
        }
   
    }

    public function store(Request $request)
    {
        $items = DB::table('permissions')->pluck('id', 'name');
        $permissionArray = [];
        foreach ($items as $name => $id) {
            $permissionArray[$name]  = $id;
        }
        

        // Clear all permissions from the model_has_permissions and create new permission records 
        DB::table('model_has_permissions')->where('permission_id', '<>', 7)->delete();

 

        foreach ($request->all() as $key=>$str)
        {
           if ($key ==='_token')  continue;

            $user_id = substr($key, strrpos($key, "_", -1) + 1);
            $permission = substr($key, 0,strrpos($key, "_", -1));
            $permission_id = $permissionArray[ $permission];
            
            DB::table('model_has_permissions')->insert(
                ['permission_id' => $permission_id,
                 'model_id' =>  $user_id,
                 'model_type' => 'App\Models\User'
                 ]
            );
            
        }
        return  back()
             ->with('success','User permissions have been updated');
       
    }
}

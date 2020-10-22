<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;





class uploadController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function uploadForm()
    {

       $path =  public_path('images');
      // dd(app_path());
        return view('upload');
    }


    public function uploadFile(Request $request)
    {
         $request->validate([
                // required, type: file, max size: 1204 K Bytes, allowed extensions
                'file' => 'required|file|max:1024|mimes:jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf,zip',
            ]);
       $path_parts = pathinfo( $request->file->getClientOriginalName());
       $original_name =  $path_parts['basename'];
       $imageName  = $path_parts['filename']. '_' . time().'.'. $path_parts['extension']; 
       $size =  $request->file->getSize();
       $mimeType = $request->file->getClientMimeType();
    
        /**
         * Store the uploaded file in specified folder
         * the store() method automatically generates a unique filename to save the uploaded file,
         * therefore, there should not be a need to specify a filename to use with the uploaded  file, 
         * though it can be done with storeAs().  Be careful about sanitizing filename 
         * store() and storeAs() methods return the path (including filename), which we can save in a table 
         * to retrieve the filename
         */

        // $path = $request->file->store('public');  // store in the storage\app\public folder
        $path = $request->file->store('public/uploads');  // store in the storage\app\public\uploads folder, users system generated filename
       // $path = $request->file->move( public_path('images')); 
               
        //   $path = $request->file->storeAs('public/uploads', $imageName );   // store in the public/uploads folder with $filename
       
        // Save file details in the uploaded_files table 
        $user_id = auth()->user()->id;
        $uploadFilename  = Str::after($path, 'public/uploads/');
        DB::insert('insert into uploaded_files (original_name, upload_path, user_id,mimeType,`size`) 
            values (?, ?,?, ?,?)', 
            [ $original_name,  $path, $user_id, $mimeType, $size ]);

        return back()
            ->with('success','You have successfully uploaded the file ' .  $original_name)
            ->with('isImage',Str::startsWith($mimeType,'image')  )
            ->with('uploadFilename',$uploadFilename );
           

    }


    public function userFiles()
    {
         $user_id = auth()->user()->id;
         $uploaded_files = DB::table('uploaded_files')
                ->where('user_id',$user_id)
                ->select('id', 'original_name','upload_path','mimeType','size','created_at')->get();
       
        return view('user-files', compact('uploaded_files'));
    }

    public function deleteFile($id)
    {
        // Get storage filename for the passed $id
        $row = DB::table('uploaded_files')
                ->where('id',$id)
                ->select('id', 'upload_path')->get()->first();
        
        /**
         * NOTE: There was a problem using File::delete() as well as Storage::delete()
         *       Also file_exists() fails unless basePath() is used.
         */
        $file = app()->basePath(). '/storage/app/'.$row->upload_path;

       if(file_exists($file))
        {
            
            unlink($file);
            // delete record from the table 
            DB::table('uploaded_files')->delete($id);
            return back()
                 ->with('success','You have successfully delete the file ' );
        }
        else
        {
            return back()
                ->with('Error','Error Deleting the file ' );
        }
      
    }

}

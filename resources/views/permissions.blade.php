@extends('layouts.app')  <!-- views/layouts/app.blade.php -->

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2>User Permissions</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                    </div>
            @endif
        </div>
         
    </div>

 
    <div class = "row ">
        <div class="col-12 ">
            
            @if ( count($users)  )
                <form action="{{ route('permission.store') }}" method="POST">
                                @csrf
                        <table class="table table-bordered table-responsive-lg">
                            <tr>
                                <th>User</th>
                                <th>Housing</th>
                                <th>Create Client</th>
                                <th>Medication</th>
                                <th>Create User</th>
                            </tr>

                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        {{ $user->firstname }} {{ $user->lastname }}
                                    </td>
                                    
                                    <td>
                                        <input type="checkbox" id="housing_{{$user->id}}" name="housing_{{$user->id}}" 
                                            @if($user->housing) Checked @endif 
                                            value="1">       
                                    </td>

                                    <td>
                                        <input type="checkbox" id="create_client_{{$user->id}}" name="create_client_{{$user->id}}" 
                                            @if($user->create_client) Checked @endif 
                                            value="1">       
                                    </td>
                                    <td>
                                        <input type="checkbox" id="medication_{{$user->id}}" name="medication_{{$user->id}}" 
                                            @if($user->medication) Checked @endif 
                                            value="1">       
                                    </td>
                                    <td>
                                        <input type="checkbox" id="create_user_{{$user->id}}" name="create_user_{{$user->id}}" 
                                            @if($user->create_user) Checked @endif 
                                            value="1">       
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </table>

                        <div class="row mt-4" >
                                <button type="submit" class="btn btn-primary ml-3">Submit</button>

                                <a href="/home"  class="ml-4"><button type="button"  class="btn btn-secondary" >Cancel</button></a>
                    </div>


                </form>
            @endif
    
        
        </div>

       
   
    </div>
        


</div>
@endsection


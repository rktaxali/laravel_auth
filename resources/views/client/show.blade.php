@extends('layouts.app')

@section('content')


<div class="container">
    <h3> {{$client->firstname}} {{$client->lastname}}'s Dashboard</h3>
   
    <div class = "card p-2">
        <div class="row">
                <div class="col-2">
                Name: 
            </div>
            <div class="col-6">
                {{$client->firstname}} {{$client->lastname}} 
            </div>
        </div>

        <div class="row">
                <div class="col-2">
                Address: 
            </div>
            <div class="col-6">
                {{$client->address}}@if($client->city),  {{$client->city}} @endif - {{$client->postalcode}}
            </div>
        </div>

        <div class="row">
            <div class="col-2">
                Phone:  
            </div>
            <div class="col-6">
                {{$client->phone}} 
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                Email:  
            </div>
            <div class="col-6">
                {{$client->email}} 
            </div>
        </div>
        <div class="row ml-1 mt-2"><a href="/client/edit/{{ $client->id}}"><button class="btn btn-secondary" >Edit</button></a></div>
    </div>
        


    <div class="row"><a href="/home">Back to Clients</a></div>


    <!-- Notes -->
    
    <div class='row mt-4'>
        @if ( count($notes)  )
           
            <table class="table table-bordered table-responsive-lg">
                <tr>
                    <th>Note</th>
                    <th>Created</th>
                </tr>

                @foreach ($notes as $note)
                    <tr>
                        <td>
                            {!! $note->note !!}
                            <br> 
                            <a href="/client/noteEdit/{{$note->id}}/show" class="nav-link">
                                <span class="material-icons">edit</span>
                            </a>
                            
                             
                        </td>
                        
                        <td>
                            {{ $note->created_at }}  
                        </td>
                        
                    </tr>
                @endforeach
            </table>
            <div class="row"><a href="{{ route('client.notes') }}">Show All Notes</a></div>
        @else
                
                <div class="row">
                    <div class="col-8">
                        <p>There are No notes for the Client</p>
                        <a href="/client/noteCreate">Add a Note</a>
                    </div>
                </div>
        @endif
    </div>

    

</div>
@endsection

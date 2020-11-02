@extends('layouts.app')

@section('content')


<div class="container">
    <h3> {{$client->firstname}} {{$client->lastname}}'s Dashboard</h3>
   
    <div class = "row">
        <div class="col-5 border border-secondary rounded p-2 m-2">
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
                    {{$client->address}}<br>
                    {{$client->city}} &nbsp;&nbsp;{{$client->province}} - {{$client->postalcode}}
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
            <div class="row ml-1 mt-2"><a href="{{  route('client.show',['id'=> $client->id]) }}">
                <button class="btn btn-secondary" >Edit</button></a>
            </div>
        
        </div>

        <div class="col-5 border border-secondary rounded p-2 m-2">

            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                </div>
            @endif


            <div class="m-2 ml-3">
                @if(  $housing )
                    <div class="row">
                        <h5>Housing</h5><br>
                    </div>
                    <div class="row">
                        {{$housing->address}} <br>
                        {{$housing->city}} &nbsp;&nbsp;{{$housing->province}} - {{$housing->postalcode}}
                    </div>
                    <div class="row mt-2">
                        Allotment Date:  {{$housing->start_date}}
                    </div>

                    <div class="row mt-2"><a href="/client/housing">Show All Housings</a></div>
            

                @else
                    <div class="row">
                        <div class="col-12">
                            <strong>No Housing Allocated. </strong>
                        </div>
                    </div>
                    @can('housing')
                        @if(  count($availableHousing) )
                            <div class="row">
                                <div class="col-12">
                                    <h5>Housing Available for Allotment</h5>
                                </div>
                            </div>
                            <form action="{{ route('client.allotHousing') }}" method="POST">
                                @csrf


                                @foreach($availableHousing as $housing )
                                    <div class="row mb-3">
                                        <div class="col-8">
                                            {{$housing->address}}<br>
                                            {{$housing->city}} &nbsp;&nbsp;{{$housing->province}} - {{$housing->postalcode}}
                                        </div>
                                        <div class="col-2">
                                            <button type="Submit" name="housing_id"  value="{{$housing->id}}" class="btn btn-secondary">Allot</button>
                                        </div>
                                        
                                    </div>
                                @endforeach
                            </form>
                        @endif
                    @endcan

                @endif
            </div>
        </div>
   
    </div>
        

    <div >
        <div class="row">
            <div class="col-12">
                <a href="/home">Back to Clients</a>
            </div>
        </div>
    </div>

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

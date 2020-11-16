@extends('layouts.app')

@push('head')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
 @endpush


@section('content')


<div class="container">
    <h3> {{$client->firstname}} {{$client->lastname}}'s Dashboard</h3>
   
    <div class = "row">
        <div class="col-lg-5 col-md-12 border border-secondary rounded p-2 m-2">
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
            <div class="row ml-1 mt-2"><a href="{{  route('client.edit',['id'=> $client->id]) }}">
                <button class="btn btn-secondary" >Edit</button></a>
            </div>
        
        </div>

        <div class="col-lg-5 col-md-12 border border-secondary rounded p-2 m-2">

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

                    <div class="row mt-2"><a href="{{  route('client.housing') }}">Show All Housings</a></div>
					


                @else
                    <div class="row">
                        <div class="col-12">
                            <strong>No Housing Allocated. </strong>
                        </div>
                    </div>
                 
                @endif
            </div>
        </div>
   
    </div>
        

    <div >
        <div class="row">
            <div class="col-12">
                <a href="{{  route('home') }}">Back to Clients</a>
            </div>
        </div>
    </div>

    <!-- Notes -->
    
    <div class='row mt-4'>
        @if ( count($notes)  )
           
            <table class="table table-bordered table-responsive-lg">
                <tr>
                    <th>Note</th>
                </tr>

                @foreach ($notes as $note)
                    <tr>
                        <td>
                            {!! $note->note !!}
                            <br> 
							@if($note->note_type=='regular_note')
								<a href="{{  route('client.noteEdit', ['id'=>$note->id, 'source'=>'show']) }}" class="nav-link">
									<span class="material-icons">edit</span>
								</a>
                            @endif
							
							@if($note->note_type=='appointment_note')
									Appointment on {{$note->appointment_datetime}}  for  {{$note->client_name}} re {{ $note->title}} 
									<a  onClick="getEventDetails( {{ $note->event_id }} )"
										 class="nav-link" >
										<span class="material-icons" style="color:blue; cursor:pointer">edit</span>
									</a>
										 
							@endif
                             
                        </td>
                        
                       
                        
                    </tr>
                @endforeach
            </table>
			@include('components.event_edit_modal')

            <div class="row"><a href="{{ route('client.notes') }}">Show All Notes</a></div>
        @else
                
                <div class="row">
                    <div class="col-12">
                        <p>There are No notes for the Client</p>
                        <a href="{{  route('client.noteCreate') }}">
                            Add a Note</a>
                    </div>
                </div>
        @endif
    </div>
	

    

</div>

@section('footer-scripts')
        @include('scripts.notes')
@endsection
	
@endsection

@extends('layouts.app')  <!-- views/layouts/app.blade.php -->

@push('head')
	<!-- FullCalendar -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
  	<script src="{{ asset('js/fullcalendar.js') }}" ></script>
@endpush

@section('content')

    <div class="container">

        <div>
            <!-- Button trigger modal -->
            <button hidden id="btnModal" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Launch modal
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="border border-secondary rounded p-2" 
                            style="max-width:900px;" 
                        
                            action="{{ route('calendar.create') }}" method="POST">
                            @csrf
							
							<input type="text" id="startDate" name="startDate" hidden >

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group ">
									    <!--
                                        <label for="title">Appointment Title:</label>
										-->
                                        <input type="text" class="form-control  " 
                                                style="margin-top:-6px;" 
                                                placeholder="Enter Appointment Title "
												onClick="titleClicked()"
                                                name ="title"
                                                id="title">
										
                                        <div class="text-danger" id="titleErrorMsg"></div>
                                               
                                    </div>
                                </div>
                            </div>
							
                           <div class="row">
                                <div class="col-12">
                                    <div class="form-group ">
									    <textarea id="details" name="details" 
										 placeholder="Enter Appointment Details (optional)"
											rows="4" >
                                        </textarea>
                                              
                                    </div>
                                </div>
                            </div>							
							
							@if ($clients)
								<div class="row">
									<div class="col-6">
										<div class="form-group ">
											<label for="client_id">Choose Client:</label>
											<select name="client_id" id="client_id" class="form-control" >
											@foreach($clients as $client )
												<option value="{{ $client->id }}">
													{{ $client->firstname}} {{ $client->lastname}}
												</option>
												@endforeach
											</select>
											
										</div>
									</div>
								</div>
							@endif							

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="button"  class="btn btn-primary"  onClick="createNewEvent()" >Submit</button>
                            </div>                
                        </form>
                    
                    </div>
                
                </div>
            </div>

            
            </div>

        </div>
        



        <div class="response alert alert-success mt-2" style="display: none;"></div>
        <div id='calendar'></div>  
    </div>

    @section('footer-scripts')
        @include('scripts.fullCalendarDates')
    @endsection

@endsection




@extends('layouts.app')  <!-- views/layouts/app.blade.php -->

@push('head')
	<!-- FullCalendar -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
  	<script src="{{ asset('js/fullcalendar.js') }}" ></script>

	<!-- For calendar tooltip -->
	<!--
	<script src="https://unpkg.com/popper.js/dist/umd/popper.min.js"></script>
	<script src="https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js"></script>
	-->
	
	
@endpush

@section('content')

    <div class="container">

        <div>
            <!-- Button trigger modal -->
            <button hidden id="btnModal" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modelCreateEvent">
                Launct #modelCreateEvent Model
            </button>

            <!-- Modal Create Event-->
            <div class="modal fade" id="modelCreateEvent" tabindex="-1" role="dialog" aria-labelledby="modelCreateEventLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modelCreateEventLabel">Create Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form style="max-width:900px;" 
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
									    <textarea id="description" name="description" 
										 placeholder="Enter Appointment Details (optional)"
										 class="form-control  " 
											rows="3" 
											
											
											>
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

							<div class="row">
								<div class="col-6">
									<div class="form-group ">
										<label for="starttime">Start Time:</label>
										<input type="time" 
												class="form-control  " 
												style="margin-top:-6px;" 
												onClick="starttimeClicked()"
												min="06:00" max="20:00" 
												required
												name ="starttime"
												id="starttime">
										
										<div class="text-danger" id="starttimeErrorMsg"></div>
												   
									</div>
								</div>
								
								<div class="col-6">
									<div class="form-group ">
										<label for="endtime">End Time:</label>
										<input type="time" 
												class="form-control  " 
												style="margin-top:-6px;" 
												onClick="endtimeClicked()"
												min="06:00" max="20:00" 
												required
												name ="endtime"
												id="endtime">
										
										<div class="text-danger" id="endtimeErrorMsg"></div>
												   
									</div>
								</div>
							
								
							
							</div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="button"  class="btn btn-primary"  onClick="createNewEvent()" >Submit</button>
                            </div>                
                        </form>
                    
                    </div>
                
                </div>
            </div>

            
            </div>

        
		<!-- Button trigger modal -->
            <button hidden id="btnEditModal" type="button" class="btn btn-primary" 
					data-toggle="modal" 
					data-target="#modelEditEvent">
                Launch Edit Model (modelEditEvent)
            </button>
			
				
		
		
            <!-- Modal Edit Event-->
            <div class="modal fade" id="modelEditEvent" tabindex="-1" role="dialog" aria-labelledby="modelEditEventLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modelEditEventLabel">Edit Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form 
                            style="max-width:900px;" 
                        
                            action="{{ route('calendar.update') }}" method="POST">
                            @csrf
							<div class="row">
                                <div class="col-12">
									Appointment for <strong><span id="client_name" name="client_name" ></span></strong>
								</div>
							</div>
							
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="form-group ">
									    <!--
                                        <label for="title">Appointment Title:</label>
										-->
                                        <input type="text" class="form-control  " 
                                                style="margin-top:-6px;" 
                                                placeholder="Enter Appointment Title "
												onClick="titleClicked()"
                                                name ="edit_title"
                                                id="edit_title">
										
                                        <div class="text-danger" id="edit_titleErrorMsg"></div>
                                               
                                    </div>
                                </div>
                            </div>
							
                           <div class="row">
                                <div class="col-12">
                                    <div class="form-group ">
									    <textarea id="edit_description" name="edit_description" 
										 placeholder="Enter Appointment Details (optional)"
										 class="form-control  " 
											rows="3" 
											
											
											>
                                        </textarea>
                                              
                                    </div>
                                </div>
                            </div>	
							
							<div class="row">
								<div class="col-4">
									Appointment Date
								</div>
								<div class="col-6">
									<input readonly type='text' class="form-control  " id="event_date" name="event_date">
								</div>
							</div>

							
							<div class="row">
								<div class="col-6">
									<div class="form-group ">
										<label for="starttime">Start Time:</label>
										<input type="time" 
												class="form-control  " 
												style="margin-top:-6px;" 
												onClick="starttimeClicked()"
												min="06:00" max="20:00" 
												required
												name ="edit_starttime"
												id="edit_starttime">
										
										<div class="text-danger" id="edit_starttimeErrorMsg"></div>
												   
									</div>
								</div>
								
								<div class="col-6">
									<div class="form-group ">
										<label for="endtime">End Time:</label>
										<input type="time" 
												class="form-control  " 
												style="margin-top:-6px;" 
												onClick="endtimeClicked()"
												min="06:00" max="20:00" 
												required
												name ="edit_endtime"
												id="edit_endtime">
										
										<div class="text-danger" id="edit_endtimeErrorMsg"></div>
												   
									</div>
								</div>
							
								
							
							</div>

							
							<div class="row">
								<div class="col-6">
									<div class="form-group ">
										<label for="edit_event_status">Status:</label>
										<!-- Options will be populated through JS code when events are fetched -->
										<select name="edit_event_status" id="edit_event_status" class="form-control" >
										</select>
									</div>
								</div>
							</div>
														

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="button"  class="btn btn-primary"  onClick="editEvent()" >Submit</button>
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




<script>

  document.addEventListener('DOMContentLoaded', function() 
  {
	

		$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});


        jQuery.ajax({
            url: "{{ url('/calendar/getEventStatusCodes') }}",
            method: 'post',
            data: {

            },
            success: function(response)
			{
				// Define Event Status options
				var $el = $("#edit_event_status");
				//$el.empty(); // remove old options
				obj = response;
				Object.keys(obj).forEach(key => {
					$el.append($("<option></option>").attr("value", obj[key]['id']).text(obj[key]['text']));
				});
				
	        
			}

       
	
	
		});
  
});






	
				function editCalendarEvent()
					{
					var title = $('#edit_title').val();
					let dataError = false;
					if (! title) 
					{
						$('#edit_title').addClass('is-invalid');
						$('#edit_titleErrorMsg').text('Please Enter Title');
						dataError = true;
					}
					
					let starttime =  $('#edit_starttime').val();
					if (typeof starttime == 'undefined' || ! starttime) 
					{
						$('#edit_starttime').addClass('is-invalid');
						$('#edit_starttimeErrorMsg').text('Please Enter Appointment Start Time');
						dataError = true;
					}
					
					let endtime =  $('#edit_endtime').val();
					if (typeof endtime == 'undefined' ||  ! endtime) 
					{
						$('#edit_endtime').addClass('is-invalid');
						$('#edit_endtimeErrorMsg').text('Please Enter Appointment End Time');
						dataError = true;
					}
					
					if (endtime <= starttime)
					{
						$('#edit_endtime').addClass('is-invalid');
						$('#edit_endtimeErrorMsg').text('End time must be less than Start time!');
						dataError = true;
					}
					
					if (dataError)  
					{
						return;
					}
					
					
					let startDate = $('#event_date').val();
					let start = startDate + ' '+starttime+':00';
					let end = startDate  + ' '+endtime+':00';
					console.log(start, end);
				
				
					// Create the event in the events table 
					jQuery.ajax({
						url: "{{ url('/calendar/update') }}",
						method: 'post',
						data: {
							"_token": "{{ csrf_token() }}",
							'title' : title,
							'startDate' : startDate,
							'event_status_id' : $('#edit_event_status').val(),
							'start' : start, 
							'end' : end,
							'description': $('#edit_description').val(),
							'note' : $('#note').val(),
						},
						success: function(response){
							if (response)
							{
								hideModal();
								displayMessage('Appointment Update Successfully.');
							}
						},
						error: function(data) {
							console.log(data);
							
						}
					});
			 
				}
						
				


			  function getEventDetails(event_id)
			  {
				 
				  
					$('#edit_title').removeClass('is-invalid');
					$('#edit_titleErrorMsg').text('');  
					$('#edit_startDate').val('');  //$('#edit_startDate').val(startDate);
					$('#edit_starttime').removeClass('is-invalid');
					$('#edit_endtime').removeClass('is-invalid');
					$('#edit_starttimeErrorMsg').text('');  
					$('#edit_endtimeErrorMsg').text(''); 
				
					jQuery.ajax({
						url: "{{ url('/calendar/getEvent') }}",
						method: 'post',
						data: {
							"_token": "{{ csrf_token() }}",
							'event_id' : event_id,
						},
						success: function(data){
							if (data)
							{
								let newLine = "\r\n";
								let event = data['event'];
								let note = data['note'];
								let formattedNote = '';
								
								if (typeof note == 'object')
								{
								
									// returned note contains array of notes containing created_by and note
									// create a string to use as val() for the current_note_element 
									note.forEach(element => formattedNote += element['created_by'] + newLine +element['note'] +newLine + newLine );
									$('#current_note').val(formattedNote);
								}
								if (formattedNote)
								{
									$('#divCurrent_note').addClass('d-block').removeClass('d-none');
								}
								else
								{
									$('#divCurrent_note').addClass('d-none').removeClass('d-block');
								}
								
								
								
								// formattedNote =note.replace('<br>',newLine);
								//return;
								let startDatetime = event.start;
								let endDatetime = event.end;
								let event_date = startDatetime.substr(0, 10);
								
								//start.substr(0, 10)
								$('#note').val('');
								$('#modelEditEventLabel').text('Edit Appointment for ' + event.firstname + ' ' + event.lastname);
								$('#edit_title').val(event.title);
								$('#edit_description').val(event.description);

								$('#edit_event_status').val(event.event_status_id);
								$('#event_date').val(event_date);
								$('#edit_starttime').val(startDatetime.substr(11,5));
								$('#edit_endtime').val(endDatetime.substr(11,5));
								$('#btnEditModal').click();
								
								
							}
						},
						error: function(data) {
							console.log(data);
							
						}
					});
			  }
			  
						






</script>
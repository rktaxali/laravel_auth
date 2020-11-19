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
			  
						

	
		function elementClicked(element)
		{
			$('#'+element).removeClass('is-invalid');
			$('#' +element+ 'ErrorMsg').text('');  
		}



		function repeatClicked()
		{
			if ($('#frequency').val())
			{
				$('#divRepeatEndDate').addClass('d-block').removeClass('d-none');
			}
			else
			{
				$('#divRepeatEndDate').addClass('d-none').removeClass('d-block');	
			}
		}
		
		

	function createNewEvent()
    {
		let title = $('#title').val();
		let eventdate = $('#eventdate').val();
		
		let client_id = $('#client_id').val();
		let eventnote = $('#eventnote').val();
		let eventType = $('#eventType').val().trim();
		let dataError = false;
		
		
		if (! title) 
		{
			$('#title').addClass('is-invalid');
			$('#titleErrorMsg').text('Please Enter Title');
			dataError = true;
		}
		
		if (! eventdate) 
		{
			$('#eventdate').addClass('is-invalid');
			$('#eventdateErrorMsg').text('Please enter Event Date');
			dataError = true;
		}
		
		if (! eventType) 
		{
			$('#eventType').addClass('is-invalid');
			$('#eventTypeErrorMsg').text('Please Select Event Type');
			dataError = true;
		}
		
		if (! eventnote) 
		{
			$('#eventnote').addClass('is-invalid');
			$('#eventnoteErrorMsg').text('Please Enter a Note');
			dataError = true;
		}		
		
		let starttime =  $('#starttime').val();
		if (typeof starttime == 'undefined' || ! starttime) 
		{
			$('#starttime').addClass('is-invalid');
			$('#starttimeErrorMsg').text('Please Enter Appointment Start Time');
			dataError = true;
		}
		
		let endtime =  $('#endtime').val();
		if (typeof endtime == 'undefined' ||  ! endtime) 
		{
			$('#endtime').addClass('is-invalid');
			$('#endtimeErrorMsg').text('Please Enter Appointment End Time');
			dataError = true;
		} 
		else if (endtime <= starttime)
		{
			$('#endtime').addClass('is-invalid');
			$('#endtimeErrorMsg').text('End time must be less than Start time!');
			dataError = true;
		}
		
		if ($('#frequency').val() && ! $('#enddate').val() )
		{
			$('#enddate').addClass('is-invalid');
			$('#enddateErrorMsg').text('Repeat Appoinatment End date is required');
			dataError = true;	
		}
		
		
		
		
		if (dataError)  
		{
			return;
		}
		
		
		 hideModal();
        //console.log(calendar);

        // calendar.currentData.dateSelection.range.start
        // calendar.currentData.dateSelection.range.end
        // Fri Nov 20 2020 19:00:00 GMT-0500 (Eastern Standard Time)

      //  let str = "Fri Nov 20 2020 19:00:00 GMT-0500 (Eastern Standard Time)";

       // let title = 'New Event Title';
       // var title = prompt('Event Title:');
        if (title) {
            hideModal();
			
			let start = eventdate + ' '+starttime+':00';
			let end = eventdate  + ' '+endtime+':00';
			
			
			// Create the event in the events table 
			jQuery.ajax({
				url: "{{ url('/calendar/create') }}",
				method: 'post',
				data: {
					
					'title' : title,
					'startDate' : eventdate,
                    'start' : start,
                    'end' : end,
					'note' : eventnote,
					'event_type_id' : eventType,
					'description' : $('#description').val(),
					'frequency' : $('#frequency').val(),
					'enddate' : $('#enddate').val(),

					
				},
				success: function(response){
					if (response)
					{
						displayMessage('Appointment Added Successfully. Pleast reload page to refresh Calendar.');
					}
				},
				error: function(data) {
					console.log(data);
					
				}
			});
                   
			
             
        }
        calendar.unselect()
    }		


</script>
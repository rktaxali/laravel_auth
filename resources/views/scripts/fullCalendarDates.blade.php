<script>

  document.addEventListener('DOMContentLoaded', function() {
	

      var user_id = "{{ $user_id}}"
	  var SITEURL = "{{url('/')}}";
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
        url = "{{ url('/calendar/getEvents') }}"


        jQuery.ajax({
            url: "{{ url('/call/getEvents') }}",
            method: 'post',
            data: {
                user_id : user_id
            },
            success: function(response)
			{
				console.log(response['events']);
				/**
				* response array returns 'events' and 'status_array'
				* 'status_array is used to creat the SELECT element for updating status of the event
				*/
				
				// Define Event Status options
				var $el = $("#edit_event_status");
				$el.empty(); // remove old options
				obj = response['status_array'];
				Object.keys(obj).forEach(key => {
					$el.append($("<option></option>").attr("value", obj[key]['id']).text(obj[key]['text']));
				});
				
				
                var calendarEl = document.getElementById('calendar');
				

                   
                    calendar = new FullCalendar.Calendar(calendarEl, {
                        headerToolbar: {
							left: 'prev,next today',
							center: 'title',
							right: 'dayGridMonth,timeGridWeek,timeGridDay'
                        },
                        initialDate: getCurrentDate(),
                        navLinks: true, // can click day/week names to navigate views
                        selectable: true,
                        selectMirror: true,
						nextDayThreshold: '00:00:00',
						
						
				
						eventDidMount: function(info) {
						  var tooltip = new Tooltip(info.el, {
							title: info.event.extendedProps.description,
							placement: 'top',
							trigger: 'hover',
							container: 'body'
						  });
						},
					
						
						
						
                        select: function(dateOrObj, endDate) 
                        {
							addEvent(dateOrObj.startStr);
                        


                        },
						

                        eventClick: function(info) {
							getEventDetails( info.event.id);
						},
						
						
					

                        editable: true,
                        dayMaxEvents: true, // allow "more" link when too many events

                        events: response['events']
                    });




                calendar.render();
	        
            }}); 

       
	
	
  });
  
  
  function getEventDetails(event_id)
  {
	  
		$('#edit_title').removeClass('is-invalid');
		$('#edit_titleErrorMsg').text('');  
		$('#edit_startDate').val(startDate);
		$('#edit_starttime').removeClass('is-invalid');
		$('#edit_endtime').removeClass('is-invalid');
		$('#edit_starttimeErrorMsg').text('');  
		$('#edit_endtimeErrorMsg').text('');  
	  
	  
		// get Event Details for the passed event_id 
		
		/*
			client_id: 6
			color: "orange"
			created_at: "2020-11-08 19:08:58"
			details: null
			end: "2020-11-13 10:00:00"
			event_status_id: 5
			firstname: "Andrew"
			id: 17
			lastname: "Lee"
			start: "2020-11-13 09:00:00"
			status: "Transferred"
			title: "Meet Brian for Medication Delivery"
			updated_at: "2020-11-09 07:54:56"
			user_id: 2
		*/
		jQuery.ajax({
			url: "{{ url('/calendar/getEvent') }}",
			method: 'post',
			data: {
				
				'event_id' : event_id,
			},
			success: function(event){
				if (event)
				{
					console.log(event);
					//return;
					let startDatetime = event.start;
					let endDatetime = event.end;
					let event_date = startDatetime.substr(0, 10);
					
					//start.substr(0, 10)
					
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
  
  

  function displayMessage(message) 
  {
        $(".response").css('display','block');
        $(".response").html(""+message+"");
        setInterval(function() { $(".response").fadeOut(); }, 4000);
  }

  function addEvent(startDate)
  {
		// Adding a new event. Details entered through a model box
		$('#title').val('');
		$('#description').val('');
		$('#title').removeClass('is-invalid');
		$('#titleErrorMsg').text('');  
		$('#startDate').val(startDate);
		$('#starttime').removeClass('is-invalid');
		$('#endtime').removeClass('is-invalid');
		$('#starttimeErrorMsg').text('');  
		$('#endtimeErrorMsg').text('');  
		
		
		// open modal box 
		 $('#btnModal').click();
	}

  function titleClicked()
  {
	$('#title').removeClass('is-invalid');
	$('#titleErrorMsg').text('');  
  }
  
  
  function starttimeClicked()
  {
	$('#starttime').removeClass('is-invalid');
	$('#starttimeErrorMsg').text('');  
  }
  
  
  function endtimeClicked()
  {
	$('#endtime').removeClass('is-invalid');
	$('#endtimeErrorMsg').text('');  
  }
  
  
  function createNewEvent()
    {
		var user_id = "{{ $user_id}}"
		var title = $('#title').val();
		let client_id = $('#client_id').val();
		let dataError = false;
		
		
		if (! title) 
		{
			$('#title').addClass('is-invalid');
			$('#titleErrorMsg').text('Please Enter Title');
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
		
		if (endtime <= starttime)
		{
			$('#endtime').addClass('is-invalid');
			$('#endtimeErrorMsg').text('End time must be less than Start time!');
			dataError = true;
		}
		
		if (dataError)  
		{
			return;
		}
		
		
		let startDate = $('#startDate').val();
		$('#title').val('');
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
			
			let start = startDate + ' '+starttime+':00';
			let end = startDate  + ' '+endtime+':00';
			

			// Add the event on calendar
            calendar.addEvent({
                title: title,
                start: start,
                end: end ,
				

                allDay: false
            })
			
			// Create the event in the events table 
			jQuery.ajax({
				url: "{{ url('/calendar/create') }}",
				method: 'post',
				data: {
					
					'title' : title,
                    'start' : start,
                    'end' : end,
					'client_id' : client_id,
					'description' : $('#description').val(),
					'user_id': "{{ $user_id}}"
				},
				success: function(response){
					if (response)
					{
						displayMessage('Appointment Added Successfully.');
					}
				},
				error: function(data) {
					console.log(data);
					
				}
			});
                   
			
             
        }
        calendar.unselect()
    }
	
	function editEvent()
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
				
				'title' : title,
				'event_status_id' : $('#edit_event_status').val(),
				'start' : start, 
				'end' : end,
				'description': $('#edit_description').val(),
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

	

</script>

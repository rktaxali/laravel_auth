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
            success: function(events){
                var calendarEl = document.getElementById('calendar');

                    /* 
                                    var calendar = new FullCalendar.Calendar(calendarEl, {
                                            initialDate: getCurrentDate(),
                                            editable: true,
                                            selectable: true,
                                            businessHours: true,
                                            dayMaxEvents: true, // allow "more" link when too many events
                                            events: events
                                        });
                    */

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
						/*
						month: '2-digit',
						year: 'numeric',
						day: '2-digit',
						hour: '2-digit',
						minute: '2-digit',
						*/
										
						
						
                        select: function(dateOrObj, endDate) 
                        {
							addEvent(dateOrObj.startStr);
                        


                        },
						

                        eventClick: function(arg) {
                            if (confirm('Are you sure you want to delete this event?')) {
                                arg.event.remove()
                            }
                        },
						
						
					

                        editable: true,
                        dayMaxEvents: true, // allow "more" link when too many events

                        events: events
                    });




                calendar.render();
	        
            }}); 

        /* 
        var events = [
            
            {
            title: 'Conference',
            start: '2020-09-11',
            end: '2020-09-13'
            },
    
            {
            title: 'Click for Google',
            url: 'http://google.com/',
            start: '2020-09-28'
            }
        ];

    */

	
	
  });
  
  

  function displayMessage(message) 
  {
        $(".response").css('display','block');
        $(".response").html(""+message+"");
        setInterval(function() { $(".response").fadeOut(); }, 4000);
  }

  function addEvent(startDate)
  {
		// Adding a new event. Details entered through a model box
		$('#startDate').val(startDate);
		// open modal box 
		 $('#btnModal').click();
	}

  function titleClicked()
  {
	$('#title').removeClass('is-invalid');
	$('#titleErrorMsg').text('');  
  }
  
  
  function createNewEvent()
    {
		var user_id = "{{ $user_id}}"
		var title = $('#title').val();
		let client_id = $('#client_id').val();
		if (! title) 
		{
			$('#title').addClass('is-invalid');
			$('#titleErrorMsg').text('Please Enter Title');
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
			
			let start = startDate + 'T09:00:00';
			let end = startDate +'T10:00:00';
			

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

  

</script>

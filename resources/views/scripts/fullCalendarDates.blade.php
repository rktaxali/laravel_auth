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
                var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialDate: getCurrentDate(),
                        editable: true,
                        selectable: true,
                        businessHours: true,
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
  

</script>

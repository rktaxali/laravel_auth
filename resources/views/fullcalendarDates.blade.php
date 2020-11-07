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
        <div class="response alert alert-success mt-2" style="display: none;"></div>
        <div id='calendar'></div>  
    </div>

    @section('footer-scripts')
        @include('scripts.fullCalendarDates')
    @endsection

@endsection




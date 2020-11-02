@extends('layouts.app')  <!-- views/layouts/app.blade.php -->

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2>Housing</h2>
        </div>
    </div>

    <div class = "row ">
        <div class="col-12 ">
            
            @if ( count($housings)  )
                <form id="housings-form"
                    action="{{ route('permission.store') }}" method="POST">
                                @csrf
                        <table class="table table-bordered table-responsive-lg">
                            <tr>
                                <th>Address</th>
                                <th>Availability Status</th>
                                <th>Client</th>
                                <th>Start Date</th>
                                <th>Action</th>
                            </tr>

                            @foreach ($housings as $housing)
                                <tr>
                                    <td>
                                        {{ $housing->address }}<br>
                                        {{ $housing->city }}, {{ $housing->province }} - {{ $housing->postalcode }}
                                    </td>
                                    
                                    <td>
                                         {{ $housing->availability_status }}   
                                    </td>

                                    <td>
                                        {{ $housing->client_name }}
                                    </td>
                                    <td>
                                    {{ $housing->start_date }}    
                                    </td>
                                    <td>
                                             
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </table>

                        <div class="row mt-4" >
                                <button
                                    id="submitButton"
                                     type="button" 
                                        onClick="submitForm()"
                                        class="btn btn-primary ml-3">
                                    Submit
                                </button>

                                <div id="spinner" class="spinner-border text-primary ml-2" style="visibility:hidden"></div>

                                <a href="/home"  class="ml-4">
                                    <button type="button" 
                                            class="btn btn-secondary"  >
                                        Cancel
                                    </button>
                                </a>
                    </div>
                </form>
            @endif
     
        </div>

    </div>
 
</div>

@endsection


<script>
    function submitForm() {
        // disable Submit button
        event.preventDefault();
        var element = document.getElementById("submitButton");
        element.disabled = true;
        // display spinner and submit form
        var element = document.getElementById("spinner");
        element.style.visibility='visible';
        document.getElementById('housings-form').submit();
    }

</script>


@extends('layouts.app')

@section('content')

<div class="container">
    <h3> Notes Re. {{$client_name}}</h3>

    @if ( count($notes)  )
        <!-- Notes -->
        <div class='row mt-4'>
      
            <div class="col-12">
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-success">
                            <th scope="col">Note</th>
                            <td scope="col">Created</td>
                           
                        </tr>
                    </thead>
                    @foreach ($notes as $note)
                        <tr>
                            <td>{!! $note->note !!}
                                <br> 
                                <a href="/client/noteEdit/{{$note->id}}" class="nav-link">
                                    <span class="material-icons">edit</span>
                                </a>
                            </td>
                            <td>{{ $note->created_at }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <div class="row ">
            <div class="col-8">
                        {{ $notes->links() }}
            </div>
        </div>    

        <div class="row">
            <div class="col-8">
                <a href="/client/show/{{$client_id}}">Back to Client</a>
            </div>
        </div>
    

    @else
            <p>There are no notes for the Client</p>
    @endif
    <div class="row">
            <div class="col-8">
                 <a href="/client/noteCreate">Add a Note</a>
            </div>
    </div>
</div>
@endsection

@extends('layouts.app')  <!-- views/layouts/app.blade.php -->

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
    
                        <div class="row">
                            <form action="{{ route('home.post') }}" method="POST">
                                
                                @csrf
                                

                                @if ($allClients)
                                    <input hidden type="checkbox" name='allClients' id='allClients' >
                                    <button type="submit" 
                                        class="btn btn-primary"
                                        title="Show My Clients" >
                                        Show My Clients
                                    </button>
                                @else
                                    <input hidden type="checkbox" name='allClients' id='allClients' checked>
                                    <button type="submit" 
                                        class="btn btn-primary"
                                        title="Show My Clients" >
                                        Show All Clients
                                    </button>
                                @endif
                                
                            </form>

                        </div>


                        <div class="row mt-2">
                            <form action="{{ route('home.post') }}" method="POST">
                                @csrf
                                @if ($allClients)
                                    <input hidden type="checkbox" name='allClients' id='allClients'  checked >
                                @else
                                    <input hidden type="checkbox" name='allClients' id='allClients' >
                                @endif

                                <div class="input-group">
                                    <input type="text" 
                                            class="form-control mr-2" 
                                            placeholder="Search Client in list" 
                                            name="searchText" 
                                            id="searchText"
                                            value="{{ $searchText}}"
                                        >
                                        <span class="input-group-btn">
                                            <button class="btn btn-danger" type="submit" title="Refresh page">
                                                <span class="fas fa-sync-alt"></span>
                                            </button>
                                        </span>
                                </div>
                            </form>
                        </div>

                        <div class="row mt-2">
                        <a href="{{ route('client.create')}}" class="btn btn-secondary">Create New Client</a>
                        </div>                       

                        <div class='mt-4'>
                            @if ( count($clients)  )
                                @if ($allClients)
                                    <strong>All Clients List  @if($searchText)  matching  {{ $searchText}} @endif   </strong>
                                @else
                                    <strong>Your Clients List  @if($searchText)  matching  {{ $searchText}} @endif </strong>  
                                @endif
                                <table class="table table-bordered table-responsive-lg">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                    </tr>

                                    @foreach ($clients as $client)
                                        <tr>
                                            <td>{{ $client->id}}</td>
                                            <td> <a href="/client/show/{{$client->id}}"> {{ $client->firstname }} {{ $client->lastname}} </a>  </td>
                                            <td>{{ $client->address }}, {{ $client->city }}</td>
                                            <td >{{ $client->phone }}</td>
                                            
                                        </tr>
                                    @endforeach
                                </table>
                            @else
                                    <p>No clients for the user</p>
                            @endif
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

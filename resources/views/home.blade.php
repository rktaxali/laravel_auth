@extends('layouts.app')

@section('content')

<x-header name="Raga" :fruit="$fruit" />

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
                   
                    @if (Auth::user())
                        {{ __('You are logged in!') }}
                        {{Auth::user()->name}}
                        {{ auth()->user()->email}}
                    @else
                        <p>You are not logged-in.</p>
                        <a href="/login">Login</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

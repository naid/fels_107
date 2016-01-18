@extends('app')

@section('title')
    @if (auth()->guest())
        Welcome!
    @endif
    @if (auth()->check())
        Welcome {{ $title }}!
    @endif
@endsection

@section('content')
    @if (auth()->check())
        @if ($user->isAdmin())
            Admin
        @endif
            <div class="panel-heading">Dashboard</div>
            <div class="panel-body">
                <div class="col-md-3">
                    <h4 align="center">{{ auth()->user()->name }} </h4>
                </div>
                <div class="col-md-9">
                    <a href="{{ url('/words') }}" class="btn btn-default btn-lg" role="button">Word</a>
                    <a href="{{ url('/categories') }}" class="btn btn-default btn-lg" role="button">Lesson</a>
                    <h2>Activities</h2>
                    <hr>
                </div>
            </div>
    @endif
@endsection

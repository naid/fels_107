@extends('app')

@section('title')
    {{ trans('common.users.home.panel_label') }}
@endsection

@section('content')
            <div class="panel-heading">Dashboard</div>
            <div class="panel-body">
                <div class="col-md-3">
                    <h4 align="center">{{ $user->email }} </h4>
                </div>
                <div class="col-md-9">
                    <a href="{{ url('/words') }}" class="btn btn-default btn-lg" role="button">Word</a>
                    <a href="{{ url('/categories') }}" class="btn btn-default btn-lg" role="button">Lesson</a>
                    <h2>Activities</h2>
                    <hr>
                </div>
            </div>
@endsection

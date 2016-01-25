@extends('app')
@section('title')
    {{ $title }}
@endsection
@section('content')
    {!! Form::open(['method' => 'post', 'route' => 'categories.store', 'files' => 'true']) !!}
        {{ csrf_field() }}
        <div class="form-group">
            {!! Form::text('category_name', '', [
                'required' => 'required',
                'placeholder' => 'Enter title here',
                'class' => 'form-control'])
            !!}
            {!! Form::file('category_image') !!}
        </div>
        <div class="form-group">
            {!! Form::textarea('category_desc', '', [
                'required' => 'required',
                'class' => 'form-control'])
            !!}
        </div>
        {!! Form::submit('Add Category') !!}
    {!! Form::close() !!}
@endsection

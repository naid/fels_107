@extends('app')
@section('title')
    {{ $title }}
@endsection
@section('content')
    {!! Form::open(['method' => 'post', 'route' => 'words.store', 'files' => 'true']) !!}
        {{ csrf_field() }}
        <div class="form-group">
            {!! Form::label('category', 'Word Category') !!}
            {!! Form::select('category', $categories) !!}
        </div>
        <div class="form-group">
            <table>
                <tr>
                    <td>
                        {!! Form::text('word', null, ['placeholder' => 'Word']) !!}
                        {!! Form::file('sound') !!}
                        {!! Form::text('meaning', null, ['placeholder' => 'Meaning']) !!}
                    </td>
                    <td>
                        Add options <br />
                        {!! Form::text('option1', null, ['placeholder' => 'Option 1']) !!} <br />
                        {!! Form::text('option2', null, ['placeholder' => 'Option 2']) !!} <br />
                        {!! Form::text('option3', null, ['placeholder' => 'Option 3']) !!}
                    </td>
                </tr>
            </table>
        </div>
        {!! Form::submit('Save') !!}
    {!! Form::close() !!}
    {!! link_to_route('words.index', 'Cancel') !!}
@endsection

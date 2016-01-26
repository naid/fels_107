@extends('app')
@section('title')
    {{ $title }}
@endsection
@section('content')
    {!! Form::open(['method' => 'patch', 'route' => ['words.update', $word->id], 'files' => 'true']) !!}
        <table>
            <tr>
                <td>
                    Category: <b>{!! Form::select('category', $category, $word->category->id) !!}</b>
                </td>
                <td>
                    Options:
                </td>
            </tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td>Word:</td>
                            <td>
                                {!! Form::text('word', $word->word,
                                    ['required' => 'required',
                                    'placeholder' => 'Enter word here',
                                    'class' => 'form-control'])
                                !!}
                            </td>
                        </tr>
                        <tr>
                            <td>Meaning:</td>
                            <td>
                                {!! Form::text('meaning', $word->meaning,
                                    ['required' => 'required',
                                    'placeholder' => 'Enter meanning here',
                                    'class' => 'form-control'])
                                !!}
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                @foreach ($options as $index => $option)
                    {!! Form::text('option' . ($index + 1), $option, [
                        'required' => 'required',
                        'placeholder' => 'Option ' . ($index + 1),
                        'class' => 'form-control'])
                    !!}
                @endforeach
                </td>
            </tr>
            <tr>
                <td colspan='2'>
                    <audio controls>
                        <source src="{{ url('audio/words/' . $word->sound) }}" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </td>
            </tr>
            <tr>
                <td>
                    {!! Form::file('sound') !!}
                </td>
            </tr>
        </table>
        {!! Form::submit('Save') !!}
    {!! Form::close() !!}
    {!! link_to('words', 'Back') !!}
@endsection

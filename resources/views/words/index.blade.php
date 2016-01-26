@extends('app')
@section('title')
    {{ $title }}
@endsection
@section('content')
    @if ($user->isAdmin())
        <p>
            {!! link_to_route('words.create', 'Add new word') !!}
        </p>
    @endif
    @foreach ($words as $word)
    <div class="list-group">
        <div class="list-group-item">
            <table>
                <tr>
                    <td>Category: <b>{{ $word->category->name }}</b></td>
                </tr>
                <tr>
                    <td>{{ $word->word }} : {{ $word->meaning }}</td>
                </tr>
                <tr>
                    <td>
                        <audio controls>
                            <source src="{{ url(config()->get('paths.word_sound') . $word->sound) }}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    </td>
                </tr>
            </table>
        @if ($user->isAdmin())
            <p>
                {!! link_to_route('words.edit', 'Edit', [$word->id]) !!}
                {!! Form::open(['method' => 'delete', 'route' => ['words.destroy', $word->id]]) !!}
                    {!! Form::submit('Delete') !!}
                {!! Form::close() !!}
            </p>
        @endif
        </div>
    </div>
    @endforeach
    {{ $words->render() }}
@endsection

@extends('app')
@section('title')
    {{ $title }} for {{ $category }}
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="panel-body">
            <div class="col-md-10">
                <div class="panel-body">
                    <table>
                        <tr>
                            <td>Result</td>
                            <td>Word</td>
                            <td>Meaning</td>
                            <td>Your Answer</td>
                            <td>Audio</td>
                        </tr>
                        @foreach($lessonWords as $lessonWord)
                        <tr>
                            <td>{{ $lessonWord->result }}</td>
                            <td>{{ $lessonWord->word->word }}</td>
                            <td>{{ $lessonWord->word->meaning }}</td>
                            <td>{{ $lessonWord->answer }}</td>
                            <td>
                                <audio controls>
                                    <source src="{{ url(config()->get('paths.word_sound') .
                                    $lessonWord->word->sound) }}"
                                    type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

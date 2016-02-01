@extends('app')
@section('title')
    {{ $title }}
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="panel-heading">Question # {{ (session()->get('questionIndex') + 1) }} for {{ $user->name }}</div>
        <div class="panel-body">
            <div class="col-md-10">
                <div class="panel-body">
                    <div class="col-md-6">
                        <b><h1>{{ $questions[session()->get('questionIndex')]->word->word }}</h1></b>
                        <p>
                            <audio controls>
                                <source src="{{ url(config()->get('paths.word_sound') .
                                $questions[session()->get('questionIndex')]->word->sound) }}"
                                type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        </p>
                    </div>
                    <div class="col-md-6">
                        @foreach ($options as $index => $option)
                            {!! Form::open(['method' => 'post', 'route' => 'exam']) !!}
                                {!! Form::hidden('lesson', session()->get('lessonId')) !!}
                            {!! Form::hidden('answer', $option) !!}
                            {!! Form::hidden('lesson_word_id',
                                $questions[ session()->get('questionIndex')]->id) !!}
                            {!! Form::submit($option, [
                               'class' => 'btn btn-default btn-block'
                            ]) !!}
                        {!! Form::close() !!}
                        </br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

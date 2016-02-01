@extends('app')
@section('title')
    {{ $title }}
@endsection
@section('content')
    @foreach ($categories as $category)
    <div class="list-group">
        <div class="list-group-item">
            <table>
                <tr>
                    <td rowspan ='3' colspan='1'>
                        <p>
                            {!! Html::image(config()->get('paths.category_image') . $category->image, $category->name,
                                ['class' => 'thumbnail'])
                            !!}
                        </p>
                    </td>
                    <td>
                         <p><h3><u>{{ $category->name }}</u></h3> (No. of Words added to this category: {{ $category->getCountWords() }})</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>{{ $category->description }}</p>
                    </td>
                </tr>
            @if ($category->getCountWords())
                <tr>
                    <td>
                        {!! Form::open(['method' => 'post', 'route' => 'lessons.store']) !!}
                            {!! Form::hidden('category_id', $category->id) !!}
                            {!! Form::submit('Start Lesson') !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endif
            </table>
        </div>
    </div>
    @endforeach
@endsection

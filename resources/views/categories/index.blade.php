@extends('app')
@section('title')
    {{ $title }}
@endsection
@section('content')
    @if ($user->isAdmin())
        <p>
            {!! link_to_route('categories.create', 'Create new category') !!}
        </p>
    @endif
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
            @if ($user->isAdmin())
                <tr>
                    <td>
                        {!! link_to_route('categories.edit', 'Edit', [$category->id]) !!}
                        {!! Form::open(['method' => 'delete', 'route' => ['categories.destroy', $category->id]]) !!}
                            {!! Form::submit('Delete') !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endif
            </table>
        </div>
    </div>
    @endforeach
@endsection

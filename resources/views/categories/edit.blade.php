@extends('app')
@section('title')
    {{ $title }}
@endsection
@section('content')
    {!! Form::open(['method' => 'patch', 'route' => ['categories.edit', $category->id], 'files' => 'true']) !!}
        <table>
            <tr>
                <td rowspan='3'>
                    {!! Html::image(config()->get('paths.category_image') . $category->image, $category->name,
                        ['class' => 'thumbnail'])
                    !!}
                </td>
                <td>
                    {!! Form::text('category_name', $category->name, [
                        'required' => 'required',
                        'placeholder' => 'Enter title here',
                        'class' => 'form-control'])
                    !!}
                </td>
            </tr>
            <tr>
                <td>
                    {!! Form::textarea('category_desc', $category->description, [
                        'required' => 'required',
                        'class' => 'form-control'])
                    !!}
                </td>
            </tr>
            <tr>
                <td>
                    {!! Form::file('category_image') !!}
                </td>
            </tr>
        </table>
        {!! Form::submit('Save') !!}
    {!! Form::close() !!}
    {!! link_to('categories', 'Back') !!}
@endsection

@extends('app')
@section('title')
    {{ $title }} BOYGHUIOJPKL
@endsection
@section('content')
    {!! Form::open(['method' => 'patch', 'route' => ['users.update.password', $user->id], 'files' => 'true']) !!}
        <table>
            <tr>
                <td >
                    {!! Form::label('avatar', '') !!}
                </td>
                <td>
                    {!! Html::image(config()->get('paths.user_image') . $user->avatar, $user->name,
                        ['class' => 'thumbnail'])
                    !!}
                </td>
            </tr>
            <tr>
                <td >
                    {!! Form::label('name', '') !!}
                </td>
                <td>
                    {!! Form::label('user_name', $user->name) !!}
                </td>
            </tr>
            <tr>
                <td >
                    {!! Form::label('user_password', 'Original Password') !!}
                </td>
                <td>
                    {!! Form::text('user_password', '', [
                        'class' => 'form-control'])
                    !!}
                </td>
            </tr>
            <tr>
                <td >
                    {!! Form::label('new_password', 'New Password') !!}
                </td>
                <td>
                    {!! Form::text('new_password', '', [
                        'class' => 'form-control'])
                    !!}
                </td>
            </tr>
            <tr>
                <td >
                    {!! Form::label('new_password_confirmation', 'Confirm Password') !!}
                </td>
                <td>
                    {!! Form::text('new_password_confirmation', '', [
                        'class' => 'form-control'])
                    !!}
                </td>
            </tr>
        </table>
        {!! Form::submit('Save') !!}
    {!! Form::close() !!}
    {!! link_to('home', 'Back') !!}
@endsection

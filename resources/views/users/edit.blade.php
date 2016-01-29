@extends('app')
@section('title')
    {{ $title }}
@endsection
@section('content')
    {!! Form::open(['method' => 'patch', 'route' => ['users.update'], 'files' => true]) !!}
        <table>
            <tr>
                <td >
                    {!! Form::label('avatar', '') !!}
                </td>
                <td>
                    {!! Html::image(config()->get('paths.user_image') . $user->avatar, $user->name,
                        ['class' => 'thumbnail'])
                    !!}
                    {!! Form::file('user_avatar') !!}
                </td>
            </tr>
                <td >
                    {!! Form::label('user_name', 'Name') !!}
                </td>
                <td>
                    {!! Form::text('user_name', $user->name, [
                        'required' => 'required',
                        'placeholder' => 'Enter name here',
                        'label' => 'Name',
                        'class' => 'form-control'])
                    !!}
                </td>
            </tr>
            <tr>
                <td >
                    {!! Form::label('user_email', 'Email') !!}
                </td>
                <td>
                    {!! Form::text('user_email', $user->email, [
                        'required' => 'required',
                        'class' => 'form-control'])
                    !!}
                </td>
            </tr>
            <tr>
                <td >
                    &nbsp;
                </td>
                <td>
                    {!! link_to_route('users.change.password', 'Change Password') !!}
                </td>
            </tr>
        </table>
        {!! Form::submit('Save') !!}
    {!! Form::close() !!}
    {!! link_to('home', 'Back') !!}
@endsection

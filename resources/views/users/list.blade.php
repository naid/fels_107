@extends('app')

@section('title')
    {{ trans('common.users.list_users_title') }}
@endsection

@section('content')
    <div class="panel-body">
        <div class="col-md-12">
            <h2>{{ trans('common.users.available_users') }}</h2>
    {!! Form::open(['method' => 'get', 'route' => ['users.filter']]) !!}
        {!!
            Form::text('user')
        !!}
        {!! Form::radio('status', 'followed', $status == App\Word::STATUS_LEARNED) !!}
        {!! Form::label('followed', 'Followed') !!}
        {!! Form::radio('status', 'notfollowed', $status == App\Word::STATUS_UNLEARNED) !!}
        {!! Form::label('notfollowed', 'Not Followed') !!}
        {!! Form::radio('status', 'all', $status == App\Word::STATUS_ALL) !!}

        {!! Form::label('all', 'All') !!}
        {!! Form::submit('Filter') !!}
    {!! Form::close() !!}
            <table class="col-md-12">
                <thead>
                    <tr>
                        <th class="col-md-3">&nbsp;</th>
                        <th class="col-md-2">Name</th>
                        <th class="col-md-3">Email</th>
                        <th class="col-md-2">Followers</th>
                        <th class="col-md-2">Following</th>
                        <th class="col-md-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usersList as $followedUser)
                        @if (!($followedUser->isAdmin()))
                        <tr>
                            <td>
                                {!! Html::image(config()->get('paths.user_image') . $followedUser->avatar,
                                    $followedUser->name, [
                                        'class' => 'thumbnail'
                                    ])
                                !!}
                            </td>
                            <td>
                                {{ $followedUser->name }}
                            </td>
                            <td>
                                {{ $followedUser->email }}
                            </td>
			     @if (!($user->isAdmin()))
                            <td>
                                {{ count($followedUser->followees) }}
                            </td>
                            <td>
                                {{ count($followedUser->followers) }}
                            </td>
                            <td>
                                @if (in_array($followedUser->id, $follows))
                                    {!! link_to_route('user.unfollow',
                                        trans('common.users.unfollow'),
                                        $followedUser->id )
                                    !!}
                                @else
                                    {!! link_to_route('user.follow',
                                        trans('common.users.follow'),
                                        $followedUser->id )
                                    !!}
                                @endif
                            </td>
                            @else
                            <td>

                                {!! link_to('users/show/' . $followedUser->id,'View') !!}
                            </td>
                            @endif
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <hr>
        </div>
    </div>
@endsection

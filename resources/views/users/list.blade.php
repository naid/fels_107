@extends('app')

@section('title')
    {{ trans('common.users.list_users_title') }}
@endsection

@section('content')
    <div class="panel-body">
        <div class="col-md-12">
            <h2>{{ trans('common.users.available_users') }}</h2>
            <table class="col-md-12">
                <thead>
                    <tr>
                        <th class="col-md-3">&nbsp;</th>
                        <th class="col-md-1">&nbsp;</th>
                        <th class="col-md-2">Name</th>
                        <th class="col-md-3">Email</th>
                        <th class="col-md-1">&nbsp;</th>
                        <th class="col-md-2">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usersList as $followedUser)
                        <tr>
                            <td>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="panel-body text-center">
                                            {!! Html::image(
                                                config()->get('paths.user_image') . $followedUser->avatar,
                                                $followedUser->name,
                                                ['class' => 'thumbnail'])
                                            !!}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                &nbsp;
                            </td>
                            <td>
                                {{ $followedUser->name }}
                            </td>
                            <td>
                                {{ $followedUser->email }}
                            </td>
                            <td>
                                &nbsp;
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
        </div>
    </div>
@endsection

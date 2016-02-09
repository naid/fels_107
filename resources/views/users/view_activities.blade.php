@extends('app')

@section('title')
    {{ trans('common.users.activities') }}
@endsection
@section('content')
    <div class="panel-body">
        <div class="col-md-12">
            <table class="col-md-12">
                @if (count($activities) == App\Activity::NO_ACTIVITY)
                    <tr><td>No Activities Found</td></tr>
                @else
                <thead>
                    <tr>
                        <th class="col-md-2">Date</th>
                        <th class="col-md-2">User</th>
                        <th class="col-md-1">Followers</th>
                        <th class="col-md-1">Following</th>
                        <th class="col-md-6">Activity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($activities as $activity)
                        <tr>
                            <td>{{ $activity->created_at }}</td>
                            <td>
                                <span>
                                    <a href="{{ URL::to('users/show/' . $activity->user->id) }}">
                                        {!! Html::image(config()->get('paths.user_image') . $activity->user->avatar,
                                            $activity->user->name, [
                                                'class' => 'thumbnail',
                                                'title' => $activity->user->name,
                                                'alt' => $activity->user->name
                                            ])
                                        !!}
                                    </a>
                                </span>
                            </td>
                            <td>{{ count($activity->user->followees) }}</td>
                            <td>{{ count($activity->user->followers) }}</td>
                            <td>{{ $activity->activity }}</td>
                        </tr>
                    @endforeach
                </tbody>
                @endif
            </table>
            <hr>
        </div>
    </div>
@endsection

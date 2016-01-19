@if (Session::has('message'))
    <div class="flash alert-info">
        <p class="panel-body">
            {{ Session::get('message') }}
        </p>
    </div>
@endif
@if ($errors->any())
    <div class='flash alert-danger'>
        <ul class="panel-body">
            @foreach ( $errors->all() as $error )
                <li>
                    {{ $error }}
                </li>
            @endforeach
        </ul>
    </div>
@endif

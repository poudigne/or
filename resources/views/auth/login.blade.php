@extends('../layout')

@section('title', 'Page Title')

@section('content')

@if (count($errors) > 0)
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
    <div class="row">
        <div class="col-sm-4 col-sm-offset-4">
            <form method="post">
                <div class="form-group">
                        <label for="email">Email</label>
                        <input name="email" type="text" class="form-control" data-validation="required email" placeHolder="email"/>
                </div>
                <div class="form-group">
                        <label for="password">Password</label>
                        <input name="password" type="password" class="form-control" data-validation="required" placeHolder="password"/>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group">
                        <button type="submit" class="btn btn-primary">Log in</button>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">

        $.validate();
    </script>
@stop 
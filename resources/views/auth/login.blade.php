@extends('layout')

@section('title', 'Page Title')

@section('content')

@if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
<form method="post">
<input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="row">
        <div class="col s6">
            <input name="email" type="text" class="form-control" placeHolder="email"/>
        </div>
    </div>
    <div class="row">
        <div class="col s6">
            <input name="password" type="password" class="form-control" placeHolder="password"/>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Log in</button>
</form>
@stop
@extends('layout')

@section('title', 'Page Title')

@section('content')

    @if ((session('error') && session('error') == "success"))
    <script type="text/javascript">
        toastr["success"]("The song has been successfuly submitted !","Success !");
    </script>
    @elseif (session('error') && session('error') != "success")
    <script type="text/javascript">
        toastr["error"]("{{ session('error') }}","Error !");
    </script>
    @endif
    <h2 class="header">Suggest new music</h2>
    <div class="bs-callout bs-callout-warning hidden">
        <h4>Oh snap!</h4>
        <p>This form seems to be invalid :(</p>
    </div>

    <div class="bs-callout bs-callout-info hidden">
        <h4>Yay!</h4>
        <p>Everything seems to be ok :)</p>
    </div>
    <form method="post" action="{{ route('save-suggestion') }}" files="true" id="music-suggest-form" enctype="multipart/form-data">
        
        <div class="form-group"><p>
            <label for="inputMusicTitle">* Song title</label>
            <input id="inputMusicTitle" name="song_title" type="text" data-validation="required" class="form-control" placeHolder="Enter the song's title"/>
        </p></div>
        <div class="form-group"><p>
            <label for="inputMusicBand">* Band </label>
            <input id="inputMusicBand" name="band_name" type="text" data-validation="required"  class="form-control" placeHolder="Enter the band's name"/>
        </p></div>
        <div class="form-group"><p>
            <label for="musicstyle">* Song style</label>
            <select id="musicstyle" name="music_style" class="form-control">
                @foreach ($music_style as $style)
                    <option value="{{ $style->id }}">{{ $style->name }}</option>
                @endforeach
            </select>
        </p></div>
        <div class="form-group"><p>
            <label for="songFile">* Song file (mp3)</label>
            <input type="file" id="songFile" name="song_file" data-validation="size mime required" data-validation-allowing="mp3" data-validation-max-size="15M" data-validation-error-msg-required="No file selected">
        </p></div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
    </form>
    <script type="text/javascript">

        $.validate({
            modules : 'file'
        });
    </script>
@stop

@extends('layout')

@section('title', 'Page Title')

@section('content')
    @if (isset($success) && $success == '1')
    <script type="text/javascript">
        Materialize.toast('Music suggested successfuly!', 4000);
    </script>
    @elseif (isset($success) && $success != '1')
    <script type="text/javascript">
        Materialize.toast('An error occured \n ' + {{ $success }}, 4000);
    </script>
    @endif
    <h2 class="header">Suggest new music</h2>
    <form method="post" action="save-suggestion" files="true" enctype="multipart/form-data">
        
        <div class="form-group">
            <label for="inputMusicTitle">* Song title</label>
            <input id="inputMusicTitle" name="song_title" type="text" class="form-control" placeHolder="Enter the song's title"/>
        </div>
        <div class="form-group">
            <label for="inputMusicBand">* Band </label>
            <input id="inputMusicBand" name="band_name" type="text" class="form-control" placeHolder="Enter the band's name"/>
        </div>
        <div class="form-group">
            <label for="musicstyle">* Song style</label>
            <select id="musicstyle" name="music_style" class="form-control">
                @foreach ($music_style as $style)
                    <option value="{{ $style->id }}">{{ $style->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="songFile">* Song file (mp3)</label>
            <input type="file" id="songFile" name="song_file">
            <p class="help-block">*.mp3 only</p>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
    </form>
    
    

@stop

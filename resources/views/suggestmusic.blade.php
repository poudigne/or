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
    <div class="row">

        <div class="col-lg-4" style="float: none; margin:0 auto !important">
            <h2 class="header">Suggest new music</h2>

            <form method="post" action="{{ route('save-suggestion') }}" files="true" id="music-suggest-form" enctype="multipart/form-data">
                
                <div class="form-group">
                    <label for="inputMusicTitle">* Song title</label>
                    <input id="inputMusicTitle" name="song_title" type="text" data-validation="required" class="form-control" placeHolder="Enter the song's title"/>
                </div>

                <div class="form-group">
                    <label for="inputMusicBand">* Band / Artiste</label>
                    <input id="inputMusicBand" name="band_name" type="text" data-validation="required"  class="form-control" placeHolder="Enter the band's name"/>
                </div>

                <div class="form-group">
                    <label for="musicstyle">Style</label>
                    <select id="musicstyle" name="music_style" class="form-control">
                        <option value=""></option>
                        @foreach ($music_style as $style)
                            <option value="{{ $style->id }}">{{ $style->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="songFile">* Song file (mp3)</label>
                    <input type="file" id="songFile" name="song_file" data-validation="size mime required" data-validation-allowing="mpeg" data-validation-max-size="15M" data-validation-error-msg-mime="Only mp3 file are allowed" data-validation-error-msg-required="No file selected">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            </form>
        </div>
    </div>
    <script type="text/javascript">

        $.validate({
            modules : 'file'
        });
    </script>
@stop

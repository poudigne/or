@extends('layout')

@section('title', 'Page Title')

@section('content')
@if (isset($deleted))
  @if ($deleted == '1')
    <script type="text/javascript">
      Materialize.toast('Product successfuly deleted !', 4000);
    </script>
  @else
    <script type="text/javascript">
      Materialize.toast('Error has occured : {{ $deleted }}', 4000);
    </script>
  @endif
@endif

<h2 class="header">List of suggested songs</h2>
<!--<a class="btn-floating disabled" href="/CreateProduct"><i class="small material-icons">add</i></a>-->
<button type="button" id="save-button" class="btn btn-success">Save</button>
<table class="table-striped table table-hover table-condensed">
  <thead>
    <tr>
      <th></th>
      <th data-field="title">Title</th>
      <th data-field="band">Band</th>
      <th data-field="music_styles">style</th>
      <th data-field="is_accepted">is accepted ?</th>
      <th data-field="reasons">reasons</th>
    </tr>
  </thead>
  <tbody>
      
    @foreach ($musics as $set)
      <tr class="music-row">
        <td class="button-col">
            <div onclick="play_song('medias/{{ $set->path }}', {{ $set->id }})" id="music_id_{{ $set->id }}" class="play my-button">
            </div​>
        </td>
        <td class="text-col">{{ $set->title }}</td>
        <td class="text-col">{{ $set->band }}</td>
        <td class="style-col"> 
            <select id="musicstyle" name="music_style" class="form-control">
                @foreach ($music_style as $style)
                    <option value="{{ $style->id }}" 
                        @if ($set->style_id == $style->id) 
                            selected
                        @endif 
                         >{{ $style->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select class="is_accepted form-control" name="is_accepted" row-id="{{ $set->id }}">
                <option value=""></option>
                <option value="1" @if ( $set->is_accepted == 1) selected @endif>Accept</option>
                <option value="0" @if ( $set->is_accepted == 0 && $set->is_accepted != NULL) selected @endif>Reject</option>
            </select>
        </td>
        <td><input type="text" class="inputSongReason form-control" id="inputSongReason-{{ $set->id }}" placeholder="Reason for rejecting the song" disabled></td>
      </tr>
    @endforeach
  </tbody>
</table>      

<script type="text/javascript">

/***********************************
 * When the play button is clicked *
 ***********************************/
function play_song(element, music_id) {
    if (current_song != null){
        current_song.pause();
        $("#music_id_"+playing_song).addClass('play').removeClass('pause');
    }
        
    song = new Audio(element);
    if (song.canPlayType('audio/mpeg;')  && playing_song != music_id) {
        song.type = 'audio/mpeg';
        song.src = element;
        song.play();
        is_song_playing = true;
        playing_song = music_id;
        current_song = song;
        $("#music_id_"+music_id).addClass('pause').removeClass('play');
    } 
    else if (playing_song == music_id){
           is_song_playing = false; 
           playing_song = '';
           current_song = null;
    }
    
}
/**************************************
 * When a combo box selection is made *
 **************************************/
$( ".is_accepted" ).change(function() {
    row_id = $(this).attr("row-id");
    if (this.value == 1 || this.value == '')
        $("#inputSongReason-"+row_id).attr("disabled", "");
    else
        $("#inputSongReason-"+row_id).removeAttr("disabled");
    
});
/*******************************
 * When save button is clicked *
 *******************************/
$("#save-button").click(function(){
    saveJson = [];
    // build the json
    $(".music-row").each(function(){
        accepted_value = $(this).find(".is_accepted")[0].value;
        if (accepted_value != "")
        {
            saveJson.push({
                id:          $(this).find("#musicstyle")[0].value,
                style:       $(this).find("#musicstyle")[0].value,
                is_accepted: $(this).find(".is_accepted")[0].value,
                reason:      $(this).find(".inputSongReason").val()
            });
        }
        
    });
    // send json via ajax to save it 
    $.ajax({
        url: 'accept-song',
        type: "post",
        data: { 
            "music"  : saveJson,
            "_token" : "{{ csrf_token() }}"
        },
        success: function(data) {
            alert(data);
        }
    });   
});
/**************************
 * When document is ready *
 **************************/
$().ready(function(){
   is_song_playing = false; 
   playing_song = '';
   current_song = null;
});
</script>

<style>
    .my-button  {
        display:    block;
        width:      24px;
        height:     24px;
        float:      left;
        padding:    0;
        margin:     5px 0 0 0;
    }
    .play {
        background-image:       url("img/song_control.png");
        background-position:    right 0 top 0;
    }
    .pause {
        background:             url("img/song_control.png");
        background-position:    right 0 top -24px;
    }
    td {
        height:         34px;
        line-height:    34px !important;
    }
    td.button-col {
        width:     2% !important;
    }
    td.style-col {
        width:     11% !important;
    }
    td.text-col {
        width:     20% !important;
    }
</style>
    
@stop
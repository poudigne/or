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

<h2 class="header">List of products</h2>
<!--<a class="btn-floating disabled" href="/CreateProduct"><i class="small material-icons">add</i></a>-->
<table class="highlight responsive-table bordered">
  <thead>
    <tr>
      <th data-field="title">Title</th>
      <th data-field="band">Band</th>
      <th data-field="music_styles">style</th>
      <th data-field="is_accepted">is accepted ?</th>
      <th data-field="reasons">reasons</th>
    </tr>
  </thead>
  <tbody>
      <!-- select('musics.title', 'musics.is_accepted', 'musics.band','musics.id','music_styles.name', 'musics.reasons') -->
    @foreach ($musics as $set)
      <tr>
        <td>{{ $set->title }}</td>
        <td>{{ $set->band }}</td>
        <td>{{ $set->style_id }}</td>
        <td>
            @if ( $set->is_accepted == 1)
                <span>Accepted</span>
            @elseif ($set->is_accepted == 0)
                <span>Rejected</span>
            @else
                <a href="/Music/accept/{{ $set->id }}/1" data-method="accept" >Accept</a>
                <a href="/Music/accept/{{ $set->id }}/0" data-method="accept" >Reject</a>
            @endif
        </td>
        <td>{{ $set->reasons }}</td>
      </tr>
    @endforeach
  </tbody>
</table>      
@stop
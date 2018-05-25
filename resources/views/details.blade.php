@extends('layouts.app')

@section('content')
<div class="text cent">
  Здесь представлен список всех наших игр!
</div>
<table class = "tabler">
  <tr>
    <td style="width: 20%;">
      <div class="list list-group">
        @foreach ($games as $game)
          <a href="{{ url('/game/'.$game->id) }}" class = "cent list-group-item list-group-item-action @if (Request::is('game/'.$game->id)) active1 @endif">{{$game->name}}</a>
        @endforeach
      </div>
    </td>
    <td style="margin-left: 10px;">
      @if (is_int($gamen))
        <div class="cent default">
          Выбирайте любую игру и наслаждайтесь приятным времяпрепровождением!
        </div>
        <img src="{{asset('img/lgo.png')}}" width="50%" style="margin-left: 25%;">
      @else
        <div class="cent default">
          <h4>Идем в игру!</h4>
        </div>
        <div class="cent default">
          <p>{{$gamen->description}}</p>
        </div>
        <div class="cent default">
        <a href="{{ url($gamen->domain) }}"><button type="button" class="btn btn-success">Играть!</button></a>
        </div>
      @endif
    </td>
  </tr>
</table>



@endsection

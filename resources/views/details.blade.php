@extends('layouts.app')

@section('content')
<div class="text cent">
  Здесь представлен список всех наших игр!
</div>
<table class = "tabler">
  <tr>
    <td style="width: 20%; vertical-align: top;">
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
          <h4>Давай играть!!!</h4>
        </div>
        <div class="cent default">
          <p>{{$gamen->name}} -- {{$gamen->description}}</p>
        </div>

        <table>
          <tr>
            <td style="width: 35%; vertical-align: top;">
              <div class="cent text">
                Топ игроков:
              </div>
              <div class="cent default">
                <ol>
                @foreach ($top as $t)
                  <li>
                    {{$t['user']}}({{$t['result']}})
                  </li>
                @endforeach
                </ol>
              </div>
              <div class="cent default">
                <img src="{{ asset('img/like.png') }}" width="30px" height="30px;"> likes: {{ $likes }}
              </div>
              <div class="cent default">
                <a href="{{ url('/play/' . $gamen->id) }}"><button type="button" class="btn btn-success btn-lg">Играть!</button></a>
              </div>

            </td>
            <td>
              <img src="{{ asset('img/'.$gamen->image) }}" width="100%">
            </td>
          </tr>
        </table>

      @endif
    </td>
  </tr>
</table>



@endsection

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
        <img src="{{asset('img/lgo.png')}}" width="50%" style="margin-left: 20%; margin-top: 10%;">
      @else
        <div class="cent default">
          <h3>{{$gamen->name}}</h3>
        </div>
        <div class="cent default">
          <p>{{$gamen->description}}</p>
        </div>
        <table>
          <tr>
            <td style="width: 50%; vertical-align: top;">
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
                <a href="{{ url($gamen->domain) }}"><button type="button" class="btn btn-success btn-lg">Играть!</button></a>
              </div><hr>

              <div class="cent default">
                <img src="{{ asset('img/like.png') }}" width="30px" height="30px;"> likes: {{ $likes }}
              </div>
              <div class="cent default">
                <img src="{{ asset('img/comment.png') }}" width="30px" height="30px;"> comments: {{ count($gamen->comments) }}
              </div>

            </td>
            <td>
              <img src="{{ asset('img/'.$gamen->image) }}" width="100%">
            </td>
          </tr>
        </table>
        <div class="cent default" style="margin-top: 5%;">
          <h4>Все комментарии:</h4>
        </div>

        <div class="accordion" id="accordionExample" style="width: 80%; margin-left:10%;">
          <?php $i = 0 ?>
          @foreach ($gamen->comments as $comment)
          <?php $i++; ?>
          <div class="card">
            <div class="card-header" id="headingOne">
              <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{$i}}" aria-expanded="true" aria-controls="collapse{{$i}}">
                  {{$comment->title}} by {{$comment->author}}
                </button>
              </h5>
            </div>
            <div id="collapse{{$i}}" class="collapse" aria-labelledby="heading{{$i}}" data-parent="#accordionExample">
              <div class="card-body">
                {{$comment->text}}
              </div>
            </div>
          </div>
          @endforeach
        </div>

        <!-- <div class="cent default">
          <ul>
          @foreach ($gamen->comments as $comment)
            <li>{{$comment->text}}</li>
          @endforeach
          </ul>
        </div> -->
      @endif
    </td>
  </tr>
</table>



@endsection

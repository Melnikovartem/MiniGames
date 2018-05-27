@extends('layouts.app')

@section('content')
  <div class="cent text">
    {{ $user->name }}, приветсвую!
  </div>
  <center>
    <img src="{{asset('img/snake.png')}}" width="20%">
  </center>
  <div class="cent default">
    Ваша статистика:
  </div>
  <div class="cent">
    <table width = '70%'><tr>
      <td width = '40%'>
        <table width = "50%">
          <tr>
            <th> Игра</th>
            <th> Результат</th>
          </tr>

        @foreach ($results as $result)
        <tr>
          <td> {{ $result['name'] }} ---></td>

          <td> {{ $result['st'] }}</td>
        </tr>
        @endforeach
        </table>
      </td>
      <td>
        <div class="cent">
          <img src="{{ asset('img/like.png') }}" width="30px" height="30px;"> likes: {{ $likes }}
        </div>
      </td>
    </tr></table>
  </div>
@endsection

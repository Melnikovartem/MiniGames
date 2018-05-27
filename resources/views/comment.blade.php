@extends('layouts.app')

@section('content')


<form method="POST" style="width: 60%; margin-left: 20%;">
  @csrf
  <h2>Добавление нового комментария к игре {{ $gamen }}</h2>
  <div class="input-group mb-3">
    <div class="input-group-prepend">
      <span class="input-group-text">Имя</span>
    </div>
    <input type="text" class="form-control" placeholder="Аркадий" name="name" required value="{{old('name')}}">
  </div>

  <div class="input-group mb-3">
    <div class="input-group-prepend">
      <span class="input-group-text">Тайтл</span>
    </div>
    <input type="text" class="form-control" placeholder="Аркадий" name="title" required value="{{old('title')}}">
  </div>

  <div class="input-group">
    <div class="input-group-prepend">
      <span class="input-group-text">Комментарий</span>
    </div>
    <textarea class="form-control" aria-label="With textarea" name="comment">{{old('comment')}}</textarea>
  </div>
  <br>
  <a href="{{url('/game/')}}/{{$gid}}"><button type="button" class="btn btn-info">Назад</button></a>
  <input type="submit" value="Добавить" class="btn btn-info">
</form>

@endsection

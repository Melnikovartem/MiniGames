@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Все прошло отлично!</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    Капитан, вы в системе!<br>
                    И можете перейти к <a href="{{url('/game/0')}}">играм</a>!<br>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

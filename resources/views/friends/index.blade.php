@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Connections</div>
                    <div class="card-body">
                        @include('friends.userlist', ['users' => $friends])
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Requests</div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($requests as $request)
                                <li class="list-group-item">
                                    <form method="post" action="friend/accept">
                                        {{csrf_field()}}
                                        <input type="hidden" name="id" value="{{$request->id}}">
                                        <button class="btn btn-success w-100" type="submit">Accept</button>
                                    </form>

                                    <a href="profile/{{$request->id}}">
                                        {{$request->name}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Recommendations
                    </div>

                    <div class="card-body">
                        @include('friends.userlist', ['users'=>$recommended])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

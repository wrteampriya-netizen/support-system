@extends('navbar')

@section('title', 'Chats')

@section('content')

<div class="container">

    <h3>Chat Users</h3>

    @foreach($users as $user)

        <div class="card p-3 mb-2">

        <a href="{{route('chats.open',$user->id)}}" class="user-link">

            {{ $user->name }}
            <span class="badge bg-danger rounded-pill ms-2">
                {{$user->unread_count}}  new
</span>
</a>

        </div>

    @endforeach

</div>

@endsection
@extends('navbar')
@section('title','chat')
@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>Chats</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold">Chat Users</h4>
    </div>

    @if($chats->count() == 0)
        <div class="alert alert-info text-center">
            No chats found
        </div>
    @endif

    <div class="list-group">

        @foreach($chats as $chat)

            @php
                $user = App\Models\User::find($chat->sender_id);
            @endphp

            <a href="{{ route('chats.open', $chat->sender_id) }}"
               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">

                <!-- Left side -->
                <div class="d-flex align-items-center">

                    <!-- Avatar -->
                    <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-3"
                         style="width:45px; height:45px; font-weight:600;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <!-- Name -->
                    <div>
                        <div class="fw-semibold">
                            {{ $user->name }}
                        </div>
                        <small class="text-muted">
                            Click to open chat
                        </small>
                    </div>

                </div>

                <!-- Right side -->
                <div>

                    @if($chat->unread > 0)
                        <span class="badge bg-danger rounded-pill px-3 py-2">
                            {{ $chat->unread }}
                        </span>
                    @endif

                </div>

            </a>

        @endforeach

    </div>

</div>

</body>
</html>

    
@endsection
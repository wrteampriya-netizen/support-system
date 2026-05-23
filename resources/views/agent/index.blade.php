<!DOCTYPE html>
<html>

<head>
    <title>Chats</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-4">

        <h3 class="mb-4"> Chats</h3>

        @if(count($chats) == 0)
        <div class="alert alert-info">
            No chats found
        </div>
        @endif

        @foreach($chats as $chat)

        <a href="{{ route('chats.open', $chat->sender_id) }}"
            class="text-decoration-none text-dark">

            <div class="card mb-2 shadow-sm">

                <div class="card-body d-flex justify-content-between align-items-center">

                    
                    <div>
                        <h6 class="mb-1">
                            <i class="bi bi-person"></i> Agent #{{ App\Models\User::find($chat->sender_id)->name}}
                        </h6>

                        <small class="text-muted">
                            {{ $chat->message ?? 'No message yet' }}
                        </small>
                    </div>

                    
                    <div>
                        @if(isset($chat->unread) && $chat->unread > 0)
                        <span class="badge bg-danger">
                            {{ $chat->unread }}
                        </span>
                        @endif
                    </div>

                </div>

            </div>

        </a>

        @endforeach

    </div>

</body>

</html>
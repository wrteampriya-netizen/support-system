<!DOCTYPE html>
<html>
<head>
    <title>Chat</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-4">

    
    <div class="card mb-3">
        <div class="card-body">
            <h5> Chat with Agent {{ $user->name }}</h5>

            <a href="{{ route('chats.index') }}" class="btn btn-sm btn-secondary">
                ← Back
            </a>
        </div>
    </div>

    <!-- Messages box -->
    <div class="card mb-3">
        <div class="card-body" style="height:400px; overflow-y:auto;">

            @foreach($message as $msg)

                @if($msg->sender_id == auth()->id())
                    
                    <div class="d-flex justify-content-end mb-2">
                        <div class="bg-primary text-white p-2 rounded" style="max-width:60%;">
                            {{ $msg->message }}
                        </div>
                    </div>
                @else
                    
                    <div class="d-flex justify-content-start mb-2">
                        <div class="bg-light border p-2 rounded" style="max-width:60%;">
                            {{ $msg->message }}
                        </div>
                    </div>
                @endif

            @endforeach

        </div>
    </div>

    
    <form method="POST" action="{{ route('chats.send') }}">
        @csrf

         <input type="hidden" name="reciever_id" value="{{ $id }}">

        <div class="input-group">
            <input type="text" name="message" class="form-control" placeholder="Type a message..." required>

            <button class="btn btn-primary">
                Send
            </button>
        </div>
    </form>

</div>

</body>
</html>
@extends('navbar')
@section('title','agent')
@section('content')


<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->

<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> -->



<body>
    <div class="container mt-3">
        <table class="table table-bordered">

            <th data-field="id">ID</th>
            <th data-field="subject">Subject</th>
            <th data-field="description">Description</th>
            <th data-field="priority">Priority</th>
            <th data-field="category">Category</th>
            <th> Warnning</th>
            <th data-field="sla_deadline"> Deadline</th>
            <th>Response Time</th>
            <th> notes</th>
            <th data-field="status"> status</th>
            <th>Attachments</th>
            <th>action</th>
            <th>Meassage</th>

            <tbody>
                @foreach($acceptedTickets as $ticket)

                <tr>

                    <td>{{ $ticket->id }}</td>

                    <td>{{ $ticket->subject }}</td>

                    <td>{{ $ticket->description }}</td>

                    <td>{{ $ticket->priority }}</td>

                    <td>{{ $ticket->category }}</td>
                    <td>

                        @if($ticket->status == 'closed' || $ticket->status == 'resolved')

                        <span style="color: gray;">
                            Closed
                        </span>

                        @elseif($ticket->sla_deadline && $ticket->sla_deadline->isPast())

                        <span style="color: red; font-weight: bold;">
                            OVERDUE
                        </span>

                        @elseif($ticket->sla_deadline && now()->diffInHours($ticket->sla_deadline) <= 1)

                            <span style="color: orange; font-weight: bold;">
                            Breaching Soon!
                            </span>

                            @else

                            <span style="color: green;">
                                Within SLA
                            </span>

                            @endif

                    </td>

                    <td>

                        {{ $ticket->sla_deadline
        ? $ticket->sla_deadline->format('d M Y, h:i A')
        : 'No Deadline'
    }}

                    </td>
                    <td>
                        {{ $ticket->created_at->diffForHumans() }}
                    </td>

                    <td>
                        <form action="{{ route('agent.status.update', $ticket->id) }}" method="POST">
                            @csrf

                            <select
                                name="status"
                                class="form-select form-select-sm"
                                onchange="this.form.submit()">

                                <option value="in_progress"
                                    {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>
                                    In Progress
                                </option>

                                <option value="closed"
                                    {{ $ticket->status == 'closed' ? 'selected' : '' }}>
                                    Closed
                                </option>

                            </select>
                        </form>
                    </td>

                    <td>
                        <form action="{{route('addComments',$ticket->id)}}" method="post">
                            @csrf
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Modal{{$ticket->id}}">

                                <i class="bi bi-chat-left-text"></i> Leave a Comment
                            </button>

                            <div class="modal fade" id="Modal{{$ticket->id}}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="Modal">Add comment</h5>

                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="text" class="form-control" placeholder="Add comment here..." name="comment">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Add</button>

                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </td>


                    <td>

                        <a href="{{ asset('storage/'.$ticket->attachment) }}"
                            target="_blank">

                            <img src="{{ asset('storage/'.$ticket->attachment) }}"
                                class="img-thumbnail"
                                width="80">

                        </a>

                    </td>

                    <td>

                        <button type="button"
                            class="btn btn-danger btn-sm"
                            onclick="removeRow(this)">

                            <i class="bi bi-trash"></i>

                        </button>

                    </td>
                    <td>
                        <a href="{{ route('chats.open', $ticket->customer_id) }}">
                            Chat
                        </a>
                    </td>

                </tr>

                @endforeach
        </table>
        </tbody>
    </div>


    <script>
        function removeRow(btn, id) {
            btn.closest("tr").remove();
        }
    </script>

</body>

</html>
@endsection
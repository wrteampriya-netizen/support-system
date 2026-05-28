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
                @foreach($tickets as $ticket)

                @php
                $rowColor = '';

                if($ticket->status == 'open') {
                $rowColor = '#fff3cd';
                }
                elseif(in_array($ticket->status, ['in_progress','pending'])) {
                $rowColor = '#d1ecf1';
                }
                else {
                $rowColor = '#d4edda';
                }
                @endphp

                <tr style="background: {{ $rowColor }}">

                    <td>{{ $ticket->id }}</td>

                    <td>{{ $ticket->subject }}</td>

                    <td>{{ $ticket->description }}</td>

                    <td>{{ $ticket->priority }}</td>

                    <td>{{ $ticket->category }}</td>


                    {{-- SLA STATUS --}}
                    <td>

                        @php
                        $deadline = strtotime($ticket->sla_deadline);
                        $currentTime = time();
                        $hoursLeft = ($deadline - $currentTime) / 3600;
                        @endphp

                        @if($ticket->status == 'closed' || $ticket->status == 'resolved')

                        <span style="color: gray;">Closed</span>

                        @elseif($deadline < $currentTime)

                            <span style="color: red; font-weight: bold;">OVERDUE</span>

                            @elseif($hoursLeft <= 1)

                                <span style="color: orange; font-weight: bold;">Breaching Soon!</span>

                                @else

                                <span style="color: green;">Within SLA</span>

                                @endif

                    </td>

                    {{-- Deadline --}}
                    <td>
                        {{ $ticket->sla_deadline ? date('d M Y, h:i A', strtotime($ticket->sla_deadline)): 'No Deadline'}}
                    </td>

                    {{-- Created time --}}
                    <td>
                        {{ $ticket->created_at->diffForHumans() }}
                    </td>

                    {{-- Status Update --}}
                    <td>
                        <form action="{{ route('agent.status.update', $ticket->id) }}" method="POST">
                            @csrf

                            <select name="status"
                                class="form-select form-select-sm"
                                onchange="this.form.submit()">

                                <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>
                                    In Progress
                                </option>

                                <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>
                                    Closed
                                </option>
                                <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>
                                    Resolved
                                </option>

                                <option value="pending" {{ $ticket->status == 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>

                            </select>
                        </form>
                    </td>

                    {{-- Comment --}}
                    <td>
                        <form action="{{ route('addComments',$ticket->id) }}" method="post">
                            @csrf

                            <button type="button"
                                class="btn btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#Modal{{ $ticket->id }}">
                                <i class="bi bi-chat-left-text"></i> Comment
                            </button>

                            <div class="modal fade" id="Modal{{ $ticket->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Add Comment</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <input type="text" name="comment"
                                                class="form-control"
                                                placeholder="Add comment here...">
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

                    {{-- Attachment --}}
                    <td>
                        @if($ticket->attachment)
                        <a href="{{ asset('storage/'.$ticket->attachment) }}" target="_blank">
                            <img src="{{ asset('storage/'.$ticket->attachment) }}"
                                class="img-thumbnail"
                                width="80">
                        </a>
                        @else
                        No File
                        @endif
                    </td>

                    {{-- Delete --}}
                    <td>
                        <button type="button"
                            class="btn btn-danger btn-sm"
                            onclick="removeRow(this)">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>

                    {{-- Chat --}}
                    <td>
                        <a href="{{ route('chats.open', $ticket->customer_id) }}">
                            Chat
                        </a>
                    </td>

                </tr>

                @endforeach
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
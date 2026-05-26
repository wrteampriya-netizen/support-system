@extends('navbar')
@section('title','team Leader')
@section('content')

<div class="container mt-3">

    

    <button id="openAssignModal"
        class="btn btn-success mb-3">

        Assign Agent

    </button>

    <table class="table table-bordered">

        <thead>

            <tr>
                <th>Select</th>
                <th>ID</th>
                <th>Subject</th>
                <th>Description</th>
                <th>Priority</th>
                <th>Category</th>
                <th data-Formatter="satusformatter">Status</th>
                <th>Attachment</th>
                <th>Action</th>
            </tr>

        </thead>

        <tbody>

            @foreach($acceptedTickets as $ticket)

            <tr id="row{{ $ticket->id }}">

                <td>
                    <input type="checkbox"
                        class="ticket-checkbox"
                        value="{{ $ticket->id }}">
                </td>

                <td>{{ $ticket->id }}</td>
                <td>{{ $ticket->subject }}</td>
                <td>{{ $ticket->description }}</td>
                <td>{{ $ticket->priority }}</td>
                <td>{{ $ticket->category }}</td>
                <!-- <td>{{ $ticket->status }}</td> -->
                <td>
                    <form action="{{ route('leader.status.update', $ticket->id) }}" method="POST">
                        @csrf
                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Open</option>

                            <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>
                                In Progress
                            </option>
                            <option value="pending" {{ $ticket->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
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
                        onclick="removeRow(this, {{ $ticket->id }})">

                        <i class="bi bi-trash"></i>

                    </button>
                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</div>

<!-- MODAL -->
<div class="modal fade" id="assignModal" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form action="{{ route('ticket.assign') }}" method="POST">
                @csrf

                <div class="modal-header">

                    <h5 class="modal-title">Assign Tickets</h5>

                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <input type="hidden"
                        name="ticket_ids"
                        id="ticketIds">



                    <label class="mb-2">Select Agent</label>

                    <select class="form-select" name="agent_id" required>
                        <option value="">-- Choose an Agent --</option>

                        @foreach($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }}
                        </option>
                        @endforeach

                    </select>

                </div>

                <div class="modal-footer">

                    <button type="submit"
                        class="btn btn-success">

                        Assign

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script>
    function removeRow(btn, id) {
        btn.closest("tr").remove();
    }

    document.getElementById("openAssignModal")
        .addEventListener("click", function() {

            let checked = document.querySelectorAll(".ticket-checkbox:checked");

            if (checked.length === 0) {
                alert("Select at least one ticket");
                return;
            }

            let ids = [];

            checked.forEach(function(checkbox) {
                ids.push(checkbox.value);
            });

            document.getElementById("ticketIds").value = ids.join(",");

            new bootstrap.Modal(document.getElementById("assignModal")).show();
        });
</script>

@endsection
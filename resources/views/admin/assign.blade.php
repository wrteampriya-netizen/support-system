@extends('navbar')
@section('title','agent')
@section('content')

<!DOCTYPE html>
<html lang="en">

<head>

    <title>Assign Tickets</title>


    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.27.3/dist/bootstrap-table.min.css">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.27.3/dist/extensions/filter-control/bootstrap-table-filter-control.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.27.3/dist/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>

</head>

<body class="p-4">
    @if(isset($newTickets) && count($newTickets) > 0)
    <div class="alert alert-warning alert-dismissible fade show" role="alert">


        <strong>New Tickets:</strong> You have {{ count($newTickets) }} unassigned ticket(s).


        <ul class="list-group mt-2">
            @foreach ($newTickets as $nt)
            <li class="list-group-item d-flex justify-content-between align-items-center">

                <span>{{ $nt->subject }}</span>

                <div class="d-flex gap-2">


                    <a href="{{ route('admin.ticket.accept', $nt->id) }}" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-lg"></i>
                    </a>




                    <form action="/ticket/{{ $nt->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this?')">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </form>
                </div>

            </li>
            @endforeach
        </ul>


        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

    </div>
    @endif





    <button id="openAssignModal" class="btn btn-success mb-3">
        Assign Leader
    </button>

    <div class="d-flex gap-2 mb-3">

        <select id="statusFilter" class="form-select w-auto">
            <option value="">All Status</option>
            <option value="open">Open</option>
            <option value="in_progress">In Progress</option>
            <option value="pending">Pending</option>
            <option value="resolved">Resolved</option>
            <option value="closed">Closed</option>
        </select>

        <button class="btn btn-primary" onclick="applyFilter()">
            Filter
        </button>

        <button class="btn btn-secondary" onclick="resetFilter()">
            Reset
        </button>

    </div>




    <table id="table"
        data-toggle="table"
        data-url="{{ route('admin.fetch') }}" 
        data-side-pagination="server"
        data-pagination="true"
        data-search="true"
        data-query-params="queryParams"
        class="table table-striped table-bordered">

        <thead>
            <tr>

                <th
                    data-field="state"
                    data-checkbox="true">
                </th>

                <th data-field="id">ID</th>
                <th data-field="subject">Subject</th>
                <th data-field="description">Description</th>
                <th data-field="priority">Priority</th>
                <th data-field="category">Category</th>
                <th data-field="status" data-formatter="statusFormatter">Status</th>
               
<th data-field="leader_name">Assign_To</th>




                <th
                    data-field="attachment"
                    data-formatter="imageFormatter">
                    Attachment
                </th>

                <th
                    data-formatter="actionFormatter">
                    Action
                </th>

            </tr>
        </thead>

    </table>

    <div class="modal fade" id="assignModal" tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <form action="{{ route('team.assign') }}" method="POST">

                    @csrf

                    <div class="modal-header">

                        <h5 class="modal-title">
                            Assign Tickets
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                        </button>

                    </div>

                    <div class="modal-body">


                        <input
                            type="hidden"
                            name="ticket_ids"
                            id="ticketIds">


                        <label class="mb-2">
                            Select Leader
                        </label>

                        <select
                            class="form-control"
                            name="leader_id">

                            @foreach($users as $user)

                            <option value="{{ $user->id }}">
                                {{ $user->email }}
                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="modal-footer">

                        <button
                            type="submit"
                            class="btn btn-success">
                            Assign
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

   
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.27.3/dist/bootstrap-table.min.js"></script>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
      

        function queryParams(params) {

            params.status = $('#statusFilter').val();

            return params;
        }

        function applyFilter() {
            $('#table').bootstrapTable('refresh');
        }

        function resetFilter() {
            $('#statusFilter').val('');
            $('#table').bootstrapTable('refresh');
        }


        const $table = $('#table');


        function imageFormatter(value, row) {

            if (value) {

                return `
                    <img 
                        src="/storage/${value}" 
                        class="img-thumbnail"
                        style="
                            width:80px;
                            height:60px;
                            object-fit:cover;
                        "
                    >
                `;
            }

            return 'No Image';
        }

        function actionFormatter(value, row, index) {

            return `
                <button class="btn btn-sm btn-primary">
                   <i class="bi bi-pencil-fill"></i>
                </button>

                <form action="/ticket/${row.id}" method="POST" style="display:inline;">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="DELETE">

            <button type="submit"
                class="btn btn-sm btn-danger"
                onclick="return confirm('Are you sure you want to delete?')">
               <i class="bi bi-trash3"></i>
            </button>
        </form>
            
            
               
            `;
        }


        $('#getchekcedid').click(function() {

            const selectrow = $table.bootstrapTable('getSelections');

            const ticketIds = selectrow.map(row => row.id);

            console.log(ticketIds);

            alert(ticketIds.join(','));

        });

        $('#openAssignModal').click(function() {

            const selectrow = $table.bootstrapTable('getSelections');

            if (selectrow.length === 0) {
                alert('Please select at least one ticket');
                return;
            }

            const ticketIds = selectrow.map(row => row.id);

            $('#ticketIds').val(ticketIds.join(','));

            console.log('Selected Tickets:', ticketIds);

            const modal = new bootstrap.Modal(
                document.getElementById('assignModal')
            );

            modal.show();
        });

        function statusFormatter(value, row, index) {
            return `
    <form action="/admin/tickets/${row.id}/status" method="post" class="status-update-form">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    
    <select name="status" class="form-select form-select-sm status-dropdown" onchange="this.form.submit()">
    <option value="open" ${value === 'open'? 'selected':''}>Open</option>
    <option value="in_progress" ${value === 'in_progress' ? 'selected':''}>In Progress</option>
    <option value="pending" ${value === 'pending'?'selected':''}>pending</option>
    <option value="resolved" ${value === 'resolved' ? 'selected' :''}>Resolved</option>
    <option value="closed" ${value === 'closed' ? 'selected':''}>Closed</option>


    </select>
    </form>
    `;
        }
    </script>

</body>

</html>
@if(session('success'))

<div class="alert alert-success">
    {{ session('success') }}
</div>

@endif

@endsection
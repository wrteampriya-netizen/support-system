@extends('navbar')
@section('title','CustomerReport')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

<div class="container mt-4">

    <div class="card shadow-sm border-danger">

        <div class="card-header bg-danger text-white">
            <h4 class="mb-0">SLA Breached Tickets</h4>
        </div>
        <table class="table table-bordered table-hover">


<thead class="table-dark">

        <tr>
            <th>Ticket</th>
            <th>status</th>
            <th>SLA Deadline</th>
            <th>current Time</th>
            <th>Delay</th>


        </tr>
         <tbody>
       
            @foreach ($slaTickets as $ticket)
            <tr>
                <td>{{$ticket->subject}}</td>
                <td class="badge bg-danger">{{$ticket->status}}</span></td>
                <td>{{$ticket->sla_deadline}}</td>
                <td>{{ now()->format('d M Y h:i A') }}</td>
                <td>
                    {{ now()->diff($ticket->sla_deadline)->format('%h Hours %i Minutes') }}
                </td>
            </tr>


            @endforeach
            </tbody>
        </thead>




    </div>

</div>
@endsection

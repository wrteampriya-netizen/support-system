@extends('navbar')
@section('title','CustomerReport')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

<table class="table table-bordered table-striped table-hover text-center">
    <thead class="table-dark">
        <tr>
            <th>Agent Name</th>
            <th>Total Assigned Tickets</th>
        </tr>
    </thead>

    <tbody>
        @foreach($agents as $agent)
        <tr>
            <td>{{ $agent->name }}</td>
            <td>
                <span class="badge bg-primary">
                    {{ $agent->tickets_count }}
                </span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection



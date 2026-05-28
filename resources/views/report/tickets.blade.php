@extends('navbar')
@section('title','CustomerReport')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>



<div class="container mt-5">

    <div class="row g-4">

        <div class="col-md-4">
            <div class="card shadow border-primary">
                <div class="card-body text-center">
                    <h5 class="card-title text-primary">Total Tickets</h5>
                    <h2>{{ $total }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow border-warning">
                <div class="card-body text-center">
                    <h5 class="card-title text-warning">In Progress</h5>
                    <h2>{{ $InProgressTicekts }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow border-success">
                <div class="card-body text-center">
                    <h5 class="card-title text-success">Open Tickets</h5>
                    <h2>{{ $openTicket }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow border-danger">
                <div class="card-body text-center">
                    <h5 class="card-title text-danger">Closed Tickets</h5>
                    <h2>{{ $closeTicekts }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow border-info">
                <div class="card-body text-center">
                    <h5 class="card-title text-info">Pending Tickets</h5>
                    <h2>{{ $PendingTicekts }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow border-dark">
                <div class="card-body text-center">
                    <h5 class="card-title text-dark">Resolved Tickets</h5>
                    <h2>{{ $ResolvedTicekts }}</h2>
                </div>
            </div>
        </div>

    </div>

</div>



@endsection

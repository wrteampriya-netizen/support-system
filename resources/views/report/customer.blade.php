@extends('navbar')
@section('title','CustomerReport')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<div class="container mt-4">



    <div class="card mb-4 shadow-sm">

        <div class="card-header bg-dark text-white">

            <h5 class="mb-0">
                Tickets Details


            </h5>

        </div>

        <div class="card-body">



            <table class="table table-bordered table-hover">
                <h5 class="mb-0">
                    <tr>
                        <th>User Name</th>
                        <th>Tickets</th>
                    </tr>

                </h5>



                <tbody>

                    @foreach($user as $users)
                    <tr>

                        <td>{{ $users->name }}</td>

                        <td>{{ $users->user_ticket_count }}</td>
                    </tr>

                    @endforeach

                </tbody>

            </table>






        </div>

    </div>



</div>

@endsection
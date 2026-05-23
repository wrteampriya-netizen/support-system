@extends('navbar')
@section('title','agent')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body class="bg-light">

    <div class="container py-5">

        <div class="row g-4">

            
            <div class="col-md-4">

                <div class="card shadow border-0 rounded-4">

                    <div class="card-body text-center">

                        <i class="bi bi-ticket-detailed fs-1 text-primary"></i>

                        <h5 class="mt-3">
                            Total Tickets
                        </h5>

                        <h2 class="fw-bold">
                            {{ $total }}
                        </h2>

                    </div>

                </div>

            </div>

            
            <div class="col-md-4">

                <div class="card shadow border-0 rounded-4">

                    <div class="card-body text-center">

                        <i class="bi bi-folder2-open fs-1 text-warning"></i>

                        <h5 class="mt-3">
                            Open Tickets
                        </h5>

                        <h2 class="fw-bold">
                            {{ $openTicketsCount }}
                        </h2>

                    </div>

                </div>

            </div>

            
     <div class="col-md-4">

                <div class="card shadow border-0 rounded-4">

                    <div class="card-body text-center">

                        <i class="bi bi-folder2-open fs-1 text-warning"></i>

                        <h5 class="mt-3">
                            Close Tickets
                        </h5>

                        <h2 class="fw-bold">
                            {{ $closeTicketsCount}}
                        </h2>

                    </div>

                </div>

            </div>


        </div>

    </div>


</body>

</html>

@endsection
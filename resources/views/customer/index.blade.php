
@extends('navbar')

@section('title', 'Create Tickets')

@section('content')


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Bootstrap Table CSS -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">

    <title>Tickets List</title>
</head>

<body class="bg-light p-5">

<div class="container bg-white p-4 rounded shadow">

    <h2 class="mb-4">Tickets List</h2>

    <table
        id="table"
        data-toggle="table"
        data-url="{{ route('customer.fetch') }}"
        data-search="true"
        data-pagination="true"
        data-show-columns="true"
        data-page-size="10"
        class="table table-striped table-bordered">

        <thead>
            <tr>
                <th data-field="id">ID</th>
                <th data-field="subject">Subject</th>
                <th data-field="description">Description</th>
                <th data-field="priority">Priority</th>
                <th data-field="category">Category</th>
                <th data-field="status">Status</th>
                <th data-field="attachment" data-formatter="imageFormatter">Attachment</th>
                <th data-formatter="actionFormatter">Action</th>
            </tr>
        </thead>

    </table>

</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Bootstrap Table JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>

<script>
    function actionFormatter(value, row, index) {

        return `
            <a href="/customer/edit/${row.id}" 
               class="text-warning me-2" title="Edit">
                <i class="bi bi-pencil-square fs-5"></i>
            </a>

            <form method="POST"
                  action="/customer/delete/${row.id}"
                  style="display:inline;">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                
                <button type="submit"
                        class="btn btn-link text-danger p-0"
                        onclick="return confirm('Are you sure?')">

                    <i class="bi bi-trash fs-5"></i>
                </button>

            </form>
        `;
    }
    function imageFormatter(value, row, index) {
        let image_url=`/storage/${value}`;
        return `
        <a href= "${image_url}" target="_blank" >
        <img src="${image_url}" alt="attachment" class="img-thumbnail" 
        style=" max-width:60px; max-height:60px; object-fit:cover;"
        >
        </a>
        
        `;

    }

</script>

</body>
</html>

@endsection

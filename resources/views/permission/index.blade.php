@extends('navbar')


@section('title', 'Permissions')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Permissions</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
</head>

<body class="bg-light p-5">

<div class="container bg-white p-4 rounded shadow">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>System Permissions List</h2>
        <a href="{{ route('permission.add') }}" class="btn btn-primary">Add New Permission</a>
    </div>

    <table id="table"
           data-toggle="table"
           data-url="{{ route('permission.fetch') }}"
           data-pagination="true"
           data-search="true"
           data-show-columns="true"
           data-page-size="10"
           class="table table-striped table-bordered">
        <thead>
            <tr>
                <th data-field="id" data-sortable="true">ID</th>
                <th data-field="name" data-sortable="true">Permission Name</th>
                <th data-field="action" data-formatter="actionformatter">action</th>

            </tr>
        </thead>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>

</body>
</html>
<script>
    function actionformatter(value,row,index){
        return `
        <a href="permission/edit/${row.id}" class="text-warning me-2" title="edit"> 
        <i class="bi bi-pencil-square fs-5"></i>
        </a>
        <form method="post" action="permission/delete/${row.id}" style="display:inline;" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <button type="submit" class="btn btn-link text-danger p-0 "
         onclick="return confirm('Are you sure you want to delete')" title="delete" >
         <i class="bi bi-trash fs-5"></i>
         </button>
        </form>`;
    }
</script>

@endsection
@extends('navbar')

@section('title', 'User List')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>User Role Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body{
            background:#f4f7fb;
        }

        .card-custom{
            border:none;
            border-radius:16px;
            overflow:hidden;
        }

        .table thead{
            background:#0d6efd;
            color:white;
        }

        .role-badge{
            font-size:13px;
            padding:6px 12px;
            border-radius:20px;
        }

    </style>

</head>

<body>

<div class="container py-5">

    <div class="card shadow card-custom">

        <div class="card-header bg-primary text-white py-3">

            <h3 class="mb-0">
                <i class="bi bi-people-fill me-2"></i>
                User Role Management
            </h3>

        </div>

        <div class="card-body">

            @if(session('success'))

                <div class="alert alert-success">
                    {{ session('success') }}
                </div>

            @endif

            <table class="table table-hover align-middle">

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Current Role</th>
                        <th width="280">Assign Role</th>
                    </tr>

                </thead>

               <tbody>

@foreach($users as $user)

<tr>

    <td>{{ $user->id }}</td>

    <td>{{ $user->name }}</td>

    <td>{{ $user->email }}</td>

    <td>

        @forelse($user->roles as $role)

            <span class="badge bg-success role-badge">
                {{ $role->name }}
            </span>

        @empty

            <span class="text-muted">
                No Role
            </span>

        @endforelse

    </td>

    <td>

        <form method="POST"
              action="{{ route('role.user', $user->id) }}">

            @csrf

            <div class="d-flex gap-2">

                <select name="role" class="form-select">

                    <option value="">
                        Select Role
                    </option>

                    @foreach($roles as $role)

                        <option value="{{ $role->name }}">
                            {{ $role->name }}
                        </option>

                    @endforeach

                </select>

                <button type="submit"
                        class="btn btn-primary">

                    Assign

                </button>

            </div>

        </form>

    </td>

</tr>

@endforeach

</tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>



@endsection
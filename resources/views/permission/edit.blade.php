@extends('navbar')


@section('title', 'Permissions')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Permission</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">

                <div class="card shadow border-0 rounded-4">
                    <div class="card-body p-4">

                        <h3 class="text-center mb-4">
                            Edit Permission
                        </h3>

                        <form action="{{ route('permission.update',$permission->id) }}" method="POST">
                            @csrf
                           

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">
                                    Permission
                                </label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    class="form-control"
                                    placeholder="Enter a permission"
                                    value="{{ old('name', $permission->name) }}">

                                @error('name')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2 mt-3">

                                <button type="submit" class="btn btn-primary w-100">
                                    Update Permission
                                </button>

                                <a href="{{ route('permission.index') }}" class="btn btn-secondary w-100 text-center">
                                    Cancel
                                </a>

                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>
@endsection
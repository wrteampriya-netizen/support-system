@extends('navbar')


@section('title', ' Create Role ')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Role</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">

                <div class="card shadow border-0 rounded-4">
                    <div class="card-body p-4">

                        <h3 class="text-center mb-4">
                            Add Role
                        </h3>

                        <form action="{{ route('role.create') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">
                                    Role
                                </label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    class="form-control"
                                    placeholder="Enter a permission"
                                    value="{{ old('name') }}">
                                @error('name')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                                @enderror
                                <div class="mb=3">
                                    <label class="form-label fw-semibold">Assign Permission</label>
                                    <div class="border rounded p-3 bg-white" style="max-height:220px;overflow-y: auto;">
                                        @foreach ($permissions as $permission )
                                        <div class="foprm-check">
                                            <input class="form-check-input"
                                                type="checkbox"
                                                name="permission[]"
                                                value="{{$permission->name}}"
                                                id="perm{{$permission->id}}">
                                            <label class="form-check-label" for="perm{{$permission->id}}">
                                                {{$permission->name}}
                                            </label>
                                        </div>

                                        @endforeach

                                    </div>
                                </div>
                            </div>
                            <div class="d-flex gap-2 mt-3">

                                <button type="submit" class="btn btn-primary w-100">
                                    Create Role
                                </button>

                                <a href="{{ route('role.index') }}" class="btn btn-secondary w-100 text-center">
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
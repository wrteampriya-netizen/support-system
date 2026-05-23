@include('navbar')

<div class="container py-5">
  

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Team Detail</title>

  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>
<body>
<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-9">

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                

                <div class="bg-primary text-white p-4">

                    <h3 class="mb-1 fw-bold">

                        <i class="bi bi-people-fill me-2"></i>

                        Create Support Team

                    </h3>

                    <p class="mb-0 opacity-75">
                        Create and manage support teams easily
                    </p>

                </div>

                

                <div class="card-body p-4">

                    <form method="POST" action="{{ route('team.store') }}">

                        @csrf

                        <div class="row g-4">

                            

                            <div class="col-md-6">

                                <label for="team_name"
                                       class="form-label fw-semibold">

                                    Team Name

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">

                                        <i class="bi bi-diagram-3"></i>

                                    </span>

                                    <input type="text"
                                           class="form-control"
                                           id="team_name"
                                           name="team_name"
                                           placeholder="Enter Team Name"
                                           required>

                                </div>

                            </div>

                            

                            <div class="col-md-6">

                                <label for="team_leader"
                                       class="form-label fw-semibold">

                                    Team Leader

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">

                                        <i class="bi bi-person-badge"></i>

                                    </span>

                                    <select class="form-select"
                                            id="team_leader"
                                            name="team_leader"
                                            required>

                                        <option value="">
                                            Select Team Leader
                                        </option>

                                        @foreach($users as $user)

                                            <option value="{{ $user->id }}">

                                                {{ $user->name }}

                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>

                            

                            <div class="col-12">

                                <label for="description"
                                       class="form-label fw-semibold">

                                    Team Description

                                </label>

                                <textarea class="form-control"
                                          id="description"
                                          name="description"
                                          rows="4"
                                          placeholder="Enter team description..."></textarea>

                            </div>

                            

                            <div class="col-12">

                                <label for="members"
                                       class="form-label fw-semibold">

                                    Select Team Members

                                </label>

                                <select class="form-select"
                                        id="members"
                                        name="agents[]"
                                        multiple
                                        size="8">

                                    @foreach($users as $user)

                                        <option value="{{ $user->id }}">

                                            {{ $user->name }}

                                        </option>

                                    @endforeach

                                </select>

                                <small class="text-muted">

                                    Hold Ctrl (Windows) or Cmd (Mac) to select multiple users.

                                </small>

                            </div>

                        </div>

                       

                        <div class="d-flex justify-content-end gap-2 mt-5">

                            <button type="reset"
                                    class="btn btn-light border px-4">

                                Cancel

                            </button>

                            <button type="submit"
                                    class="btn btn-primary px-4 shadow-sm">

                                <i class="bi bi-check-circle me-1"></i>

                                Create Team

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>
</body>
</html>


</div>
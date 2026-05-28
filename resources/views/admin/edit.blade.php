@extends('navbar')

@section('title','Create Team')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-9">

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                <!-- Header -->

                <div class="bg-primary text-white p-4">

                    <h3 class="mb-1 fw-bold">

                        <i class="bi bi-people-fill me-2"></i>

                        update Support Team

                    </h3>

                    <p class="mb-0 opacity-75">
                        update and manage support teams easily
                    </p>

                </div>



                <div class="card-body p-4">

                    <form method="POST" action="{{ route('team.update',$data->id) }}">

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
                                        value="{{$data->name}}"
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

                                        <option value="{{ $user->id }}" {{old('team_leader',$data->owner_id)==$user->id ? 'selected':''}}>

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
                                    placeholder="Enter team description..." {{old('description',$data->description)}}></textarea>

                            </div>



                            <div class="clo-12">
                                <label class="border rounded-3 p-3" style="max-height:250px; overflow-y:auto;">
                                    @foreach ($users as $user)
                                    <div class="from-check mb-2">
                                        <input class="form-check-input"
                                            type="checkbox"
                                            name="agents[]"
                                            value="{{ $user->id }}"
                                            id="user_{{ $user->id }}"

                                            {{ in_array($user->id, old('agents', $data->members->pluck('id')->toArray())) ? 'checked' : '' }}>

                                        <label class="form-check-label" for="user_{{$user->id}}">
                                            {{$user->name}}
                                    </div>

                                    @endforeach
                            </div>
                            <small class="text-muted">
                                Tick users to add them as team members.
                            </small>


                        </div>



                        <div class="d-flex justify-content-end gap-2 mt-5">

                            <button type="reset"
                                class="btn btn-light border px-4">

                                Cancel

                            </button>

                            <button type="submit"
                                class="btn btn-primary px-4 shadow-sm">

                                <i class="bi bi-check-circle me-1"></i>

                                update Team

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
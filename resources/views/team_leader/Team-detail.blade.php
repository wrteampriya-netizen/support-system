@include('navbar')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<h2 class="mb-4 fw-bold text-primary">
    👥 My Team
</h2>

@if($team)

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">
            Team: {{ $team->name }}
        </h4>
    </div>

    <div class="card-body">

        <h5 class="mb-3 text-secondary">
            Team Members
        </h5>

        <div class="row g-3">

            @foreach($team->members as $member)
                <div class="col-md-6">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-body">

                            <h6 class="fw-bold text-dark mb-2">
                                👤 {{ $member->name }}
                            </h6>

                            <hr>

                            @if($member->tickets->count() > 0)
                                <ul class="list-group list-group-flush">
                                    @foreach($member->tickets as $ticket)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>
                                                🎫 #{{ $ticket->id }} - {{ $ticket->subject ?? 'No title' }}
                                            </span>

                                            
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted mb-0">
                                    No tickets assigned
                                </p>
                            @endif

                        </div>

                    </div>

                </div>
            @endforeach

        </div>

    </div>
</div>

@else

<div class="alert alert-warning shadow-sm">
    ⚠️ No team assigned to you.
</div>

@endif
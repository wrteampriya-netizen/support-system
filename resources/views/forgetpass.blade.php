<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-4">

                    <h3 class="text-center mb-4">
                        Forgot Password
                    </h3>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Email Address
                            </label>

                            <input 
                                type="email"
                                name="email"
                                class="form-control"
                                placeholder="Enter Email"
                                value="{{ old('email') }}"
                            >

                            @error('email')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        @if(session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Send Reset Link
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
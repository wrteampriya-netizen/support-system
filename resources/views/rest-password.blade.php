<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">

                    <h2 class="text-center mb-4 fw-bold">
                        Reset Password
                    </h2>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Email Address
                            </label>

                            <input 
                                type="email"
                                name="email"
                                class="form-control"
                                placeholder="Enter Email"
                                value="{{ old('email', request()->email) }}"
                            >

                            @error('email')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                New Password
                            </label>

                            <input 
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Enter New Password"
                            >

                            @error('password')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Confirm Password
                            </label>

                            <input 
                                type="password"
                                name="password_confirmation"
                                class="form-control"
                                placeholder="Confirm Password"
                            >
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Reset Password
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
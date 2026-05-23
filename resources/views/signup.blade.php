<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register Form</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container d-flex justify-content-center align-items-center vh-100">

    <div class="card shadow-sm border-0" style="width: 420px; border-radius: 16px;">
        <div class="card-body p-4">

            <!-- Header -->
            <div class="mb-4 text-center">
                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                    Secure Registration Portal
                </span>

                <h3 class="mt-3 fw-bold">Create Account</h3>
                <p class="text-muted small">
                    Sign up to get started
                </p>
            </div>

            <!-- Form -->
           <form method="POST" action="{{ route('signup.store') }}">

                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="John Doe">
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="you@company.com">
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Create password">
                </div>

                

                <!-- Button -->
                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                    Create Account →
                </button>

            </form>

            <!-- Footer -->
            <div class="text-center mt-3 small">
                Already have an account?
                <a href="{{ url('login') }}" class="text-primary text-decoration-none">Sign in</a>
            </div>

        </div>
    </div>

</div>

</body>
</html>
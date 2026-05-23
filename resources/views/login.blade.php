 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register Form</title>

  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container d-flex justify-content-center align-items-center vh-100">

    <div class="card shadow-sm border-0" style="width: 420px; border-radius: 16px;">
        <div class="card-body p-4">

            
            <div class="mb-4 text-center">
                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                    Secure Login Portal
                </span>

                <h3 class="mt-3 fw-bold">Welcome back</h3>
                <p class="text-muted small">
                    Sign in to continue
                </p>
            </div>

            
            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

               
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="you@company.com">
                </div>

              
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password">
                </div>

               
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label small" for="remember">
                            Remember me
                        </label>
                    </div>

                    <a href="{{ url('/forgot-password') }}"class="small text-decoration-none"> 
                        Forgot password?
                    </a>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                    Sign In →
                </button>

            </form>

            
            <div class="text-center mt-3 small">
                Don't have an account?
                <a href="#" class="text-primary text-decoration-none">Create account</a>
            </div>

        </div>
    </div>

</div>
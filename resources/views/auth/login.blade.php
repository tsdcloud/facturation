<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Se connecter</title>
    <link rel="shortcut icon" href="assets/images/logo/logo-dpws.png" type="image/x-icon" />
    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/main.css" />

    <style>
        .btn-color {
            background-color: #0e1c36;
            color: #fff;

        }

        .profile-image-pic {
            height: 200px;
            width: 200px;
            object-fit: cover;
        }



        .cardbody-color {
            background-color: #ebf2fa;
        }

        a {
            text-decoration: none;
        }

    </style>
</head>
<body>
    <div class="container my-auto">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card my-5">
                    <form method="POST" action="{{ route('login') }}" class="card-body cardbody-color p-lg-5">
                        @csrf
                        <div class="text-center mb-3">
                            <img src="assets/images/logo/logo-dpws.png" alt="profile">
                        </div>
                        <div class="mb-3">
                            <input type="email" value="{{ old('email') }}" name="email" class="form-control @error('email') is-invalid @enderror"  placeholder="votre nom" />
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control  @error('password') is-invalid @enderror" name="password" placeholder="mot de passe" />
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="text-center"><button type="submit" class="btn btn-primary px-5 mb-5 w-100">Se connecter</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

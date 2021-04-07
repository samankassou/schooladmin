@extends('layouts.auth', ['title' => 'Login'])

@section('content')
<div class="row h-100 justify-content-center py-4">
    <div class="col-lg-4 col-md-6 col-10">
            <div class="auth-logo">
                <a href="index.html"><img src="{{ asset('mazer/assets/images/logo/logo.png') }}" alt="Logo"></a>
            </div>
            <h1 class="auth-title">Se conneter</h1>
            <p class="auth-subtitle mb-5">Connecter vous pour continuer.</p>

            <form action="index.html">
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="text" class="form-control form-control-xl" placeholder="Email">
                    <div class="form-control-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="password" class="form-control form-control-xl" placeholder="Password">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>
                <div class="form-check form-check-lg d-flex align-items-end">
                    <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label text-gray-600" for="flexCheckDefault">
                        Se souvenir
                    </label>
                </div>
                <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Se connecter</button>
            </form>
            <div class="text-center mt-5 text-lg fs-4">
                <p><a class="font-bold" href="auth-forgot-password.html">Mot de passe oublié?</a></p>
            </div>
    </div>
</div>
@endsection
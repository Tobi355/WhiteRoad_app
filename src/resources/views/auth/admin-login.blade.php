@extends('layouts.app')

@section('title', 'Acceso Administrativo')

@section('content')
<section class="auth-page admin-login-page">
    <div class="container">
        <div class="section-header">
            <h1>Acceso <span>Administrativo</span></h1>
            <p>Ingrese sus credenciales administrativas</p>
        </div>

        <div class="form-container auth-card">
            @if($errors->any())
                <div class="form-error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="admin_login" value="1">

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input id="password" name="password" type="password" required>
                </div>

                <button class="btn btn-primary" type="submit">Ingresar como Administrador</button>
            </form>
        </div>
    </div>
</section>
@endsection

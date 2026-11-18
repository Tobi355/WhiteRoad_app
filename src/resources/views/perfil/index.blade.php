@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<section class="container">
    <div class="profile-container">
        <aside class="profile-sidebar">
            <div class="profile-avatar">{{ substr($user->name, 0, 1) }}</div>
            <h1 class="profile-name">{{ $user->name }}</h1>
            <p class="profile-email">{{ $user->email }}</p>
            <ul class="profile-menu">
                <li><a href="#" data-seccion="editar">Editar Perfil</a></li>
            </ul>
        </aside>
        <div class="profile-content">
            <div id="seccion-editar" >
                <h2>Editar Perfil</h2>
                <form method="POST" action="{{ route('perfil.update') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"> @method('PUT')
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" value="{{ old('telefono', $user->telefono) }}">
                    </div>
                    <div class="form-group">
                        <label>Nueva contraseña (dejar vacío para no cambiar)</label>
                        <input type="password" name="password">
                    </div>
                    <div class="form-group">
                        <label>Confirmar contraseña</label>
                        <input type="password" name="password_confirmation">
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection


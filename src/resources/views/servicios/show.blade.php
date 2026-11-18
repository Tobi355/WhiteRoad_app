@extends('layouts.app')

@section('title', $servicio->nombre)

@section('content')
<section class="container">
    <div class="service-detail">
        <div class="service-detail-image">
            @php $imgPath = public_path('storage/' . ($servicio->imagen ?? '')); @endphp
            @if(!empty($servicio->imagen) && file_exists($imgPath))
                <img src="{{ asset('storage/' . $servicio->imagen) }}" alt="{{ $servicio->nombre }}">
            @else
                <div class="placeholder">🔧</div>
            @endif
        </div>
        <div class="service-detail-info">
            <h1>{{ $servicio->nombre }}</h1>
            <div class="service-detail-price">{{ number_format($servicio->precio, 0, ',', '.') }} ARS</div>
            <div class="service-detail-meta">
                <div class="meta-item">
                    <span>Duración</span>
                    <strong>{{ $servicio->duracion }}</strong>
                </div>
                <div class="meta-item">
                    <span>Categoría</span>
                    <strong>{{ $servicio->categoria->nombre }}</strong>
                </div>
            </div>
            <div class="service-detail-description">
                <h2>Descripción</h2>
                <p>{{ $servicio->descripcion }}</p>
            </div>
            @if($servicio->condiciones)
                <div class="service-detail-conditions">
                    <h2>Condiciones</h2>
                    <p>{{ $servicio->condiciones }}</p>
                </div>
            @endif
            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.servicios.index') }}" class="btn btn-primary">Gestionar servicios</a>
                @else
                    <form action="{{ route('cart.add', $servicio) }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button class="btn btn-primary">Agregar al carrito</button>
                    </form>
                @endif
            @else
                <p>Iniciá sesión para continuar con la compra de este servicio.</p>
            @endauth
        </div>
    </div>
</section>
@endsection
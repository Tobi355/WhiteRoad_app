@extends('layouts.app')

@section('title', 'Carrito')

@section('content')

<div class="container py-5">

    <h1 class="mb-4 mt-3">Mi carrito</h1>

    @if(count($cart))

        <p class="text-muted mb-4">Podés ajustar la cantidad de cada servicio o eliminarlo directamente desde aquí.</p>

        <table class="table">
            <thead>
                <tr>
                    <th>Servicio</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @php($total = 0)
            @foreach($cart as $item)
                @php($subtotal = $item['precio'] * $item['quantity'])
                @php($total += $subtotal)
                <tr>
                    <td>{{ $item['nombre'] }}</td>
                    <td>${{ number_format($item['precio'],0,',','.') }}</td>
                    <td>
                        <form method="POST" action="{{ route('cart.update', $item['id']) }}" class="d-flex gap-2 align-items-center">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="0" class="form-control form-control-sm" style="max-width: 100px;">
                            <button class="btn btn-outline-primary btn-sm">Guardar</button>
                        </form>
                    </td>
                    <td>${{ number_format($subtotal,0,',','.') }}</td>
                    <td>
                        <form method="POST" action="{{ route('cart.remove',$item['id']) }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button class="btn btn-danger btn-sm">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <h2 class="text-end">
            Total:
            ${{ number_format($total,0,',','.') }}
        </h2>

        <a href="{{ route('checkout.index') }}" class="btn btn-primary">
            Continuar al checkout
        </a>

        <form method="POST" action="{{ route('cart.clear') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button class="btn btn-secondary">
                Vaciar carrito
            </button>
        </form>

    @else

        <div class="alert alert-info">
            No hay servicios agregados.
        </div>

    @endif

</div>

@endsection
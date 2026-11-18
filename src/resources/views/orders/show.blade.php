@extends('layouts.app')

@section('title', 'Detalle de compra')

@section('content')
    <div class="container py-5">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div>
                        <h1 class="fw-bold mb-1">Compra #{{ $order->id }}</h1>
                        <p class="text-muted mb-0">
                            Realizada el {{ $order->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>

                    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                        ← Volver
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start gap-3">
                            <div>
                                <h2 class="card-title mb-3">Estado de la orden</h2>
                            </div>

                            @switch($order->status)
                                @case('pending')
                                    <span class="badge bg-warning-subtle text-warning-emphasis fs-6">Pendiente</span>
                                    @break

                                @case('paid')
                                    <span class="badge bg-success-subtle text-success-emphasis fs-6">Pagada</span>
                                    @break

                                @case('completed')
                                    <span class="badge bg-primary-subtle text-primary-emphasis fs-6">Terminada</span>
                                    @break

                                @case('failed')
                                    <span class="badge bg-danger-subtle text-danger-emphasis fs-6">Fallida</span>
                                    @break

                                @default
                                    <span class="badge bg-secondary-subtle text-secondary-emphasis fs-6">{{ ucfirst($order->status) }}</span>
                            @endswitch
                        </div>

                        <p class="text-muted mb-0">
                            @if ($order->status === 'paid' || $order->status === 'completed')
                                Tu compra ya fue procesada correctamente.
                            @elseif ($order->status === 'pending')
                                Está esperando confirmación o pago.
                            @elseif ($order->status === 'failed')
                                Ocurrió un problema al procesar esta compra.
                            @else
                                Estado registrado en el sistema.
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mt-2">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <h2 class="card-title mb-3">Total abonado</h2>
                        <h2 class="text-success mb-0">${{ number_format($order->total, 0, ',', '.') }}</h2>
                        <p class="text-muted mt-2 mb-0">Incluye todos los servicios contratados en esta compra.</p>
                    </div>
                </div>
            </div>
        </div>

            <div class="table-responsive mt-3">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Servicio</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Precio unitario</th>
                            <th scope="col">Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($order->items as $item)
                            <tr>
                                <td>{{ $item->servicio->nombre }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->price, 0, ',', '.') }}</td>
                                <td><strong>${{ number_format($item->subtotal, 0, ',', '.') }}</strong></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    No hay servicios registrados en esta compra.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    @if ($order->items->isNotEmpty())
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">TOTAL</th>
                                <th>${{ number_format($order->total, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
@endsection
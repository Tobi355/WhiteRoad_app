@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

<section class="admin-section container">

    <div class="section-header">
        <h1>Dashboard</h1>
        <p>Resumen general del sistema y actividad reciente.</p>
    </div>

    <div class="dashboard-stats">

        <div class="stat-card">
            <h2>Usuarios</h2>
            <span>{{ $totalUsuarios }}</span>
        </div>

        <div class="stat-card">
            <h2>Servicios</h2>
            <span>{{ $totalServicios }}</span>
        </div>

        <div class="stat-card">
            <h2>Órdenes</h2>
            <span>{{ $totalOrdenes }}</span>
        </div>

        <div class="stat-card">
            <h2>Facturación</h2>
            <span>${{ number_format($facturacionTotal,0,',','.') }}</span>
        </div>

        <div class="stat-card">
            <h2>Pendientes</h2>
            <span>{{ $ordenesPendientes }}</span>
        </div>

        <div class="stat-card">
            <h2>Pagadas</h2>
            <span>{{ $ordenesPagadas }}</span>
        </div>

        <div class="stat-card">
            <h2>Terminadas</h2>
            <span>{{ $ordenesTerminadas }}</span>
        </div>

        <div class="stat-card">
            <h2>Mensajes nuevos</h2>
            <span>{{ $totalContactos }}</span>
        </div>

    </div>

    <div class="mt-5">

        <h2>Últimas órdenes</h2>

        <div class="admin-table-container">

            <table class="admin-table">

                <thead>

                    <tr>

                        <th>#</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Fecha</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($ultimasOrdenes as $order)

                    <tr>

                        <td>#{{ $order->id }}</td>

                        <td>{{ $order->user->name }}</td>

                        <td>

                            ${{ number_format($order->total,0,',','.') }}

                        </td>

                        <td>

                            @switch(strtolower($order->status))

                                @case('pending')

                                    <span class="badge bg-warning text-dark">

                                        Pendiente

                                    </span>

                                    @break

                                @case('paid')

                                    <span class="badge bg-success">

                                        Pagada

                                    </span>

                                    @break

                                @case('completed')

                                    <span class="badge bg-primary">

                                        Terminada

                                    </span>

                                    @break

                                @case('failed')

                                    <span class="badge bg-danger">

                                        Fallida

                                    </span>

                                    @break

                                @default

                                    {{ ucfirst($order->status) }}

                            @endswitch

                        </td>

                        <td>

                            {{ $order->created_at->format('d/m/Y H:i') }}

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="text-center">

                            No hay órdenes registradas.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</section>

@endsection

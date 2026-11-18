@extends('layouts.admin')

@section('title', 'Órdenes')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestión de Órdenes</h1>
        <span class="badge bg-secondary fs-6">
            {{ $orders->total() }} órdenes
        </span>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>
        </div>
    @endif

    <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-2 align-items-end mb-4">
        <div class="col-md-4">
            <label for="status" class="form-label">Filtrar por estado</label>
            <select id="status" name="status" class="form-select">
                <option value="">Todos</option>
                <option value="pending" {{ old('status', $status) === 'pending' ? 'selected' : '' }}>Pendiente</option>
                <option value="paid" {{ old('status', $status) === 'paid' ? 'selected' : '' }}>Pagada</option>
                <option value="completed" {{ old('status', $status) === 'completed' ? 'selected' : '' }}>Terminada</option>
                <option value="failed" {{ old('status', $status) === 'failed' ? 'selected' : '' }}>Fallida</option>
            </select>
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Aplicar</button>
        </div>
    </form>

    <div class="table-responsive">

        <table class="table table-hover align-middle">

            <thead class="table-dark">

                <tr>

                    <th>#</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th width="340">Acciones</th>

                </tr>

            </thead>

            <tbody>

            @forelse($orders as $order)

                <tr>

                    <td>
                        <strong>#{{ $order->id }}</strong>
                    </td>

                    <td>

                        <strong>{{ $order->user->name }}</strong>

                        <br>

                        <small class="text-muted">

                            {{ $order->user->email }}

                        </small>

                    </td>

                    <td>

                        <strong>

                            ${{ number_format($order->total,0,',','.') }}

                        </strong>

                    </td>

                    <td>

                        @if($order->status == 'pending')

                            <span class="badge bg-warning text-dark">
                                Pendiente
                            </span>

                        @elseif(strtolower($order->status) == 'paid')

                            <span class="badge bg-success">
                                Pagada
                            </span>

                        @elseif(strtolower($order->status) == 'completed')

                            <span class="badge bg-primary">
                                Terminada
                            </span>

                        @elseif(strtolower($order->status) == 'failed')

                            <span class="badge bg-danger">
                                Fallida
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                {{ ucfirst($order->status) }}
                            </span>

                        @endif

                    </td>

                    <td>

                        {{ $order->created_at->format('d/m/Y') }}

                        <br>

                        <small class="text-muted">

                            {{ $order->created_at->format('H:i') }}

                        </small>

                    </td>

                    <td>

                        <div class="d-flex flex-wrap gap-2">

                            <a
                                href="{{ route('admin.orders.show',$order) }}"
                                class="btn btn-outline-primary btn-sm">

                                Ver

                            </a>

                            @if($order->status == 'pending')

                                <form
                                    action="{{ route('admin.orders.paid',$order) }}"
                                    method="POST">

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    @method('PATCH')

                                    <button
                                        class="btn btn-success btn-sm">

                                        Marcar pagada

                                    </button>

                                </form>

                            @endif

                            @if($order->status == 'paid')

                                <form
                                    action="{{ route('admin.orders.completed',$order) }}"
                                    method="POST">

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    @method('PATCH')

                                    <button
                                        class="btn btn-primary btn-sm">

                                        Terminar

                                    </button>

                                </form>

                            @endif

                            <form
                                action="{{ route('admin.orders.destroy',$order) }}"
                                method="POST"
                                onsubmit="return confirm('¿Eliminar esta orden?')">

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                @method('DELETE')

                                <button
                                    class="btn btn-outline-danger btn-sm">

                                    Eliminar

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="text-center py-5">

                        <h2>No hay órdenes registradas.</h2>

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-4">

        {{ $orders->links() }}

    </div>

</div>

@endsection

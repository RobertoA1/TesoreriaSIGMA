@extends('base.administrativo.blank')

@section('titulo')
    Detalles del Pago #{{ $pago->id_pago }}
@endsection

@section('contenido')
    <h2 class="text-lg mb-4 dark:text-amber-50 text-black ">Detalles del Pago #{{ $pago->id_pago }}</h2>
    <p class="dark:text-amber-50 text-black"><strong>Monto total:</strong> {{ $pago->monto }}</p>
    <p class="dark:text-amber-50 text-black"><strong>Fecha de pago:</strong> {{ $pago->fecha_pago }}</p>
    <hr class="my-4">

    @php
        $titulo = "Detalles de Pago";
        $columnas = ['Fecha', 'Monto', 'Nro Recibo', 'Observación'];
        $filas = [];
        foreach($detalles as $detalle) {
            $filas[] = [
                $detalle->fecha_pago,
                $detalle->monto,
                $detalle->nro_recibo,
                $detalle->observacion,
            ];
        }

        $resource = 'financiera';
        $create = 'pago_create';
        $showing = 10;
        $paginaActual = 1;
        $totalPaginas = 1;
    @endphp

    @include('layout.tables.table-detalles', compact('titulo', 'columnas', 'filas', 'resource', 'create', 'showing', 'paginaActual', 'totalPaginas'))
@endsection
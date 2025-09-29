@extends('base.administrativo.blank')

@section('titulo')
    Detalles del Pago #{{ $pago->id_pago }}
@endsection

@section('contenido')

    <!-- Contenedor cabecera -->
    <div class="rounded-lg border border-gray-300 dark:border-gray-700 
                        bg-white dark:bg-gray-900 shadow-sm p-6 mb-8">
        <!-- Título + botón -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-semibold dark:text-amber-50 text-black">
                Detalles del Pago #{{ $pago->id_pago }}
            </h2>

            <a href="{{ route('pago_view') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 
                      text-gray-700 dark:text-gray-200 text-sm font-medium 
                      rounded-lg shadow hover:bg-gray-300 dark:hover:bg-gray-600 
                      transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 19l-7-7 7-7"/>
                </svg>
                Regresar
            </a>
        </div>

        <!-- Fila 1 -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">Código Educando</label>
                <input type="text" value="{{ $alumno->codigo_educando }}" readonly
                       class="w-full rounded-lg border border-gray-300 dark:border-gray-700 
                              px-3 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 
                              text-gray-800 dark:text-white/90">
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">Código Modular</label>
                <input type="text" value="{{ $alumno->codigo_modular }}" readonly
                       class="w-full rounded-lg border border-gray-300 dark:border-gray-700 
                              px-3 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 
                              text-gray-800 dark:text-white/90">
            </div>

            <div class="flex flex-col col-span-2">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">Nombre Completo</label>
                <input type="text" value="{{ $alumno->apellido_paterno }} {{ $alumno->apellido_materno }} {{ $alumno->primer_nombre }} {{ $alumno->otros_nombres }}" readonly
                       class="w-full rounded-lg border border-gray-300 dark:border-gray-700 
                              px-3 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 
                              text-gray-800 dark:text-white/90">
            </div>
        </div>

        <!-- Fila 2 -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">DNI</label>
                <input type="text" value="{{ $alumno->dni }}" readonly
                       class="w-full rounded-lg border border-gray-300 dark:border-gray-700 
                              px-3 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 
                              text-gray-800 dark:text-white/90">
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">Año de Ingreso</label>
                <input type="text" value="{{ $alumno->año_ingreso }}" readonly
                       class="w-full rounded-lg border border-gray-300 dark:border-gray-700 
                              px-3 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 
                              text-gray-800 dark:text-white/90">
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">Teléfono</label>
                <input type="text" value="{{ $alumno->telefono }}" readonly
                       class="w-full rounded-lg border border-gray-300 dark:border-gray-700 
                              px-3 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 
                              text-gray-800 dark:text-white/90">
            </div>
        </div>

        <!-- Fila 3 -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">Dirección</label>
                <input type="text" value="{{ $alumno->direccion }}" readonly
                       class="w-full rounded-lg border border-gray-300 dark:border-gray-700 
                              px-3 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 
                              text-gray-800 dark:text-white/90">
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">Monto Total</label>
                <input type="text" value="S/ {{ number_format($detalles->sum('monto'), 2) }}" readonly
                       class="w-full rounded-lg border border-gray-300 dark:border-gray-700 
                              px-3 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 
                              text-gray-800 dark:text-white/90">
            </div>
        </div>
    </div>

    <!-- Aquí siguen tus detalles -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($detalles as $i => $detalle)
            <div class="p-4 rounded-lg border border-gray-300 dark:border-gray-700 
                        bg-white dark:bg-gray-900 shadow-sm">
                <h3 class="text-md font-semibold mb-3 dark:text-amber-50 text-black">
                    Detalle #{{ $i+1 }}
                </h3>

                <!-- Fecha -->
                <div class="flex flex-col mb-3">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">Fecha de Pago</label>
                    <input type="text"
                           value="{{ \Carbon\Carbon::parse($detalle->fecha_pago)->format('d/m/Y') }}"
                           readonly
                           class="w-full rounded-lg border border-gray-300 dark:border-gray-700 
                                  px-3 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 
                                  text-gray-800 dark:text-white/90">
                </div>

                <!-- Monto -->
                <div class="flex flex-col mb-3">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">Monto</label>
                    <input type="text" value="S/ {{ number_format($detalle->monto, 2) }}" readonly
                           class="w-full rounded-lg border border-gray-300 dark:border-gray-700 
                                  px-3 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 
                                  text-gray-800 dark:text-white/90">
                </div>

                <!-- Nro Recibo -->
                <div class="flex flex-col mb-3">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">Nro Recibo</label>
                    <input type="text" value="{{ $detalle->nro_recibo }}" readonly
                           class="w-full rounded-lg border border-gray-300 dark:border-gray-700 
                                  px-3 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 
                                  text-gray-800 dark:text-white/90">
                </div>

                <!-- Observación -->
                <div class="flex flex-col mb-3">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">Observación</label>
                    <textarea readonly
                              class="w-full rounded-lg border border-gray-300 dark:border-gray-700 
                                     px-3 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 
                                     text-gray-800 dark:text-white/90">{{ $detalle->observacion }}</textarea>
                </div>

                <!-- Estado -->
                <div class="flex flex-col mb-3">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">Estado</label>
                    @if($detalle->estado_validacion === 'validado')
                        <p class="text-sm sm:text-base font-semibold px-4 py-2 rounded-full shadow-md text-center 
                                bg-green-100 text-green-700 transition-all duration-300">
                            Validado
                        </p>
                    @else
                        <p class="text-sm sm:text-base font-semibold px-4 py-2 rounded-full shadow-md text-center 
                                bg-red-100 text-red-700 transition-all duration-300">
                            Pendiente
                        </p>
                    @endif
                </div>

                <!-- Voucher -->
                @if($detalle->voucher_path)
                    <div class="flex flex-col">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                            Constancia de Pago
                        </label>
                        @if(Str::endsWith($detalle->voucher_path, ['.jpg','.jpeg','.png']))
                            <img src="{{ asset('storage/'.$detalle->voucher_path) }}" 
                                 alt="Voucher" 
                                 class="rounded-lg shadow-md max-h-64 object-contain">
                        @elseif(Str::endsWith($detalle->voucher_path, '.pdf'))
                            <iframe src="{{ asset('storage/'.$detalle->voucher_path) }}" 
                                    class="w-full h-64 border rounded-lg"></iframe>
                        @endif
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endsection
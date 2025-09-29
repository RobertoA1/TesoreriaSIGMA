@extends('base.administrativo.blank')

@section('titulo')
  Ingrese un pago
@endsection

@section('contenido')

    <div class="p-8 m-4 dark:bg-white/[0.03] rounded-2xl">
        <div class="flex pb-4 justify-between items-center">
            <h2 class="text-lg dark:text-gray-200 text-gray-800">Estás ingresando un Pago</h2>

            <div class="flex gap-4">
                <input form="form" type="submit"
                    class="cursor-pointer inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-gray-200 px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-300 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                    value="Ingresar">

                <a href="{{ $data['return'] }}"
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-gray-200 px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-300 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                    Cancelar
                </a>
            </div>
        </div>

        <form method="POST" id="form" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" action="" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <!-- Fecha de Pago -->
            <div class="flex flex-col">
                <label for="fecha_de_pago" class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                    Fecha de Pago
                </label>

                <div class="flex items-center rounded-lg border border-gray-300 dark:border-gray-700 focus-within:ring-2 focus-within:ring-indigo-500">
                    <input type="date" id="fecha_de_pago" name="fecha_de_pago" readonly
                        value="{{ old('fecha_de_pago') ?? now()->format('Y-m-d') }}"
                        class="w-full px-3 py-2.5 text-sm text-gray-800 dark:text-white/90 focus:outline-none rounded-l-lg">

                    <span class="px-3 py-2.5 bg-gray-100 dark:bg-gray-800 border-l border-gray-300 dark:border-gray-700 flex items-center justify-center rounded-r-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                            class="h-5 w-5 text-gray-500 dark:text-gray-400" 
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </span>
                </div>

                <div class="min-h-[20px]">
                    @error('fecha_de_pago')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Código de Educando -->
            <div class="grid grid-cols-1 sm:grid-cols-6 gap-2 sm:col-span-2 lg:col-span-2">
                <div class="sm:col-span-3 flex flex-col">
                    <label for="codigo_alumno" class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">Código educando</label>
                    <input type="text" id="codigo_alumno" name="codigo_alumno" value="{{ old('codigo_alumno') }}"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-3 py-2.5 text-sm text-gray-800 dark:text-white/90 focus:ring-2 focus:ring-indigo-500">
                    <div class="min-h-[20px]">
                        @error('codigo_alumno')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                 <!-- Botón alineado al centro -->
                <div class="sm:col-span-3 flex sm:justify-end items-center">
                    @include('components.forms.btn-generar')
                </div>
            </div>

            {{-- Deuda --}}
            <div class="flex flex-col">
                <label for="select_deuda" class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                    Deuda
                </label>
                <select id="select_deuda" name="id_deuda" class="w-full rounded-lg border border-gray-300 dark:border-gray-700  bg-white dark:bg-gray-800 text-sm text-gray-800 dark:text-white/90 px-3 py-2.5 focus:ring-2 focus:ring-indigo-500">
                    <option value="">Seleccione...</option>
                    @foreach($options ?? [] as $key => $option)
                        <option value="{{ $option_values[$key] ?? $key }}"
                            {{ old('id_deuda') == ($option_values[$key] ?? $key) ? 'selected' : '' }}>
                            {{ $option }}
                        </option>
                    @endforeach
                </select>
                <div class="min-h-[20px]">
                    @error('id_deuda')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Monto total a pagar --}}
            <div class="flex flex-col">
                <label for="monto_total_a_pagar" class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                    Monto total a pagar
                </label>
                <input type="text" id="monto_total_a_pagar" name="monto_total_a_pagar"
                    value="{{ old('monto_total_a_pagar') }}" readonly
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 px-3 py-2.5 text-sm text-gray-800 dark:text-white/90">
                <div class="min-h-[20px]">
                    @error('monto_total_a_pagar')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Monto pagado --}}
            <div class="flex flex-col">
                <label for="monto_pagado" class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                    Monto pagado
                </label>
                <input type="text" id="monto_pagado" name="monto_pagado"
                    value="{{ old('monto_pagado') ?? '00.00' }}" readonly
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 px-3 py-2.5 text-sm text-gray-800 dark:text-white/90">
                <div class="min-h-[20px]">
                    @error('monto_pagado')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Observaciones ocupa toda la fila -->
            <div class="col-span-1 sm:col-span-2 lg:col-span-3 flex flex-col">
                <label for="observaciones" class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">Observaciones</label>
                <textarea id="observaciones" name="observaciones" rows="2"
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-3 py-2.5 text-sm text-gray-800 dark:text-white/90 focus:ring-2 focus:ring-indigo-500">{{ old('observaciones') }}</textarea>
                <div class="min-h-[20px]">
                    @error('observaciones')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Detalle de Pago --}}
            <div id="detalles-pago-container" class="col-span-1 sm:col-span-2 lg:col-span-3 mt-8">

                <h2 class="text-lg text-gray-800 dark:text-gray-200">
                    Detalle de Pago
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    {{-- Primer pago --}}
                    <div class="detalle-pago border rounded-lg p-6 bg-gray-50 dark:bg-gray-800/40">
                        <h4 class="text-base text-gray-800 dark:text-gray-200 mb-4">Pago 1</h4>
                        <!-- Estado -->
                        <p id="estado_pago_1"
                            class="hidden text-sm sm:text-base font-semibold px-4 py-2 rounded-xl shadow-md text-center transition-all duration-300">
                        </p>

                        <!-- Método de pago -->
                        <div class="flex flex-col mb-3">
                            <label for="metodo_pago_1" class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                                Método de Pago
                            </label>
                            <select name="metodo_pago[]" id="metodo_pago_1"
                                class="w-full rounded-lg border
                                    {{ $errors->has('metodo_pago.0') ? 'border-red-500' : 'border-gray-300 dark:border-gray-700' }}
                                    bg-white dark:bg-gray-800 text-sm px-3 py-2.5 
                                    text-gray-800 dark:text-white/90 focus:ring-2 focus:ring-indigo-500">
                                <option value="">Seleccione...</option>
                                <option value="tarjeta" {{ old('metodo_pago.0')=='tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                                <option value="yape" {{ old('metodo_pago.0')=='yape' ? 'selected' : '' }}>Yape / Plin</option>
                                <option value="transferencia" {{ old('metodo_pago.0')=='transferencia' ? 'selected' : '' }}>Transferencia</option>
                                <option value="paypal" {{ old('metodo_pago.0')=='paypal' ? 'selected' : '' }}>PayPal</option>
                            </select>
                            @error('metodo_pago.0')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Número de operación -->
                        <div class="flex flex-col mb-3">
                            <label for="detalle_recibo_1" class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                                Nro de operación / recibo
                            </label>
                            <input type="text" name="detalle_recibo[]" id="detalle_recibo_1"
                                value="{{ old('detalle_recibo.0') }}"
                                class="w-full rounded-lg border
                                    {{ $errors->has('detalle_recibo.0') ? 'border-red-500' : 'border-gray-300 dark:border-gray-700' }}
                                    px-3 py-2.5 text-sm text-gray-800 dark:text-white/90 focus:ring-2 focus:ring-indigo-500">
                            @error('detalle_recibo.0')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Monto -->
                        <div class="flex flex-col mb-3">
                            <label for="detalle_monto_1" class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                                Monto
                            </label>
                            <input type="text" name="detalle_monto[]" id="detalle_monto_1"
                                value="{{ old('detalle_monto.0') }}"
                                class="w-full rounded-lg border
                                    {{ $errors->has('detalle_monto.0') ? 'border-red-500' : 'border-gray-300 dark:border-gray-700' }}
                                    px-3 py-2.5 text-sm text-gray-800 dark:text-white/90 focus:ring-2 focus:ring-indigo-500">
                            @error('detalle_monto.0')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fecha -->
                        <div class="flex flex-col mb-3">
                            <label for="detalle_fecha_1" class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                                Fecha de Pago
                            </label>

                            <div class="flex items-center rounded-lg border 
                                {{ $errors->has('detalle_fecha.0') ? 'border-red-500' : 'border-gray-300 dark:border-gray-700' }}
                                focus-within:ring-2 focus-within:ring-indigo-500">

                                <input type="date" name="detalle_fecha[]" id="detalle_fecha_1"
                                    value="{{ old('detalle_fecha.0', now()->format('Y-m-d')) }}"
                                    class="w-full px-3 py-2.5 text-sm text-gray-800 dark:text-white/90 
                                        focus:outline-none rounded-l-lg bg-white dark:bg-gray-800">

                                <!-- Ícono calendario -->
                                <span class="px-3 py-2.5 bg-gray-100 dark:bg-gray-800 border-l border-gray-300 dark:border-gray-700 
                                            flex items-center justify-center rounded-r-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                        class="h-5 w-5 text-gray-500 dark:text-gray-400" 
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </span>
                            </div>

                            @error('detalle_fecha.0')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Voucher 1 (solo para transferencia/yape) -->
                        <div class="flex-col mb-3 hidden" id="voucher_group_1">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                                Constancia de Pago
                                <span class="text-gray-500 text-xs">(JPG, PNG, PDF)</span>
                            </label>

                            <div class="flex items-center rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900">
                                <!-- Input oculto -->
                                <input type="file" name="voucher_path[]" id="voucher_path_1"
                                    class="hidden"
                                    accept=".jpg,.jpeg,.png,.pdf">

                                <!-- Botón con ícono de archivo -->
                                <button type="button" id="btnUploadVoucher_1"
                                    class="w-full flex items-center justify-center gap-2 px-3 py-2.5 text-sm font-medium text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 dark:hover:bg-gray-800 rounded-lg transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                        class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span id="voucher_label_1">Seleccionar archivo</span>
                                </button>
                            </div>

                            @error('voucher_path.0')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Segundo pago --}}
                    <div class="detalle-pago border rounded-xl p-6 bg-gray-50 dark:bg-gray-800/40">
                        <h4 class="text-base text-gray-800 dark:text-gray-200 mb-4">Pago 2</h4>

                        <!-- Estado -->
                        <p id="estado_pago_2"
                            class="hidden text-sm sm:text-base font-semibold px-4 py-2 rounded-full shadow-md text-center transition-all duration-300">
                            <!-- Se rellena por JS -->
                        </p>

                        <!-- Método de pago -->
                        <div class="flex flex-col mb-3">
                            <label for="metodo_pago_2" class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                                Método de Pago
                            </label>
                            <select name="metodo_pago[]" id="metodo_pago_2"
                                class="w-full rounded-lg border 
                                    {{ $errors->has('metodo_pago.1') ? 'border-red-500' : 'border-gray-300 dark:border-gray-700' }}
                                    bg-white dark:bg-gray-800 text-sm px-3 py-2.5 
                                    text-gray-800 dark:text-white/90 focus:ring-2 focus:ring-indigo-500">
                                <option value="">Seleccione...</option>
                                <option value="tarjeta" {{ old('metodo_pago.1')=='tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                                <option value="yape" {{ old('metodo_pago.1')=='yape' ? 'selected' : '' }}>Yape / Plin</option>
                                <option value="transferencia" {{ old('metodo_pago.1')=='transferencia' ? 'selected' : '' }}>Transferencia</option>
                                <option value="paypal" {{ old('metodo_pago.1')=='paypal' ? 'selected' : '' }}>PayPal</option>
                            </select>
                            @error('metodo_pago.1')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Número de operación -->
                        <div class="flex flex-col mb-3">
                            <label for="detalle_recibo_2" class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                                Nro de operación / recibo
                            </label>
                            <input type="text" name="detalle_recibo[]" id="detalle_recibo_2"
                                value="{{ old('detalle_recibo.1') }}"
                                class="w-full rounded-lg border 
                                    {{ $errors->has('detalle_recibo.1') ? 'border-red-500' : 'border-gray-300 dark:border-gray-700' }}
                                    px-3 py-2.5 text-sm text-gray-800 dark:text-white/90 focus:ring-2 focus:ring-indigo-500">
                            @error('detalle_recibo.1')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Monto -->
                        <div class="flex flex-col mb-3">
                            <label for="detalle_monto_2" class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                                Monto
                            </label>
                            <input type="text" name="detalle_monto[]" id="detalle_monto_2"
                                value="{{ old('detalle_monto.1') }}"
                                class="w-full rounded-lg border 
                                    {{ $errors->has('detalle_monto.1') ? 'border-red-500' : 'border-gray-300 dark:border-gray-700' }}
                                    px-3 py-2.5 text-sm text-gray-800 dark:text-white/90 focus:ring-2 focus:ring-indigo-500">
                            @error('detalle_monto.1')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fecha -->
                        <div class="flex flex-col mb-3">
                            <label for="detalle_fecha_2" class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                                Fecha de Pago
                            </label>

                            <div class="flex items-center rounded-lg border 
                                {{ $errors->has('detalle_fecha.1') ? 'border-red-500' : 'border-gray-300 dark:border-gray-700' }}
                                focus-within:ring-2 focus-within:ring-indigo-500">

                                <input type="date" name="detalle_fecha[]" id="detalle_fecha_2"
                                    value="{{ old('detalle_fecha.1', now()->format('Y-m-d')) }}"
                                    class="w-full px-3 py-2.5 text-sm text-gray-800 dark:text-white/90 
                                        focus:outline-none rounded-l-lg bg-white dark:bg-gray-800">

                                <!-- Ícono calendario -->
                                <span class="px-3 py-2.5 bg-gray-100 dark:bg-gray-800 border-l border-gray-300 dark:border-gray-700 
                                            flex items-center justify-center rounded-r-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                        class="h-5 w-5 text-gray-500 dark:text-gray-400" 
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </span>
                            </div>

                            @error('detalle_fecha.1')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Voucher (solo para transferencia/yape) -->
                        <div class="flex-col mb-3 hidden" id="voucher_group_2">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                                Constancia de Pago
                                <span class="text-gray-500 text-xs">(JPG, PNG, PDF)</span>
                            </label>

                            <div class="flex items-center rounded-lg border border-gray-300 dark:border-gray-700 focus-within:ring-2 focus-within:ring-indigo-500 bg-white dark:bg-gray-900">
                                <!-- Input oculto -->
                                <input type="file" name="voucher_path[]" id="voucher_path_2"
                                    class="hidden"
                                    accept=".jpg,.jpeg,.png,.pdf">

                                <!-- Botón con ícono de archivo -->
                                <button type="button" id="btnUploadVoucher_2"
                                    class="w-full flex items-center justify-center gap-2 px-3 py-2.5 text-sm font-medium text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 dark:hover:bg-gray-800 rounded-lg transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                        class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span id="voucher_label_2">Seleccionar archivo</span>
                                </button>
                            </div>

                            @error('voucher_path.1')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>

    @endsection

    @section('custom-js')

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            [1, 2].forEach(n => {
                const input = document.getElementById(`voucher_path_${n}`);
                const btn = document.getElementById(`btnUploadVoucher_${n}`);
                const label = document.getElementById(`voucher_label_${n}`);

                if (btn && input) {
                    // Clic en el botón -> abre input file
                    btn.addEventListener("click", () => input.click());

                    // Cuando selecciona archivo
                    input.addEventListener("change", () => {
                        if (input.files.length > 0) {
                            label.textContent = input.files[0].name;
                            label.classList.remove("text-gray-500");
                            label.classList.add("text-green-600", "font-semibold");
                        } else {
                            label.textContent = "Seleccionar archivo";
                            label.classList.remove("text-green-600", "font-semibold");
                            label.classList.add("text-gray-500");
                        }
                    });
                }
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            const firstById = (ids) => {
                for (const id of ids) {
                    const el = document.getElementById(id);
                    if (el) return el;
                }
                return null;
            };

            const btnGenerar = firstById(['btn-generar', 'btnGenerar']);
            const inputCodigo = firstById(['codigo_alumno', 'codigoAlumno']);
            const selectDeuda = firstById(['select_deuda', 'id_deuda']);
            const montoTotalInput = firstById(['monto_total_a_pagar']);
            const montoPagadoInput = firstById(['monto_pagado']);
            const detallesPagoContainer = firstById(['detalles-pago-container']);
            const overlayPago = firstById(['overlay-pago']);

            if (!btnGenerar || !inputCodigo || !selectDeuda || !montoTotalInput || !montoPagadoInput || !detallesPagoContainer) {
                console.error('Faltan elementos esenciales en el DOM. Revisa: btn-generar, codigo_alumno, select_deuda, monto_total_a_pagar, monto_pagado, detalles-pago-container.');
                return;
            }

            function makePagoMap(n) {
                return {
                    idx: n,
                    estado: firstById([`estado_pago_${n}`]),
                    metodo: firstById([`metodo_pago_${n}`]),
                    recibo: firstById([`detalle_recibo_${n}`]),
                    monto: firstById([`detalle_monto_${n}`]),
                    fecha: firstById([`detalle_fecha_${n}`]),
                    observaciones: firstById([`detalle_observaciones_${n}`]) || null,
                    voucherGroup: firstById([`voucher_group_${n}`]),
                    voucherInput: firstById([`voucher_path_${n}`]),
                    voucherPreview: firstById([`voucher_preview_${n}`])
                };
            }
            const pagosDivs = [ makePagoMap(1), makePagoMap(2) ];

            const toYMD = (d) => {
                if (!d) return '';
                const date = (typeof d === 'string' && d.includes('T')) ? new Date(d) : new Date(d);
                if (isNaN(date)) return d;
                return date.toISOString().split('T')[0];
            };

            const setHidden = (el, hidden = true) => {
                if (!el) return;
                if (hidden) el.classList.add('hidden');
                else el.classList.remove('hidden');
            };

            function limpiarCampos(soft = false) {
                pagosDivs.forEach(div => {
                    if (div.estado) {
                        div.estado.textContent = soft ? 'Cargando...' : '';
                        if (soft) {
                            div.estado.className = 'text-xs font-semibold mb-2 px-4 py-2 rounded-lg text-center bg-gray-200 text-gray-600 shadow-sm';
                            div.estado.classList.remove('hidden');
                        } else {
                            setHidden(div.estado, true);
                        }
                    }
                    if (div.metodo) div.metodo.value = '';
                    if (div.recibo) div.recibo.value = '';
                    if (div.monto) div.monto.value = '';
                    if (div.fecha) div.fecha.value = '';
                    if (div.observaciones) div.observaciones.value = '';
                    if (div.voucherGroup) setHidden(div.voucherGroup, true);
                    if (div.voucherInput) div.voucherInput.value = '';
                    if (div.voucherPreview) div.voucherPreview.innerHTML = '';
                });
            }

            function aplicarValidacionOperacion(inputEl, metodo) {
                if (!inputEl) return null;
                const nuevo = inputEl.cloneNode(true);
                inputEl.parentNode.replaceChild(nuevo, inputEl);
                inputEl = nuevo;

                inputEl.addEventListener('input', function(e) {
                    let val = e.target.value || '';
                    let maxLength = 0;
                    switch((metodo || '').toLowerCase()) {
                        case 'yape':
                        case 'plin':
                            val = val.replace(/[^0-9]/g,''); maxLength = 8; break;
                        case 'transferencia':
                            val = val.replace(/[^0-9]/g,''); maxLength = 12; break;
                        case 'tarjeta':
                            val = val.replace(/[^0-9]/g,''); maxLength = 16; break;
                        case 'paypal':
                            val = val.replace(/[^A-Za-z0-9]/g,''); maxLength = 17; break;
                        default:
                            val = val.replace(/[^A-Za-z0-9]/g,''); maxLength = 17;
                    }
                    if (maxLength && val.length > maxLength) val = val.substring(0, maxLength);
                    e.target.value = val;
                });
                return inputEl;
            }

            function validarDecimales(inputEl) {
                if (!inputEl) return;
                const nuevo = inputEl.cloneNode(true);
                inputEl.parentNode.replaceChild(nuevo, inputEl);
                inputEl = nuevo;

                inputEl.addEventListener('input', function(e) {
                    let v = e.target.value || '';
                    v = v.replace(/[^0-9.]/g,'');
                    const parts = v.split('.');
                    if (parts.length > 2) v = parts[0] + '.' + parts.slice(1).join('');
                    if (parts[1] && parts[1].length > 2) v = parts[0] + '.' + parts[1].slice(0,2);
                    e.target.value = v;
                });

                inputEl.addEventListener('blur', function(e) {
                    const num = parseFloat(e.target.value);
                    if (!isNaN(num)) e.target.value = num.toFixed(2);
                    else e.target.value = '';
                });

                return inputEl;
            }

            function attachMontoSync() {
                const p1 = pagosDivs[0].monto;
                const p2 = pagosDivs[1].monto;
                if (!p1 || !p2) return;

                const validate = () => {
                    const v1 = parseFloat(p1.value) || 0;
                    const v2 = parseFloat(p2.value) || 0;
                    const total = v1 + v2;

                    if (v1 > 500) p1.value = "500.00";
                    if (v2 > 500) p2.value = "500.00";

                    if (total > 500) {
                        const last = document.activeElement;
                        if (last === p1) {
                            const max = 500 - v2;
                            p1.value = max > 0 ? max.toFixed(2) : "";
                        } else if (last === p2) {
                            const max = 500 - v1;
                            p2.value = max > 0 ? max.toFixed(2) : "";
                        }
                    }
                };

                p1.addEventListener("input", validate);
                p2.addEventListener("input", validate);

                p1.addEventListener("blur", () => {
                    const n = parseFloat(p1.value) || 0;
                    p1.value = n ? n.toFixed(2) : "";
                });
                p2.addEventListener("blur", () => {
                    const n = parseFloat(p2.value) || 0;
                    p2.value = n ? n.toFixed(2) : "";
                });
            }

            function cargarPagos(pagos) {
                limpiarCampos();
                if (!Array.isArray(pagos) || pagos.length === 0) {
                    pagosDivs.forEach(ui => {
                        if (ui.metodo) ui.metodo.removeAttribute("disabled");
                        if (ui.recibo) ui.recibo.removeAttribute("readonly");
                        if (ui.monto) ui.monto.removeAttribute("readonly");
                        if (ui.fecha) ui.fecha.removeAttribute("readonly");
                        if (ui.observaciones) ui.observaciones.removeAttribute("readonly");
                        if (ui.voucherInput) ui.voucherInput.removeAttribute("disabled");
                    });
                    return;
                }

                pagos.forEach((det, idx) => {
                    if (idx >= pagosDivs.length) return;
                    const ui = pagosDivs[idx];

                    const estadoRaw = det.estado || det.estado_validacion || '';
                    const estado = (typeof estadoRaw === 'string') ? estadoRaw.toUpperCase() : '';

                    if (estado || (det.monto && parseFloat(det.monto) > 0) || det.nro_recibo) {
                        const isValid = ['VALIDADO','PAGADA','APROBADO'].includes(estado);
                        ui.estado.className = "text-sm font-bold mb-3 px-4 py-2 rounded-lg text-center shadow " +
                            (isValid ? "bg-green-200 text-green-800" : "bg-red-200 text-red-800");
                        ui.estado.textContent = estado || (det.monto ? 'REGISTRADO' : '');
                        ui.estado.classList.remove('hidden');
                    } else {
                        setHidden(ui.estado, true);
                    }

                    if (ui.metodo) { ui.metodo.value = det.metodo_pago || det.metodo || ''; ui.metodo.setAttribute("disabled", true); }
                    if (ui.recibo) { ui.recibo.value = det.nro_recibo || det.nro_recibo_operacion || ''; ui.recibo.setAttribute("readonly", true); }
                    if (ui.monto)  { const m = parseFloat(det.monto || det.monto_pago || 0); ui.monto.value = m ? m.toFixed(2) : ''; ui.monto.setAttribute("readonly", true); }
                    if (ui.fecha)  { ui.fecha.value = det.fecha_pago ? toYMD(det.fecha_pago) : ''; ui.fecha.setAttribute("readonly", true); }
                    if (ui.observaciones) { ui.observaciones.value = det.observacion || det.observaciones || ''; ui.observaciones.setAttribute("readonly", true); }

                    if (['yape','transferencia'].includes((det.metodo_pago || '').toLowerCase()) && ui.voucherGroup) {
                        ui.voucherGroup.classList.remove('hidden');
                        if (ui.voucherPreview) {
                            ui.voucherPreview.innerHTML = `<span class="text-sm text-gray-600">Constancia de pago cargada</span>`;
                        }
                        if (ui.voucherInput) ui.voucherInput.setAttribute("disabled", true);
                    }
                });

                pagosDivs.forEach(ui => {
                    if (ui.recibo && ui.metodo) {
                        const m = ui.metodo.value || '';
                        const newRec = aplicarValidacionOperacion(ui.recibo, m);
                        if (newRec) ui.recibo = newRec;
                    }
                    if (ui.monto) ui.monto = validarDecimales(ui.monto) || ui.monto;
                });

                attachMontoSync();
            }

            btnGenerar.addEventListener('click', async function(e) {
                e.preventDefault();
                const codigo = inputCodigo.value.trim();

                selectDeuda.innerHTML = '';
                montoTotalInput.value = '';
                montoPagadoInput.value = '00.00';

                if (!codigo) {
                    limpiarCampos(false);

                    const opt = document.createElement('option');
                    opt.value = '';
                    opt.textContent = 'Ingrese un código de alumno';
                    selectDeuda.appendChild(opt);
                    return;
                }

                limpiarCampos(true);

                try {
                    const res = await fetch(`/pagos/buscarAlumno/${encodeURIComponent(codigo)}`);
                    if (!res.ok) throw new Error('No encontrado');
                    const data = await res.json();

                    if (!data.success || !Array.isArray(data.deudas) || data.deudas.length === 0) {
                        const opt = document.createElement('option');
                        opt.value = '';
                        opt.textContent = data.message || 'Sin deudas asignadas';
                        selectDeuda.appendChild(opt);
                        limpiarCampos(false);
                        return;
                    }

                    data.deudas.forEach(d => {
                        const opt = document.createElement('option');
                        opt.value = d.id_deuda;
                        opt.textContent = `Periodo ${d.periodo} - ${d.concepto}`;
                        opt.dataset.montoTotal = d.monto_total ?? 0;
                        opt.dataset.montoPagado = d.monto_pagado ?? 0;
                        try { opt.dataset.detalles = JSON.stringify(d.detalles_pago || []); } catch(e) { opt.dataset.detalles = '[]'; }
                        selectDeuda.appendChild(opt);
                    });

                    selectDeuda.selectedIndex = 0;
                    selectDeuda.dispatchEvent(new Event('change'));

                    const primera = data.deudas[0];
                    if (primera && Array.isArray(primera.detalles_pago) && primera.detalles_pago.length > 0) {
                        cargarPagos(primera.detalles_pago);
                    } else {
                        limpiarCampos(false);
                    }

                } catch (err) {
                    console.error(err);
                    const opt = document.createElement('option');
                    opt.value = '';
                    opt.textContent = 'Error al buscar alumno';
                    selectDeuda.appendChild(opt);
                    limpiarCampos(false);
                }
            });

            selectDeuda.addEventListener('change', async function() {
                const opt = selectDeuda.options[selectDeuda.selectedIndex];
                if (!opt) return;

                limpiarCampos(true);

                const montoTotal = parseFloat(opt.dataset.montoTotal || 0) || 0;
                const montoPagado = parseFloat(opt.dataset.montoPagado || 0) || 0;
                montoTotalInput.value = montoTotal.toFixed(2);
                montoPagadoInput.value = montoPagado.toFixed(2);

                const detallesStr = opt.dataset.detalles;
                if (detallesStr) {
                    try {
                        const detalles = JSON.parse(detallesStr);
                        cargarPagos(detalles || []); return;
                    } catch (e) { console.warn('dataset.detalles no válido, se hará fetch:', e); }
                }

                try {
                    const resp = await fetch(`/pagos/buscarDeuda/${encodeURIComponent(opt.value)}`);
                    if (!resp.ok) throw new Error('Error al obtener detalles de deuda');
                    const json = await resp.json();
                    if (json && Array.isArray(json.detalles_pago) && json.detalles_pago.length) {
                        cargarPagos(json.detalles_pago);
                    } else {
                        limpiarCampos(false);
                    }
                } catch (err) {
                    console.error('Error al obtener detalles de deuda:', err);
                    limpiarCampos(false);
                }
            });

            pagosDivs.forEach(ui => {
                if (!ui.metodo) return;
                ui.metodo.addEventListener('change', () => {
                    const metodo = (ui.metodo.value || '').toLowerCase();
                    if (ui.voucherGroup) {
                        if (['yape','transferencia'].includes(metodo)) ui.voucherGroup.classList.remove('hidden');
                        else {
                            ui.voucherGroup.classList.add('hidden');
                            if (ui.voucherInput) ui.voucherInput.value = '';
                            if (ui.voucherPreview) ui.voucherPreview.innerHTML = '';
                        }
                    }
                    if (ui.recibo) ui.recibo = aplicarValidacionOperacion(ui.recibo, metodo);
                });

                if (ui.voucherInput && ui.voucherPreview) {
                    ui.voucherInput.addEventListener('change', function() {
                        const file = this.files && this.files[0];
                        ui.voucherPreview.innerHTML = '';
                        if (!file) return;
                        const name = file.name;
                        ui.voucherPreview.innerHTML = `<span class="text-sm text-gray-600">${name}</span>`;
                    });
                }
            });

            pagosDivs.forEach(ui => {
                if (ui.recibo) ui.recibo = aplicarValidacionOperacion(ui.recibo, (ui.metodo && ui.metodo.value) || '');
                if (ui.monto) ui.monto = validarDecimales(ui.monto) || ui.monto;
            });

            attachMontoSync();
        });
    </script>
@endsection
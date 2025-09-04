@extends('base.administrativo.blank')

@section('titulo')
  Ingrese un pago
@endsection

@section('contenido')
    <div class="p-8 m-4 dark:bg-white/[0.03] rounded-2xl">
        <div class="flex pb-4 justify-between items-center">
        <h2 class="text-lg dark:text-gray-200 text-gray-800">Estás ingresando un Pago</h2>

        <div class="flex gap-4">
            <input form="form" target="" type="submit" form=""
            class="cursor-pointer inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-gray-200 px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-300 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
            value="Ingresar"
            >

            <a
            href="{{ $data["return"] }}"
            class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-gray-200 px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-300 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
            >
            Cancelar
            </a>
        </div>
        </div>

        <form method="POST" id="form" class="grid grid-cols-3 gap-4" action="">
        @method('PUT')
        @csrf

        @include('components.forms.datetime-picker-ineditable',[
            'label' => 'Fecha de Pago',
            'error' => $errors->first(Str::snake('Fecha de Pago')) ?? false,
            'value' => old(Str::snake('Fecha de Pago')) ?? now()->format('Y-m-d\TH:i')
        ])



        <div class="grid grid-cols-5 place-content-center gap-2">
            <div class="col-span-3">
            @include('components.forms.string-pagos',[
                'label' => 'Codigo educando',
                'name' => 'codigo_alumno',
                'error' => $errors->first('codigo_alumno'),
                'attributes' => ['id' => 'codigo_alumno']
            ])
            </div>
            <div class="col-start-4 col-span-2 place-self-center mt-6 mr-2">
                @include('components.forms.btn-generar')
            </div>
        </div>
        

        @include('components.forms.select-deudas', [
            'label' => 'Deuda',
            'name' => 'id_deuda',
            'options' => $options ?? [],
            'option_values' => $option_values ?? [],
            'value' => old('id_deuda'),
            'error' => $errors->first('id_deuda'),
            'attributes' => ['id' => 'select_deuda']
        ])

        @include('components.forms.string-ineditable-monto', [
            'label' => 'Monto total a pagar',
            'name' => 'monto_total_a_pagar',
            'error' => $errors->first('monto_total_a_pagar') ?? false,
            'attributes' => ['id' => 'monto_total_a_pagar', 'readonly' => true],
            'readonly' => true
        ])

        @include('components.forms.string-ineditable-monto', [
            'label' => 'Monto pagado',
            'name' => 'monto_pagado',
            'error' => $errors->first('monto_pagado') ?? false,
            'attributes' => ['id' => 'monto_pagado', 'readonly' => true, 'value' => '00.00'],
            'readonly' => true
        ])

        <div class="col-span-3">

            @include('components.forms.text-area',[
                'label' => 'Observaciones',
                'error' => $errors->first(Str::snake('Observaciones')) ?? false,
                'value' => old(Str::snake('Observaciones'))
            ])  

        </div>


            {{-- Detalle de Pago --}}
            <div id="detalles-pago-container" class="col-span-3 mt-8">
                <h3 class="text-base font-semibold mb-2 text-gray-700 dark:text-gray-200">Detalle de Pago</h3>
                <div class="detalle-pago grid grid-cols-4 gap-4 items-end border rounded-lg p-4 mb-4 bg-gray-50 dark:bg-gray-800/40">
                    {{-- Fecha (sincronizada con la fecha de pago principal) --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">Fecha</label>
                        <input type="datetime-local" name="detalle_fecha[]" class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-sm text-gray-800 dark:text-white/90"
                            id="detalle_fecha_0"
                            value="{{ old('detalle_fecha.0', now()->format('Y-m-d\TH:i')) }}"
                        >
                    </div>
                    {{-- Monto a cancelar --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">Monto a cancelar</label>
                        <input type="text" name="detalle_monto[]" class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-sm text-gray-800 dark:text-white/90"
                            id="detalle_monto_0"
                            value="{{ old('detalle_monto.0') }}"
                            placeholder="0.00"
                        >
                    </div>
                    {{-- Nro de recibo --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">Nro de recibo</label>
                        <input type="text" name="detalle_recibo[]" class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-sm text-gray-800 dark:text-white/90"
                            id="detalle_recibo_0"
                            value="{{ old('detalle_recibo.0') }}"
                            placeholder="Nro de recibo"
                        >
                    </div>
                    {{-- Observaciones --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">Observaciones</label>
                        <textarea name="detalle_observaciones[]" class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-sm text-gray-800 dark:text-white/90"
                            id="detalle_observaciones_0"
                            rows="1"
                            placeholder="Observaciones"></textarea>
                    </div>
                </div>

            </div>
        </form>    
    </div>

            



    @endsection

    @section('custom-js')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const btnGenerar = document.getElementById('btn-generar');
        const inputCodigo = document.getElementById('codigo_alumno');
        const selectDeuda = document.getElementById('select_deuda');
        const montoTotalInput = document.getElementById('monto_total_a_pagar');
        const montoPagadoInput = document.getElementById('monto_pagado');

        if (!btnGenerar || !inputCodigo || !selectDeuda || !montoTotalInput || !montoPagadoInput) {
            console.error('Faltan elementos en el DOM.');
            return;
        }

        btnGenerar.addEventListener('click', async function(e) {
            e.preventDefault();

            const codigo = inputCodigo.value.trim();
            selectDeuda.innerHTML = '';
            montoTotalInput.value = '';
            montoPagadoInput.value = '00.00';

            if (!codigo) {
                const opt = document.createElement('option');
                opt.value = '';
                opt.textContent = 'Ingrese un código de alumno';
                selectDeuda.appendChild(opt);
                return;
            }

            try {
                const response = await fetch(`/pagos/buscarAlumno/${codigo}`);
                if (!response.ok) {
                    throw new Error('No encontrado');
                }
                const data = await response.json();

                if (!data.success) {
                    const opt = document.createElement('option');
                    opt.value = '';
                    opt.textContent = data.message || 'Error al buscar';
                    selectDeuda.appendChild(opt);
                    return;
                }

                if (data.deudas.length === 0) {
                    const opt = document.createElement('option');
                    opt.value = '';
                    opt.textContent = 'Sin deudas asignadas';
                    selectDeuda.appendChild(opt);
                    return;
                }

                data.deudas.forEach(deuda => {
                    const opt = document.createElement('option');
                    opt.value = deuda.id_deuda;
                    opt.textContent = `Periodo ${deuda.periodo} - ${deuda.concepto}`;
                    opt.dataset.monto = deuda.monto_total;
                    selectDeuda.appendChild(opt);
                });

                selectDeuda.selectedIndex = 0;
                selectDeuda.dispatchEvent(new Event('change'));

            } catch (error) {
                console.error(error);
                const opt = document.createElement('option');
                opt.value = '';
                opt.textContent = 'Error al buscar alumno';
                selectDeuda.appendChild(opt);
            }
        });

        selectDeuda.addEventListener('change', function() {
            const selected = selectDeuda.options[selectDeuda.selectedIndex];
            if (!selected || !selected.value) {
                montoTotalInput.value = '';
                montoPagadoInput.value = '00.00';
                return;
            }
            montoTotalInput.value = selected.dataset.monto || '';
            montoPagadoInput.value = '00.00';
        });
    });
    </script>
@endsection


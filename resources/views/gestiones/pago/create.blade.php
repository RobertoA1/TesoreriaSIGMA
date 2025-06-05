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
    <button type="button" id="agregar-detalle" class="mt-2 px-4 py-2 bg-amber-200 rounded-lg font-semibold text-sm text-gray-800 hover:bg-amber-300">
        + Agregar otro detalle de pago
    </button>
</div>


    </form>
    
  </div>

        



@endsection

@section('custom-js')

<script>
    window.alumnos = @json($data['alumnos']);
    window.deudas = @json($data['deudas']);
    window.conceptos = @json($data['conceptos']);
    onsole.log('ALUMNOS:', window.alumnos);
    console.log('DEUDAS:', window.deudas);
    console.log('CONCEPTOS:', window.conceptos);
</script>
<script>
  
document.addEventListener('DOMContentLoaded', function() {
    const btnGenerar = document.getElementById('btn-generar');
    const inputCodigo = document.getElementById('codigo_alumno');
    const selectDeuda = document.getElementById('select_deuda');
    const montoTotalInput = document.getElementById('monto_total_a_pagar');
    const montoPagadoInput = document.getElementById('monto_pagado');

  if (!btnGenerar || !inputCodigo || !selectDeuda || !montoTotalInput || !montoPagadoInput) {
        console.error('Faltan elementos en el DOM. Revisa los ids de los inputs/selects.');
        return;
    }

    // Siempre muestra 00.00 al cargar
    if (montoPagadoInput) montoPagadoInput.value = '00.00';

    btnGenerar.addEventListener('click', function(e) {
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

        // Buscar el alumno por codigo_educando
        const alumno = window.alumnos.find(a => String(a.codigo_educando) === codigo);
        if (!alumno) {
            const opt = document.createElement('option');
            opt.value = '';
            opt.textContent = 'No existe alumno con ese código';
            selectDeuda.appendChild(opt);
            return;
        }

        // Buscar deudas por id_alumno
        const deudas = window.deudas.filter(d => d.id_alumno == alumno.id_alumno);
        if (deudas.length === 0) {
            const opt = document.createElement('option');
            opt.value = '';
            opt.textContent = 'Sin deudas asignadas';
            selectDeuda.appendChild(opt);
            return;
        }

        deudas.forEach(deuda => {
            const concepto = window.conceptos.find(c => c.id_concepto == deuda.id_concepto);
            const textoConcepto = concepto ? concepto.descripcion : 'Sin concepto';
            const opt = document.createElement('option');
            opt.value = deuda.id_deuda;
            opt.textContent = `Periodo ${deuda.periodo} - Concepto ${textoConcepto} `;
            opt.setAttribute('data-monto', deuda.monto_total);
            selectDeuda.appendChild(opt);
        });

        // Selecciona la primera deuda y actualiza el monto
        selectDeuda.selectedIndex = 0;
        selectDeuda.dispatchEvent(new Event('change'));
    });

    selectDeuda.addEventListener('change', function() {
        const selected = selectDeuda.options[selectDeuda.selectedIndex];
        if (!selected || !selected.value) {
            montoTotalInput.value = '';
            montoPagadoInput.value = '00.00';
            return;
        }
        montoTotalInput.value = selected.getAttribute('data-monto') || '';
        montoPagadoInput.value = '00.00';
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Selector del input principal de fecha de pago (readonly)
    const fechaPagoInput = document.querySelector('input[name="fecha_de_pago"]');
    const agregarDetalleBtn = document.getElementById('agregar-detalle');
    const detallesContainer = document.getElementById('detalles-pago-container');

    let detalleIndex = document.querySelectorAll('.detalle-pago').length;

    // Función para sincronizar la fecha principal con la del último detalle
    function syncPrincipalWithLastDetalle() {
        const fechas = document.querySelectorAll('input[name="detalle_fecha[]"]');
        if (fechas.length > 0 && fechaPagoInput) {
            fechaPagoInput.value = fechas[fechas.length - 1].value;
        }
    }

    // Evento para agregar un nuevo detalle de pago
    agregarDetalleBtn.addEventListener('click', function() {
        const now = new Date();
        const fechaActual = now.toISOString().slice(0,16);

        const newDetalle = document.createElement('div');
        newDetalle.className = 'detalle-pago grid grid-cols-4 gap-4 items-end border rounded-lg p-4 mb-4 bg-gray-50 dark:bg-gray-800/40';
        newDetalle.innerHTML = `
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">Fecha</label>
                <input type="datetime-local" name="detalle_fecha[]" class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-sm text-gray-800 dark:text-white/90"
                    id="detalle_fecha_${detalleIndex}"
                    value="${fechaActual}"
                >
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">Monto a cancelar</label>
                <input type="text" name="detalle_monto[]" class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-sm text-gray-800 dark:text-white/90"
                    id="detalle_monto_${detalleIndex}"
                    placeholder="0.00"
                >
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">Nro de recibo</label>
                <input type="text" name="detalle_recibo[]" class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-sm text-gray-800 dark:text-white/90"
                    id="detalle_recibo_${detalleIndex}"
                    placeholder="Nro de recibo"
                >
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">Observaciones</label>
                <textarea name="detalle_observaciones[]" class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-sm text-gray-800 dark:text-white/90"
                    id="detalle_observaciones_${detalleIndex}"
                    rows="1"
                    placeholder="Observaciones"></textarea>
            </div>
        `;
        detallesContainer.insertBefore(newDetalle, agregarDetalleBtn);
        detalleIndex++;

        // Agrega evento para sincronizar la fecha principal cuando cambie la fecha de este detalle
        const fechaInput = newDetalle.querySelector(`input[name="detalle_fecha[]"]`);
        fechaInput.addEventListener('change', syncPrincipalWithLastDetalle);
    });

    // Al cargar, agrega evento al primer detalle para sincronizar la fecha principal
    const primerDetalleFecha = document.querySelector('.detalle-pago input[name="detalle_fecha[]"]');
    if (primerDetalleFecha) {
        primerDetalleFecha.addEventListener('change', syncPrincipalWithLastDetalle);
    }
});
</script>
@endsection


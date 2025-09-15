@extends('base.administrativo.blank')

@section('titulo')
  Crear una Deuda
@endsection

@section('contenido')
  <div class="p-8 m-4 dark:bg-white/[0.03] rounded-2xl">
    <x-ui.section-header
            titulo="Nueva Deuda"
            subtitulo="Registra una nueva deuda en el sistema"
            :returnUrl="$data['return']"
            boton="Ingresar"
    />

    <form method="POST" id="form" class="flex flex-col gap-4 mt-4" action="">
        @method('PUT')
        @csrf

        @include('components.forms.string', [
            'label' => 'Codigo Educando',
            'error' => $errors->first(Str::snake('Codigo Educando')) ?? false,
            'value' => old(Str::snake('Codigo Educando'))
        ])

        @include('components.forms.select-concepto', [
            'label' => 'Concepto de Pago',
            'name' => 'id_concepto',
            'options' => $data['conceptos']->pluck('descripcion')->toArray(),
            'option_values' => $data['conceptos']->pluck('id_concepto')->toArray(),
            'value' => old('id_concepto'),
            'error' => $errors->first('id_concepto')
        ])

        @include('components.forms.select-escalas', [
            'label' => 'Escala',
            'name' => 'escala',
            'options' => [],
            'option_values' => [],
            'value' => old('escala'),
            'error' => $errors->first('escala')
        ])

        @include('components.forms.string-ineditable', [
            'label' => 'Monto Total',
            'error' => $errors->first(Str::snake('Monto Total')) ?? false,
            'value' => old(Str::snake('Monto Total')),
            'readOnly' => true,
        ])

        @include('components.forms.date-picker', [
            'label' => 'Fecha Limite',
            'error' => $errors->first(Str::snake('Fecha Limite')) ?? false,
            'value' => old(Str::snake('Fecha Limite')) ?? now()->toDateString(),
        ])

        @include('components.forms.string', [
            'label' => 'Periodo',
            'error' => $errors->first(Str::snake('Periodo')) ?? false,
            'value' => old('periodo', date('Y'))
        ])

        @include('components.forms.text-area', [
            'label' => 'Observaciones',
            'error' => $errors->first(Str::snake('Observaciones')) ?? false,
            'value' => old(Str::snake('Observaciones'))
        ])
    </form>
  </div>
@endsection

@section('custom-js')
<script>
    window.escalasPorConcepto = @json($data['escalasPorConcepto']);
    window.montosPorConceptoEscala = @json($data['montosPorConceptoEscala']);
</script>
    <script>
  document.addEventListener('DOMContentLoaded', function() {
      const escalasPorConcepto = window.escalasPorConcepto;
      const conceptoSelect = document.querySelector('select[name="id_concepto"]');
      const escalaSelect = document.querySelector('select[name="escala"]');
      const montoInput = document.querySelector('input[name="monto_total"]');

      function actualizarEscalas() {
        const conceptoId = conceptoSelect.value;
        const escalas = escalasPorConcepto[conceptoId] || [];
        const escalaSeleccionada = window.escalaSeleccionada;
        escalaSelect.innerHTML = '';
        escalas.forEach(function(escala) {
            const option = document.createElement('option');
            option.value = escala;
            option.textContent = escala;
            if (escalaSeleccionada && escalaSeleccionada == escala) {
                option.selected = true;
            }
            escalaSelect.appendChild(option);
        });
        actualizarMonto();
    }

    function actualizarMonto() {
          const conceptoId = conceptoSelect.value;
          const escala = escalaSelect.value;
          if (montosPorConceptoEscala[conceptoId] && montosPorConceptoEscala[conceptoId][escala]) {
              montoInput.value = montosPorConceptoEscala[conceptoId][escala];
          } else {
              montoInput.value = '';
          }
      }

      if (conceptoSelect && escalaSelect) {
          conceptoSelect.addEventListener('change', actualizarEscalas);
          actualizarEscalas(); // Inicializa al cargar
      }
  });
</script>
@endsection


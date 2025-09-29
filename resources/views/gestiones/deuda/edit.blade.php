@extends('base.administrativo.blank')

@section('titulo')
  Editar Deuda
@endsection

@section('contenido')
<div class="p-8 m-4 dark:bg-white/[0.03] rounded-2xl">
    <!-- Header -->
    <x-ui.section-header
        titulo="Editar Deuda"
        subtitulo="ID: {{ $data['id'] }}"
        :returnUrl="$data['return']"
        boton="Guardar"
    />

    <form method="POST" id="form" class="flex flex-col gap-4 mt-4" action="">
      @method('PATCH')
      @csrf


      @include('components.forms.date-picker', [
        'label' => 'Fecha Limite',
        'error' => $errors->first(Str::snake('Fecha Limite')) ?? false,
        'value' => old(Str::snake('Fecha Limite')) ?? $data['default'][Str::snake('Fecha Limite')],
      ])

      @include('components.forms.string', [
        'label' => 'Monto total',
        'error' => $errors->first(Str::snake('Monto total')) ?? false,
        'value' => old(Str::snake('Monto Total')) ?? $data['default'][Str::snake('Monto Total')],
      ])

      @include('components.forms.string-ineditable', [
        'label' => 'Periodo',
        'name' => 'periodo',
        'error' => $errors->first(Str::snake('Periodo')) ?? false,
        'value' => old(Str::snake('Periodo')) ?? $data['default'][Str::snake('Periodo')],
        'readonly' => true
        ])

      @include('components.forms.text-area', [
        'label' => 'Observacion',
        'error' => $errors->first(Str::snake('Observacion')) ?? false,
        'value' => old(Str::snake('observacion')) ?? $data['default'][Str::snake('observacion')],
      ])
        <!-- Botones de acción -->
        <x-ui.section-botton
            :returnUrl="$data['return']"
            boton="💾 Guardar Cambios"
        />
    </form>
</div>
@endsection

@section('custom-js')
  <!-- Si es necesario agregar algún JS adicional -->
@endsection

@extends('base.administrativo.blank')

@section('titulo')
  Concepto de Pago | Edición
@endsection

@section('contenido')
<div class="p-8 m-4 bg-gray-100 dark:bg-white/[0.03] rounded-2xl">
    <!-- Header -->
    <x-ui.section-header
        titulo="Editar Concepto de Pago"
        subtitulo="ID: {{ $data['id'] }}"
        :returnUrl="$data['return']"
        boton="Guardar"
    />

    <form method="POST" id="form" class="flex flex-col gap-4 mt-4" action="">
      @method('PATCH')
      @csrf

      @include('components.forms.string-ineditable', [
        'label' => 'Descripción',
        'name' => 'descripción',
        'error' => $errors->first(Str::snake('Descripción')) ?? false,
        'value' => old(Str::snake('Descripción')) ?? $data['default']['descripcion'],
        'readonly' => true
      ])

      @include('components.forms.string-ineditable', [
        'label' => 'Escala',
        'name' => 'escala',
        'error' => $errors->first(Str::snake('Escala')) ?? false,
        'value' => old(Str::snake('Escala')) ?? $data['default']['escala'],
        'readonly' => true
      ])

      @include('components.forms.string', [
        'label' => 'Monto',
        'error' => $errors->first(Str::snake('Monto')) ?? false,
        'value' => old(Str::snake('Monto')) ?? $data['default']['monto']
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
    <script src="{{ asset('js/tables.js') }}"></script>
@endsection

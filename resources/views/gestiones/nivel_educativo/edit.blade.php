@extends('base.administrativo.blank')

@section('titulo')
  Niveles Educativos | Edición
@endsection

@section('contenido')
  <div class="p-8 m-4 bg-gray-100 dark:bg-white/[0.03] rounded-2xl">
    <!-- Header -->
    <x-ui.section-header
            titulo="Editar el Nivel Educativo"
            subtitulo="ID: {{ $data['id'] }}"
            :returnUrl="$data['return']"
            boton="Guardar"
    />

    <form method="POST" id="form" class="flex flex-col gap-4" action="">
      @method('PATCH')
      @csrf

      @include('components.forms.string', [
        'label' => 'Nombre',
        'error' => $errors->first(Str::snake('Nombre')) ?? false,
        'value' => old(Str::snake('Nombre')) ?? $data['default']['nombre']
      ])

      @include('components.forms.text-area',[
        'label' => 'Descripción',
        'error' => $errors->first(Str::snake('Descripción')) ?? false,
        'value' => old(Str::snake('Descripción')) ?? $data['default']['descripción']
      ])

        <!-- Botones de acción -->
        <x-ui.section-botton
                :returnUrl="$data['return']"
                boton="💾 Guardar Cambios"
        />

    </form>
@endsection

@section('custom-js')
  <script src="{{ asset('js/tables.js') }}"></script>
@endsection

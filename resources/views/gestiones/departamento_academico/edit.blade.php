@extends('base.administrativo.blank')

@section('titulo')
  Departamento Académico | Edición
@endsection

@section('contenido')
  <div class="p-8 m-4 bg-gray-100 dark:bg-white/[0.03] rounded-2xl">
    <!-- <div class="flex pb-4 justify-between items-center">
      <h2 class="text-lg dark:text-gray-200 text-gray-800">Estás editando el Departamento Académico con ID {{ $data['id'] }}</h2>

      <div class="flex gap-4">
        <input form="form" target="" type="submit" form=""
          class="cursor-pointer inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-gray-200 px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-300 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
          value="Guardar"
        >

        <a
          href="{{ $data["return"] }}"
          class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-gray-200 px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-300 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
        >
          Cancelar
        </a>
      </div>
    </div> -->
    <!-- Header -->
        <x-ui.section-header
            titulo="Editar Departamento Académico"
            subtitulo="ID: {{ $data['id'] }}"
            :returnUrl="$data['return']"
            boton="Guardar"
        />

    <form method="POST" id="form" class="flex flex-col gap-4 mt-4" action="">
      @method('PATCH')
      @csrf

      @include('components.forms.string', [
        'label' => 'Nombre',
        'error' => $errors->first(Str::snake('Nombre')) ?? false,
        'value' => old(Str::snake('Nombre')) ?? $data['default']['nombre']
      ])

      <!-- Botones de acción en la parte inferior -->
        <x-ui.section-botton
            :returnUrl="$data['return']"
            boton="💾 Guardar Cambios"
        />
    </form>
@endsection

@section('custom-js')
  <script src="{{ asset('js/tables.js') }}"></script>
@endsection

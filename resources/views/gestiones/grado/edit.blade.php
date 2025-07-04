@extends('base.administrativo.blank')

@section('titulo')
  Grado | Edición
@endsection

@section('extracss')
@endsection

@section('contenido')
  <div class="p-8 m-4 bg-gray-100 dark:bg-white/[0.03] rounded-2xl">
    <div class="flex pb-4 justify-between items-center">
      <h2 class="text-lg dark:text-gray-200 text-gray-800">Estás editando el Grado con ID {{ $data['id'] }}</h2>

      <div class="flex gap-4">
        <input form="form" type="submit"
          class="cursor-pointer inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-gray-200 px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-300 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
          value="Guardar"
        >

        <a
          href="{{ $data['return'] }}"
          class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-gray-200 px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-300 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
        >
          Cancelar
        </a>
      </div>
    </div>

    <form method="POST" id="form" class="flex flex-col gap-4" action="">
      @method('PATCH')
      @csrf

    @include('components.forms.string-ineditable', [
        'label' => 'ID',
        'name' => 'id',
        'error' => $errors->first('id') ?? false,
        'value' => $data['id'],
        'readonly' => true
    ])

    @include('components.forms.string', [
        'label' => 'Nombre del Grado',
        'name' => 'Nombre del Grado',
        'error' => $errors->first(Str::snake('Nombre del Grado')) ?? false,
        'value' => old(Str::snake('Nombre del Grado')) ?? $data['default']['nombre_del_grado']
    ])

    @include('components.forms.combo', [
        'label' => 'Nivel Educativo',
        'error' => $errors->first('nivel_educativo') ?? false,
        'value' => old('nivel_educativo', $data['default']['id_nivel']) ?? $data['default']['id_nivel'],
        'options' => $data['niveles'],
        'options_attributes' => ['id_nivel', 'descripcion']
    ])

    </form>
  </div>
@endsection

@section('custom-js')
  <script src="{{ asset('js/tables.js') }}"></script>
@endsection

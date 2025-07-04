@extends('base.administrativo.blank')

@section('titulo')
  Crear un Grado
@endsection

@section('contenido')
  <div class="p-8 m-4 dark:bg-white/[0.03] rounded-2xl">
    <div class="flex pb-4 justify-between items-center">
      <h2 class="text-lg dark:text-gray-200 text-gray-800">Estás creando un Grado</h2>

      <div class="flex gap-4">
        <input form="form" type="submit"
          class="cursor-pointer inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-gray-200 px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-300 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
          value="crear"
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
      @method('PUT')
      @csrf

      @include('components.forms.string', [
        'label' => 'Nombre del Grado',
        'error' => $errors->first(Str::snake('Nombre del Grado')) ?? false,
        'value' => old(Str::snake('Nombre del Grado'))
      ])

      @include('components.forms.combo', [
        'label' => 'Nivel Educativo',
        'error' => $errors->first(Str::snake('NivelEducativo')) ?? false,
        'value' => old(Str::snake('NivelEducativo')), // null o vacío
        'options' => $data['niveles'],
        'options_attributes' => ['id_nivel', 'descripcion']
    ])
    </form>
  </div>
@endsection

@section('custom-js')

@endsection

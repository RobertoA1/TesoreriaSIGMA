@extends('base.administrativo.blank')

@section('titulo')
  Registrar una Cátedra
@endsection

@section('contenido')
  <div class="p-8 m-4 dark:bg-white/[0.03] rounded-2xl">
    <div class="flex pb-4 justify-between items-center">
      <h2 class="text-lg dark:text-gray-200 text-gray-800">Estás editando la cátedra con ID {{$data['id']}}</h2>

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
    </div>

    <form method="POST" id="form" class="flex flex-col gap-4" action="">
      @method('PATCH')
      @csrf

      @include('components.forms.select', [
        'label' => 'Nivel educativo',
        'error' => $errors->first(Str::snake('Nivel educativo')) ?? false,
        'option_values' => $data['valores'],
        'options' => $data['niveles'],
        'value' => old(Str::snake('Nivel educativo')) ?? $data['default'][Str::snake('Nivel educativo')],
      ])

      @include('components.forms.string', [
        'label' => 'Código del Curso',
        'error' => $errors->first(Str::snake('Código del Curso')) ?? false,
        'value' => old(Str::snake('Código del Curso')) ?? $data['default'][Str::snake('Código del Curso')],
      ])

      @include('components.forms.string', [
        'label' => 'Nombre del Curso',
        'error' => $errors->first(Str::snake('Nombre del Curso')) ?? false,
        'value' => old(Str::snake('Nombre del Curso')) ?? $data['default'][Str::snake('Nombre del Curso')]
      ])

    </form>
  </div>
@endsection

@section('custom-js')
    
@endsection


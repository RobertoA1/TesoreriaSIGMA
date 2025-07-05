@extends('base.administrativo.blank')

@section('titulo')
  Crear una Seccion
@endsection

@section('contenido')
  <div class="p-8 m-4 dark:bg-white/[0.03] rounded-2xl">
    <div class="flex pb-4 justify-between items-center">
      <h2 class="text-lg dark:text-gray-200 text-gray-800">Estás creando una Seccion</h2>

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

          @include('components.forms.combo_dependient', [
              'label' => 'Nivel Educativo',
              'name' => 'nivel_educativo',
              'error' => $errors->first(Str::snake('Nivel Educativo')) ?? false,
              'placeholder' => 'Seleccionar nivel educativo...',
              'value' => old(Str::snake('Nivel Educativo')),
              'value_field' => 'id_nivel',
              'text_field' => 'nombre_nivel',
              'options' => $data['niveles'],
              'enabled' => true,
          ])

          @include('components.forms.combo_dependient', [
              'label' => 'Grado',
              'name' => 'grado',
              'error' => $errors->first(Str::snake('Grado')) ?? false,
              'placeholder' => 'Seleccionar grado...',
              'depends_on' => 'nivel_educativo',
              'parent_field' => 'id_nivel',
              'value' => old(Str::snake('Grado')),
              'value_field' => 'id_grado',
              'text_field' => 'nombre_grado',
              'options' => $data['grados'],
              'enabled' => false,
          ])

          @include('components.forms.string', [
            'label' => 'Seccion',
            'error' => $errors->first(Str::snake('Seccion')) ?? false,
            'value' => old(Str::snake('Seccion'))
          ])

      
    </form>
  </div>
@endsection

@section('custom-js')

@endsection

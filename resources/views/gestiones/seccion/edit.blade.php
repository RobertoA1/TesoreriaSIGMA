@extends('base.administrativo.blank')

@section('titulo')
  Sección | Edición
@endsection

@section('extracss')
@endsection

@section('contenido')
  <div class="p-8 m-4 bg-gray-100 dark:bg-white/[0.03] rounded-2xl">
    <div class="flex pb-4 justify-between items-center">
      <h2 class="text-lg dark:text-gray-200 text-gray-800">Estás editando la Sección {{ $data['id']['nombreSeccion'] }} - Grado {{ $data['id']['nombreGrado'] }}</h2>

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

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" id="error_mess">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" id="form" class="flex flex-col gap-4" action="">
      @method('PATCH')
      @csrf

          @include('components.forms.combo_dependient', [
              'label' => 'Nivel Educativo',
              'name' => 'nivel_educativo',
              'error' => $errors->first(Str::snake('Nivel Educativo')) ?? false,
              'placeholder' => 'Seleccionar nivel educativo...',
              'value' => old(Str::snake('Nivel Educativo')) ?? $data['default'][Str::snake('Nivel educativo')],
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
              'value' => old(Str::snake('Grado')) ?? $data['default'][Str::snake('Grado')],
              'value_field' => 'id_grado',
              'text_field' => 'nombre_grado',
              'options' => $data['grados'],
              'enabled' => false,
          ])

          @include('components.forms.string', [
            'label' => 'Seccion',
            'error' => $errors->first(Str::snake('Seccion')) ?? false,
            'value' => old(key: Str::snake('Seccion')) ?? $data['default'][Str::snake('Seccion')],
          ])
    

    </form>
  </div>
@endsection

@section('custom-js')
  <script src="{{ asset('js/tables.js') }}"></script>
  <script>
    setTimeout(() => {
         document.getElementById('error_mess').style.display = "none";
    }, 3000);
  </script>
@endsection

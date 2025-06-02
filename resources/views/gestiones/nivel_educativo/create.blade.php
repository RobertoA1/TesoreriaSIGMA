@extends('base.administrativo.blank')

@section('titulo')
  {{ $data['titulo'] }}
@endsection

@section('contenido')
  <div class="p-8 m-4 dark:bg-white/[0.03] rounded-2xl">
    <div class="flex pb-4 justify-between items-center">
      <h2 class="text-lg dark:text-gray-200 text-gray-800">Estás creando un nuevo Nivel Educativo</h2>

      <div class="flex gap-4">
        <button 
          class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-gray-200 px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-300 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
        >
          Crear
        </button>

        <button 
          class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-gray-200 px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-300 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
        >
          Cancelar
        </button>
      </div>
    </div>

    <form class="flex flex-col gap-4" action="">

      @include('components.forms.string', [
        'label' => 'Nombre'  
      ])

      @include('components.forms.text-area',[
        'label' => 'Descripción'
      ])

    </form>
    
  </div>
@endsection

@section('custom-js')
  <script src="{{ asset('js/tables.js') }}"></script>
@endsection
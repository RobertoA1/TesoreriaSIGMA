@extends('base.administrativo.blank')

@section('titulo')
  Crear una Deuda
@endsection

@section('contenido')
  <div class="p-8 m-4 dark:bg-white/[0.03] rounded-2xl">
    <div class="flex pb-4 justify-between items-center">
      <h2 class="text-lg dark:text-gray-200 text-gray-800">Estás creando una Deuda</h2>

      <div class="flex gap-4">
        <input form="form" target="" type="submit" form=""
          class="cursor-pointer inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-gray-200 px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-300 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
          value="Crear"
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
      @method('PUT')
      @csrf

      @include('components.forms.date-picker', [
        'label' => 'Fecha Limite',
        'error' => $errors->first(Str::snake('Fecha Limite')) ?? false,
        'value' => old(Str::snake('Fecha Limite')) ?? now()->toDateString(),
      ])

      @include('components.forms.string', [
        'label' => 'Monto Total',
        'error' => $errors->first(Str::snake('Monto Total')) ?? false,
        'value' => old(Str::snake('Monto Total'))
      ])

      @include('components.forms.string', [
        'label' => 'Periodo',
        'error' => $errors->first(Str::snake('Periodo')) ?? false,
        'value' => old(Str::snake('Periodo'))
      ])

      @include('components.forms.string', [
        'label' => 'Monto A Cuenta',
        'error' => $errors->first(Str::snake('Monto A Cuenta')) ?? false,
        'value' => old(Str::snake('Monto A Cuenta'))
      ])

      @include('components.forms.string', [
        'label' => 'Monto Adelantado',
        'error' => $errors->first(Str::snake('Monto Adelantado')) ?? false,
        'value' => old(Str::snake('Monto Adelantado'))
      ])

      @include('components.forms.string', [
        'label' => 'Observaciones',
        'error' => $errors->first(Str::snake('Observaciones')) ?? false,
        'value' => old(Str::snake('Observaciones'))
      ])

    </form>
  </div>
@endsection

@section('custom-js')
    
@endsection


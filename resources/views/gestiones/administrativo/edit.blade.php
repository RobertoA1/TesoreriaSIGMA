@extends('base.administrativo.blank')

@section('titulo')
  Editar un Administrativo
@endsection

@section('contenido')
  <div class="p-8 m-4 dark:bg-white/[0.03] rounded-2xl">
    <div class="flex pb-4 justify-between items-center">
      <h2 class="text-lg dark:text-gray-200 text-gray-800">Estás editando un Administrativo</h2>

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

      <div class="grid grid-cols-5 grid-rows-3 gap-4">
        <div class="col-span-5 grid grid-cols-4 gap-8">
          @include('components.forms.string', [
              'label' => 'Apellido paterno',
              'error' => $errors->first(Str::snake('Apellido paterno')) ?? false,
              'value' => old(Str::snake('Apellido paterno')) ?? $data['default']['apellido_paterno']
          ])

          @include('components.forms.string', [
              'label' => 'Apellido materno',
              'error' => $errors->first(Str::snake('Apellido materno')) ?? false,
              'value' => old(Str::snake('Apellido materno')) ?? $data['default']['apellido_materno']
          ])

          @include('components.forms.string', [
              'label' => 'Primer nombre',
              'error' => $errors->first(Str::snake('Primer nombre')) ?? false,
              'value' => old(Str::snake('Primer nombre')) ?? $data['default']['primer_nombre']
          ])

          @include('components.forms.string', [
              'label' => 'Otros nombres',
              'error' => $errors->first(Str::snake('Otros nombres')) ?? false,
              'value' => old(Str::snake('Otros nombres')) ?? $data['default']['otros_nombres']
          ])
        </div>

        <div class="col-span-5 grid grid-cols-4 gap-8">
          @include('components.forms.string', [
              'label' => 'DNI',
              'error' => $errors->first(Str::snake('DNI')) ?? false,
              'value' => old(Str::snake('DNI')) ?? $data['default']['dni']
          ])

          @include('components.forms.string', [
              'label' => 'Teléfono',
              'error' => $errors->first(Str::snake('Teléfono')) ?? false,
              'value' => old(Str::snake('Teléfono')) ?? $data['default']['telefono']
          ])

          @include('components.forms.string', [
              'label' => 'Seguro social',
              'error' => $errors->first(Str::snake('Seguro social')) ?? false,
              'value' => old(Str::snake('Seguro social')) ?? $data['default']['seguro_social']
          ])

          @include('components.forms.select', [
              'label' => 'Estado civil',
              'error' => $errors->first(Str::snake('Estado civil')) ?? false,
              'option_values' => ['S', 'C', 'V', 'D'],
              'options' => ['Soltero', 'Casado', 'Viudo', 'Divorciado'],
              'value' => old(Str::snake('Estado civil')) ?? $data['default']['estado_civil'],
          ])
        </div>

        <div class="col-span-5 grid grid-cols-4  gap-8">
          @include('components.forms.string', [
              'label' => 'Dirección',
              'error' => $errors->first(Str::snake('Dirección')) ?? false,
              'value' => old(Str::snake('Dirección')) ?? $data['default']['direccion']
          ])

          @include('components.forms.date-picker', [
              'label' => 'Fecha de Ingreso',
              'error' => $errors->first(Str::snake('Fecha de Ingreso')) ?? false,
              'value' => old(Str::snake('Fecha de Ingreso')) ?? $data['default']['fecha_ingreso']
          ])

          @include('components.forms.select', [
              'label' => 'Cargo',
              'error' => $errors->first(Str::snake('Cargo')) ?? false,
              'option_values' => ['Secretaria', 'Director', 'Administrador del Sistema'],
              'options' => ['Secretaria', 'Director', 'Administrador del Sistema'],
              'value' => old(Str::snake('Cargo')) ?? $data['default']['cargo'],
          ])

          @include('components.forms.string', [
              'label' => 'Sueldo',
              'error' => $errors->first(Str::snake('Sueldo')) ?? false,
              'value' => old(Str::snake('Sueldo')) ?? $data['default']['sueldo']
          ])
        </div>
      </div>
    </form>
  </div>
@endsection

@section('custom-js')
    
@endsection


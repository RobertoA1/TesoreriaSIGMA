@extends('base.administrativo.blank')

@section('titulo')
  Crear un Docente
@endsection

@section('contenido')
  <div class="p-8 m-4 dark:bg-white/[0.03] rounded-2xl">
    <div class="flex pb-4 justify-between items-center">
      <h2 class="text-lg dark:text-gray-200 text-gray-800">Estás creando un Docente</h2>

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
        'label' => 'Dni',
        'error' => $errors->first(Str::snake('Dni')) ?? false,
        'value' => old(Str::snake('Dni'))
      ])

      @include('components.forms.string', [
        'label' => 'Codigo de Personal',
        'error' => $errors->first(Str::snake('Codigo de Personal')) ?? false,
        'value' => old(Str::snake('Codigo de Personal'))
      ])

      @include('components.forms.string', [
        'label' => 'Apellido Paterno',
        'error' => $errors->first(Str::snake('Apellido Paterno')) ?? false,
        'value' => old(Str::snake('Apellido Paterno'))
      ])

      @include('components.forms.string', [
        'label' => 'Apellido Materno',
        'error' => $errors->first(Str::snake('Apellido Materno')) ?? false,
        'value' => old(Str::snake('Apellido Materno'))
      ])

      @include('components.forms.string', [
        'label' => 'Primer Nombre',
        'error' => $errors->first(Str::snake('Primer Nombre')) ?? false,
        'value' => old(Str::snake('Primer Nombre'))
      ])

      @include('components.forms.string', [
        'label' => 'Otros Nombres',
        'error' => $errors->first(Str::snake('Otros Nombres')) ?? false,
        'value' => old(Str::snake('Otros Nombres'))
      ])

      @include('components.forms.string', [
        'label' => 'Direccion',
        'error' => $errors->first(Str::snake('Direccion')) ?? false,
        'value' => old(Str::snake('Direccion'))
      ])

      @include('components.forms.combo', [
        'label' => 'Estado Civil',
        'error' => $errors->first(Str::snake('Estado Civil')) ?? false,
        'value' => old(Str::snake('Estado Civil')),
        'options' => $data['estadosCiviles'],
        'options_attributes' => ['id', 'descripcion']
      ])

      @include('components.forms.string', [
        'label' => 'Telefono',
        'error' => $errors->first(Str::snake('Telefono')) ?? false,
        'value' => old(Str::snake('Telefono'))
      ])

      @include('components.forms.string', [
        'label' => 'Seguro social',
        'error' => $errors->first(Str::snake('Seguro social')) ?? false,
        'value' => old(Str::snake('Seguro social'))
      ])

      @include('components.forms.date', [
            'label' => 'Fecha Ingreso',
            'error' => $errors->first(Str::snake('Fecha Ingreso')) ?? false,
            'value' => old(Str::snake('Fecha Ingreso'))
          ])

      @include('components.forms.combo', [
        'label' => 'Departamento',
        'error' => $errors->first(Str::snake('Departamento')) ?? false,
        'value' => old(Str::snake('Departamento')), 
        'options' => $data['departamentos'],
        'options_attributes' => ['id_departamento', 'nombre']
        ])

      @include('components.forms.combo', [
        'label' => 'Categoria',
        'error' => $errors->first(Str::snake('Categoria')) ?? false,
        'value' => old(Str::snake('Categoria')), 
        'options' => $data['categorias'],
        'options_attributes' => ['id', 'descripcion']
        ])
    </form>
  </div>
@endsection

@section('custom-js')

@endsection

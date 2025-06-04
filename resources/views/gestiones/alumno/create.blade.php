@extends('base.administrativo.blank')

@section('titulo')
  Crear un alumno
@endsection

@section('contenido')
  <div class="p-8 m-4 dark:bg-white/[0.03] rounded-2xl">
    <div class="flex pb-4 justify-between items-center">
      <h2 class="text-lg dark:text-gray-200 text-gray-800">Estás creando Alumno</h2>

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

      <div class="grid-cols-1 gap-4 grid sm:grid-cols-2 md:grid-cols-4">
        <div>
          @include('components.forms.string', [
          'label' => 'Codigo Educando',
          'error' => $errors->first(Str::snake('Codigo Educando')) ?? false,
          'value' => old(Str::snake('Codigo Educando'))
          ])
        </div>
        <div>
          @include('components.forms.string', [
            'label' => 'Codigo Modular',
            'error' => $errors->first(Str::snake('Codigo Modular')) ?? false,
            'value' => old(Str::snake('Codigo Modular'))
          ])
        </div>
        <div>
          @include('components.forms.date-año', [
            'label' => 'Año de Ingreso',
            'error' => $errors->first(Str::snake('Año de Ingreso')) ?? false,
            'value' => old(Str::snake('Año de Ingreso'))
          ])
        </div>
        <div>
          @include('components.forms.string', [
            'label' => 'DNI',
            'error' => $errors->first(Str::snake('DNI')) ?? false,
            'value' => old(Str::snake('DNI'))
          ])
        </div> 
      </div>

      <div class="grid-cols-1 gap-4 grid sm:grid-cols-2 md:grid-cols-4">
        <div>
          @include('components.forms.string', [
            'label' => 'Apellido Paterno',
            'error' => $errors->first(Str::snake('Apellido Paterno')) ?? false,
            'value' => old(Str::snake('Apellido Paterno'))
          ])
        </div>
        <div>
          @include('components.forms.string', [
            'label' => 'Apellido Materno',
            'error' => $errors->first(Str::snake('Apellido Materno')) ?? false,
            'value' => old(Str::snake('Apellido Materno'))
          ])
        </div>
        <div>
          @include('components.forms.string', [
            'label' => 'Primer Nombre',
            'error' => $errors->first(Str::snake('Primer Nombre')) ?? false,
            'value' => old(Str::snake('Primer Nombre'))
          ])
        </div>
        <div>
          @include('components.forms.string', [
            'label' => 'Otros Nombres',
            'error' => $errors->first(Str::snake('Otros Nombres')) ?? false,
            'value' => old(Str::snake('Otros Nombres'))
          ])
        </div> 

      </div>

      <div class="grid-cols-1 gap-4 grid sm:grid-cols-2 md:grid-cols-4">
        <div>
          @include('components.forms.string', [
            'label' => 'Sexo',
            'error' => $errors->first(Str::snake('Sexo')) ?? false,
            'value' => old(Str::snake('Sexo'))
          ])
        </div> 
        <div>
          @include('components.forms.date', [
            'label' => 'Fecha Nacimiento',
            'error' => $errors->first(Str::snake('Fecha Nacimiento')) ?? false,
            'value' => old(Str::snake('Fecha Nacimiento'))
          ])
        </div> 
        <div>
          @include('components.forms.string', [
            'label' => 'Telefono',
            'error' => $errors->first(Str::snake('Telefono')) ?? false,
            'value' => old(Str::snake('Telefono'))
          ])
        </div> 
        <div>
          @include('components.forms.string', [
            'label' => 'Escala',
            'error' => $errors->first(Str::snake('Escala')) ?? false,
            'value' => old(Str::snake('Escala'))
          ])
        </div> 

      </div>

      <div class="grid-cols-1 gap-4 grid sm:grid-cols-2 md:grid-cols-4">
        <div>
          @include('components.forms.string', [
            'label' => 'Pais',
            'error' => $errors->first(Str::snake('Pais')) ?? false,
            'value' => old(Str::snake('Pais'))
          ])
        </div> 
        <div>
          @include('components.forms.string', [
            'label' => 'Departamento',
            'error' => $errors->first(Str::snake('Departamento')) ?? false,
            'value' => old(Str::snake('Departamento'))
          ])
        </div> 
        <div>
          @include('components.forms.string', [
            'label' => 'Provincia',
            'error' => $errors->first(Str::snake('Provincia')) ?? false,
            'value' => old(Str::snake('Provincia'))
          ])
        </div> 
        <div>
          @include('components.forms.string', [
            'label' => 'Distrito',
            'error' => $errors->first(Str::snake('Distrito')) ?? false,
            'value' => old(Str::snake('Distrito'))
          ])
        </div> 
      </div>

      <div class="grid-cols-1 gap-4 grid sm:grid-cols-2 md:grid-cols-4">
        <div>
          @include('components.forms.string', [
            'label' => 'Lengua Materna',
            'error' => $errors->first(Str::snake('Lengua Materna')) ?? false,
            'value' => old(Str::snake('Lengua Materna'))
          ])
        </div> 
        <div>
          @include('components.forms.string', [
            'label' => 'Estado Civil',
            'error' => $errors->first(Str::snake('Estado Civil')) ?? false,
            'value' => old(Str::snake('Estado Civil'))
          ])
        </div> 
        <div>
          @include('components.forms.string', [
            'label' => 'Religion',
            'error' => $errors->first(Str::snake('Religion')) ?? false,
            'value' => old(Str::snake('Religion'))
          ])
        </div> 
        <div>
          @include('components.forms.date', [
            'label' => 'Fecha Bautizo',
            'error' => $errors->first(Str::snake('Fecha Bautizo')) ?? false,
            'value' => old(Str::snake('Fecha Bautizo'))
          ])
        </div> 
      </div>

      <div class="grid-cols-1 gap-4 grid sm:grid-cols-2 ">
        <div>
          @include('components.forms.string', [
            'label' => 'Parroquia de Bautizo',
            'error' => $errors->first(Str::snake('Parroquia de Bautizo')) ?? false,
            'value' => old(Str::snake('Parroquia de Bautizo'))
          ])
        </div> 
        <div>
          @include('components.forms.string', [
            'label' => 'Colegio de Procedencia',
            'error' => $errors->first(Str::snake('Colegio de Procedencia')) ?? false,
            'value' => old(Str::snake('Colegio de Procedencia'))
          ])
        </div> 

      </div>

      <div class="grid-cols-1 gap-4 grid sm:grid-cols-2 md:grid-cols-4">
        <div class="col-span-2">
          @include('components.forms.string', [
            'label' => 'Direccion',
            'error' => $errors->first(Str::snake('Direccion')) ?? false,
            'value' => old(Str::snake('Direccion'))
          ])
        </div>
        <div >
          @include('components.forms.string', [
            'label' => 'Medio de Transporte',
            'error' => $errors->first(Str::snake('Medio de Transporte')) ?? false,
            'value' => old(Str::snake('Medio de Transporte'))
          ])
        </div> 
        <div >
          @include('components.forms.string', [
            'label' => 'Tiempo de demora',
            'error' => $errors->first(Str::snake('Tiempo de demora')) ?? false,
            'value' => old(Str::snake('Tiempo de demora'))
          ])
        </div> 
      </div>

      <div class="grid-cols-1 gap-4 grid sm:grid-cols-2 md:grid-cols-4">
        <div>
          @include('components.forms.string', [
            'label' => 'Material Vivienda',
            'error' => $errors->first(Str::snake('Material Vivienda')) ?? false,
            'value' => old(Str::snake('Material Vivienda'))
          ])
        </div> 
        <div>
          @include('components.forms.string', [
            'label' => 'Energia Electrica',
            'error' => $errors->first(Str::snake('Energia Electrica')) ?? false,
            'value' => old(Str::snake('Energia Electrica'))
          ])
        </div> 
        <div>
          @include('components.forms.string', [
            'label' => 'Agua Potable',
            'error' => $errors->first(Str::snake('Agua Potable')) ?? false,
            'value' => old(Str::snake('Agua Potable'))
          ])
        </div> 
        <div>
          @include('components.forms.string', [
            'label' => 'Desague',
            'error' => $errors->first(Str::snake('Desague')) ?? false,
            'value' => old(Str::snake('Desague'))
          ])
        </div> 
      </div>

      <div class="grid-cols-1 gap-4 grid sm:grid-cols-2 md:grid-cols-4">
        <div>
          @include('components.forms.string', [
            'label' => 'SS_HH',
            'error' => $errors->first(Str::snake('SS_HH')) ?? false,
            'value' => old(Str::snake('SS_HH'))
          ])
        </div> 
        <div>
          @include('components.forms.string', [
            'label' => 'Numero de Habitaciones',
            'error' => $errors->first(Str::snake('Numero de Habitaciones')) ?? false,
            'value' => old(Str::snake('Numero de Habitaciones'))
          ])
        </div> 
        <div>
          @include('components.forms.string', [
            'label' => 'Numero de Habitantes',
            'error' => $errors->first(Str::snake('Numero de Habitantes')) ?? false,
            'value' => old(Str::snake('Numero de Habitantes'))
          ])
        </div> 
        <div>
          @include('components.forms.string', [
            'label' => 'Situacion de vivienda',
            'error' => $errors->first(Str::snake('Situacion de vivienda')) ?? false,
            'value' => old(Str::snake('Situacion de vivienda'))
          ])
        </div> 
      </div>


  
    </form>
    
  </div>
@endsection

@section('custom-js')
    
@endsection


@extends('base.administrativo.blank')

@section('titulo')
  Ingrese un pago
@endsection

@section('contenido')
  <div class="p-8 m-4 dark:bg-white/[0.03] rounded-2xl">
    <div class="flex pb-4 justify-between items-center">
      <h2 class="text-lg dark:text-gray-200 text-gray-800">Estás ingresando un Pago</h2>

      <div class="flex gap-4">
        <input form="form" target="" type="submit" form=""
          class="cursor-pointer inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-gray-200 px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-300 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
          value="Ingresar"
        >

        <a
          href="{{ $data["return"] }}"
          class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-gray-200 px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-300 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
        >
          Cancelar
        </a>
      </div>
    </div>

    <form method="POST" id="form" class="grid grid-cols-3 gap-4" action="">
      @method('PUT')
      @csrf

      @include('components.forms.string', [
        'label' => 'Nro de Recibo',
        'error' => $errors->first(Str::snake('Número de Recibo')) ?? false,
        'value' => old(Str::snake('Número de Recibo'))
      ])

      @include('components.forms.date-picker-periodo',[
        'label' => 'Fecha de Pago',
        'error' => $errors->first(Str::snake('Fecha de Pago')) ?? false,
        'value' => old(Str::snake('Fecha de Pago')) ?? now()->toDateString()
      ])

      @include('components.forms.string-periodo',[
        'label' => 'Periodo',
        'error' => $errors->first(Str::snake('Periodo')) ?? false,
        'value' => old(Str::snake('Periodo')) ?? now()->year,
        'attributes' => ['id' => 'periodo']
      ])

      <div class="grid grid-cols-5 place-content-center gap-8">
        <div class="col-span-3">
          @include('components.forms.string',[
            'label' => 'Codigo del Alumno',
            'error' => $errors->first(Str::snake('Codigo del Alumno')) ?? false,
            'value' => old(Str::snake('Codigo del Alumno')),
            'attributes' => ['id' => 'codigo_alumno']
          ])
        </div>
        <div class="col-start-4 col-span-1 place-self-center mt-8 mx-2">
            @include('components.forms.btn-generar')
        </div>
        
        
        
      </div>
      

      @include('components.forms.select',[
        'label' => 'Deuda',
        'error' => $errors->first(Str::snake('Deuda')) ?? false,
        'options' => old(Str::snake('Deuda')) ? $data['deudas'] : [],
        'attributes' => ['id' => 'select_deuda']
      ])

      @include('components.forms.string',[
        'label' => 'Monto',
        'error' => $errors->first(Str::snake('Monto')) ?? false,
        'value' => old(Str::snake('Monto'))
      ])
      <div class="col-span-3">

      @include('components.forms.text-area',[
        'label' => 'Observaciones',
        'error' => $errors->first(Str::snake('Observaciones')) ?? false,
        'value' => old(Str::snake('Observaciones'))
      ])  

      </div>


    </form>
    
  </div>
@endsection

@section('custom-js')
    
@endsection


@extends('base.administrativo.blank')

@section('titulo')
  Crear un Concepto de Pago
@endsection

@section('contenido')
  <div class="p-8 m-4 dark:bg-white/[0.03] rounded-2xl">
    <x-ui.section-header
            titulo="Nuevo Concepto de Pago"
            subtitulo="Registra un nuevo concepto de pago en el sistema"
            :returnUrl="$data['return']"
            boton="Ingresar"
    />

    <form method="POST" id="form" class="flex flex-col gap-4 mt-4" action="">
      @method('PUT')
      @csrf

      @include('components.forms.string', [
        'label' => 'Descripcion',
        'error' => $errors->first(Str::snake('Descripcion')) ?? false,
        'value' => old(Str::snake('Descripcion'))
      ])

      @include('components.forms.string', [
        'label' => 'Escala',
        'error' => $errors->first(Str::snake('Escala')) ?? false,
        'value' => old(Str::snake('Escala'))
      ])

      @include('components.forms.string', [
        'label' => 'Monto',
        'error' => $errors->first(Str::snake('Monto')) ?? false,
        'value' => old(Str::snake('Monto'))
      ])

    </form>
  </div>
@endsection

@section('custom-js')

@endsection

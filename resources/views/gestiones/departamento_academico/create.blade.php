@extends('base.administrativo.blank')

@section('titulo')
  Crear un Departamento Académico
@endsection

@section('contenido')
<div class="p-8 m-4 dark:bg-white/[0.03] rounded-2xl">
    <x-ui.section-header
            titulo="Nuevo Departamento Académico"
            subtitulo="Registra un nuevo departamento académico en el sistema"
            :returnUrl="$data['return']"
    />

    <form method="POST" id="form" class="flex flex-col gap-4 mt-4" action="">
      @method('PUT')
      @csrf

      @include('components.forms.string', [
        'label' => 'Nombre',
        'error' => $errors->first(Str::snake('Nombre')) ?? false,
        'value' => old(Str::snake('Nombre'))
      ])
    </form>
</div>
@endsection

@section('custom-js')

@endsection


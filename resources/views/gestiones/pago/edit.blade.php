@extends('base.administrativo.blank')

@section('titulo')
  Pagos | Edición
@endsection

@section('contenido')
<div class="p-8 m-4 bg-gray-100 dark:bg-white/[0.03] rounded-2xl">
    <!-- Header -->
    <x-ui.section-header
        titulo="Editar Pago"
        subtitulo="ID: {{ $data['id'] }}"
        :returnUrl="$data['return']"
        boton="Guardar"
    />

    <form method="POST" id="form" class="flex flex-col gap-4 mt-4" action="">
      @method('PATCH')
      @csrf

      @include('components.forms.datetime-picker',[
        'label' => 'Fecha pago',
        'error' => $errors->first(Str::snake('Fecha pago')) ?? false,
        'value' => old(Str::snake('Fecha pago')) ?? $data['default']['fecha_pago']
      ])

      @include('components.forms.string',[
        'label' => 'Monto',
        'error' => $errors->first(Str::snake('Monto')) ?? false,
        'value' => old(Str::snake('Monto')) ?? $data['default']['monto']
      ])

      @include('components.forms.text-area',[
        'label' => 'Observaciones',
        'error' => $errors->first(Str::snake('Observaciones')) ?? false,
        'value' => old(Str::snake('Observaciones')) ?? $data['default']['observaciones']
      ])

    </form>
</div>
@endsection

@section('custom-js')
  <script src="{{ asset('js/tables.js') }}"></script>
@endsection

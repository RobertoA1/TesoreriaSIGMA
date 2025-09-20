
@extends('base.administrativo.blank')

@section('titulo')
  Crear Familiar
@endsection

@section('contenido')
  <div class="p-8 m-4 dark:bg-white/[0.03] rounded-2xl">
    <!-- Header -->
    <x-ui.section-header
        titulo="Crear Familiar"
        subtitulo="Estás creando un nuevo familiar"
        :returnUrl="$data['return'] ?? route('familiar.index')"
        boton="Crear"
    />

    <form method="POST" id="form" class="flex flex-col gap-4 mt-4" action="">
      @method('PUT')
      @csrf

      <div class="flex items-center gap-2">
        <input type="checkbox" id="crear_usuario" name="crear_usuario" value="1" {{ old('crear_usuario') ? 'checked' : '' }}>
        <label for="crear_usuario" class="text-sm text-gray-700 dark:text-gray-200">¿Desea crear una cuenta de usuario para este familiar?</label>
      </div>

      @include('components.forms.string', [
        'label' => 'Dni',
        'name' => 'dni',
        'error' => $errors->first(Str::snake('Dni')) ?? false,
        'value' => old('dni')
      ])

      @include('components.forms.string', [
        'label' => 'Apellido Paterno',
        'name' => 'apellido_paterno',
        'error' => $errors->first(Str::snake('Apellido Paterno')) ?? false,
        'value' => old('apellido_paterno')
      ])

      @include('components.forms.string', [
        'label' => 'Apellido Materno',
        'name' => 'apellido_materno',
        'error' => $errors->first(Str::snake('Apellido Materno')) ?? false,
        'value' => old('apellido_materno')
      ])

      @include('components.forms.string', [
        'label' => 'Primer Nombre',
        'name' => 'primer_nombre',
        'error' => $errors->first(Str::snake('Primer Nombre')) ?? false,
        'value' => old('primer_nombre')
      ])

      @include('components.forms.string', [
        'label' => 'Otros Nombres',
        'name' => 'otros_nombres',
        'error' => $errors->first(Str::snake('Otros Nombres')) ?? false,
        'value' => old('otros_nombres')
      ])

      @include('components.forms.string', [
        'label' => 'Numero de Contacto',
        'name' => 'numero_contacto',
        'error' => $errors->first(Str::snake('Numero de Contacto')) ?? false,
        'value' => old('numero_contacto')
      ])

      @include('components.forms.string', [
        'label' => 'Correo Electronico',
        'name' => 'correo_electronico',
        'error' => $errors->first(Str::snake('Correo Electronico')) ?? false,
        'value' => old('correo_electronico')
      ])
    </form>
  </div>
@endsection

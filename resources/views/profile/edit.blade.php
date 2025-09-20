@extends('base.administrativo.blank')

@section('titulo')
    Editar Usuario
@endsection

@section('contenido')
<div class="p-8 m-4 bg-gray-100 dark:bg-white/[0.03] rounded-2xl">
    <!-- Header -->
    <div class="flex pb-6 justify-between items-center border-b border-gray-200 dark:border-gray-700">
        <div>
            <h2 class="text-2xl font-bold dark:text-gray-200 text-gray-800">Editar Usuario</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">ID: {{ $data['id'] }}</p>
        </div>
        <div class="flex gap-3">
            <input form="form" type="submit"
                class="cursor-pointer inline-flex items-center gap-2 rounded-lg border border-green-300 bg-green-500 px-6 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:border-green-600 dark:bg-green-600 dark:hover:bg-green-700"
                value="💾 Guardar Cambios"
            >
            <a href="{{ $data['return'] }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
            >
                Cancelar
            </a>
        </div>
    </div>

    <form method="POST" id="form" action="{{ route('perfil.editEntry') }}" enctype="multipart/form-data" class="mt-8">
        @method('PATCH')
        @csrf

        <!-- Información del Usuario -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Información del Usuario</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                @include('components.forms.string', [
                    'label' => 'Nombre de Usuario',
                    'name' => 'username',
                    'error' => $errors->first('username') ?? false,
                    'value' => old('username') ?? $data['default']['username']
                ])

                @include('components.forms.combo', [
                    'label' => 'Tipo',
                    'name' => 'tipo',
                    'error' => $errors->first('tipo') ?? false,
                    'value' => old('tipo') ?? $data['default']['tipo'],
                    'options' => $data['tipos'],
                    'options_attributes' => ['id', 'descripcion']
                ])

                @include('components.forms.combo', [
                    'label' => 'Estado',
                    'name' => 'estado',
                    'error' => $errors->first('estado') ?? false,
                    'value' => old('estado') ?? $data['default']['estado'],
                    'options' => [
                        ['id' => '1', 'nombre' => 'Activo'],
                        ['id' => '0', 'nombre' => 'Inactivo'],
                    ],
                    'options_attributes' => ['id', 'nombre']
                ])
            </div>
        </div>

        <!-- Contraseña -->
        <div class="mb-8">
            @include('components.forms.password', [
                'label' => 'Nueva Contraseña',
                'name' => 'password',
                'error' => $errors->first('password') ?? false,
            ])
        </div>

        <!-- Foto -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Foto de Perfil</h3>
            <div class="flex items-center gap-4">
                <img src="{{ $data['default']['foto_url'] }}" class="w-20 h-20 rounded-full object-cover border border-gray-300">
                <input type="file" name="foto" class="block w-full text-sm text-gray-600 dark:text-gray-300">
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ $data['return'] }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
            >
                Cancelar
            </a>
            <input form="form" type="submit"
                class="cursor-pointer inline-flex items-center gap-2 rounded-lg border border-green-300 bg-green-500 px-6 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:border-green-600 dark:bg-green-600 dark:hover:bg-green-700"
                value="💾 Guardar Cambios"
            >
        </div>
    </form>
</div>
@endsection

@section('custom-js')
@endsection

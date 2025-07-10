@extends('base.administrativo.blank')

@section('titulo')
    Crear un alumno
@endsection

@section('contenido')
    <div class="p-8 m-4 bg-gray-100 dark:bg-white/[0.03] rounded-2xl">
        <!-- Header -->
        <div class="flex pb-6 justify-between items-center border-b border-gray-200 dark:border-gray-700">
            <div>
                <h2 class="text-2xl font-bold dark:text-gray-200 text-gray-800">Nuevo Alumno</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Registra un nuevo alumno en el sistema</p>
            </div>
            <div class="flex gap-3">
                <input form="form" type="submit"
                    class="cursor-pointer inline-flex items-center gap-2 rounded-lg border border-blue-300 bg-blue-500 px-6 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:border-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700"
                    @click="document.querySelector('.definir_familiares').value = '1';" 
                    value="Crear alumno y definir familiares"
                >

                <input form="form" type="submit"
                    class="cursor-pointer inline-flex items-center gap-2 rounded-lg border border-blue-300 px-6 py-2.5 text-sm font-medium text-black dark:text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:border-blue-600"
                    value="Crear alumno únicamente"
                    @click="document.querySelector('.definir_familiares').value = '0';"
                >

                <a href="{{ $data['return'] }}"
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                >
                    Cancelar
                </a>
            </div>
        </div>

        <form method="POST" id="form" action="" class="mt-8">
            @method('PUT')
            @csrf

            <input type="text" class="definir_familiares" name="definir_familiares" value="0" hidden>

            <!-- Información Básica -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-4 0V4a2 2 0 014 0v2"></path>
                    </svg>
                    Información Básica
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @include('components.forms.string', [
                        'label' => 'Código Educando',
                        'name' => Str::snake('Código Educando'),
                        'error' => $errors->first(Str::snake('Código Educando')) ?? false,
                        'value' => old(Str::snake('Código Educando'))
                    ])

                    @include('components.forms.string', [
                        'label' => 'Código Modular',
                        'name' => Str::snake('Código Modular'),
                        'error' => $errors->first(Str::snake('Código Modular')) ?? false,
                        'value' => old(Str::snake('Código Modular'))
                    ])

                    @include('components.forms.date-año', [
                        'label' => 'Año de Ingreso',
                        'name' => Str::snake('Año de Ingreso'),
                        'error' => $errors->first(Str::snake('Año de Ingreso')) ?? false,
                        'value' => old(Str::snake('Año de Ingreso'))
                    ])

                    @include('components.forms.string', [
                        'label' => 'DNI',
                        'name' => Str::snake('DNI'),
                        'error' => $errors->first(Str::snake('DNI')) ?? false,
                        'value' => old(Str::snake('DNI'))
                    ])
                </div>
            </div>

            <!-- Información Personal -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Información Personal
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @include('components.forms.string', [
                        'label' => 'Apellido Paterno',
                        'name' => Str::snake('Apellido Paterno'),
                        'error' => $errors->first(Str::snake('Apellido Paterno')) ?? false,
                        'value' => old(Str::snake('Apellido Paterno'))
                    ])

                    @include('components.forms.string', [
                        'label' => 'Apellido Materno',
                        'name' => Str::snake('Apellido Materno'),
                        'error' => $errors->first(Str::snake('Apellido Materno')) ?? false,
                        'value' => old(Str::snake('Apellido Materno'))
                    ])

                    @include('components.forms.string', [
                        'label' => 'Primer Nombre',
                        'name' => Str::snake('Primer Nombre'),
                        'error' => $errors->first(Str::snake('Primer Nombre')) ?? false,
                        'value' => old(Str::snake('Primer Nombre'))
                    ])

                    @include('components.forms.string', [
                        'label' => 'Otros Nombres',
                        'name' => Str::snake('Otros Nombres'),
                        'error' => $errors->first(Str::snake('Otros Nombres')) ?? false,
                        'value' => old(Str::snake('Otros Nombres'))
                    ])
                </div>
            </div>

            <!-- Información Demográfica -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-9 0v10a2 2 0 002 2h8a2 2 0 002-2V7H7z"></path>
                    </svg>
                    Información Demográfica
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @include('components.forms.combo', [
                        'label' => 'Sexo',
                        'name' => Str::snake('Sexo'),
                        'error' => $errors->first(Str::snake('Sexo')) ?? false,
                        'value' => old(Str::snake('Sexo')),
                        'options' => $data['sexos'],
                        'options_attributes' => ['id', 'descripcion']
                    ])

                    @include('components.forms.date', [
                        'label' => 'Fecha Nacimiento',
                        'name' => Str::snake('Fecha Nacimiento'),
                        'error' => $errors->first(Str::snake('Fecha Nacimiento')) ?? false,
                        'value' => old(Str::snake('Fecha Nacimiento'))
                    ])

                    @include('components.forms.string', [
                        'label' => 'Teléfono',
                        'name' => Str::snake('Teléfono'),
                        'error' => $errors->first(Str::snake('Teléfono')) ?? false,
                        'value' => old(Str::snake('Teléfono'))
                    ])

                    @include('components.forms.combo', [
                        'label' => 'Escala',
                        'name' => Str::snake('Escala'),
                        'error' => $errors->first(Str::snake('Escala')) ?? false,
                        'value' => old(Str::snake('Escala')),
                        'options' => $data['escalas'],
                        'options_attributes' => ['id', 'descripcion']
                    ])
                </div>
            </div>

            <!-- Ubicación Geográfica -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-4 0 3 3 0 016 0z"></path>
                    </svg>
                    Ubicación Geográfica
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @include('components.forms.combo_dependient', [
                        'label' => 'País',
                        'name' => Str::snake('País'),
                        'error' => $errors->first(Str::snake('País')) ?? false,
                        'placeholder' => 'Seleccionar país...',
                        'value' => old(Str::snake('País')),
                        'value_field' => 'id_pais',
                        'text_field' => 'descripcion',
                        'options' => $data['paises'],
                        'enabled' => true,
                    ])

                    @include('components.forms.combo_dependient', [
                        'label' => 'Departamento',
                        'name' => Str::snake('Departamento'),
                        'error' => $errors->first(Str::snake('Departamento')) ?? false,
                        'placeholder' => 'Seleccionar departamento...',
                        'depends_on' => Str::snake('País'),
                        'parent_field' => 'id_pais',
                        'value' => old(Str::snake('Departamento')),
                        'value_field' => 'id_departamento',
                        'text_field' => 'descripcion',
                        'options' => $data['departamentos'],
                        'enabled' => false,
                    ])

                    @include('components.forms.combo_dependient', [
                        'label' => 'Provincia',
                        'name' => Str::snake('Provincia'),
                        'error' => $errors->first(Str::snake('Provincia')) ?? false,
                        'value' => old(Str::snake('Provincia')),
                        'placeholder' => 'Seleccionar provincia...',
                        'depends_on' => Str::snake('Departamento'),
                        'parent_field' => 'id_departamento',
                        'value_field' => 'id_provincia',
                        'text_field' => 'descripcion',
                        'options' => $data['provincias'],
                        'enabled' => false,
                    ])

                    @include('components.forms.combo_dependient', [
                        'label' => 'Distrito',
                        'name' => Str::snake('Distrito'),
                        'error' => $errors->first(Str::snake('Distrito')) ?? false,
                        'value' => old(Str::snake('Distrito')),
                        'placeholder' => 'Seleccionar distrito...',
                        'depends_on' => Str::snake('Provincia'),
                        'parent_field' => 'id_provincia',
                        'value_field' => 'id_distrito',
                        'text_field' => 'descripcion',
                        'options' => $data['distritos'],
                        'enabled' => false,
                    ])
                </div>
            </div>

            <!-- Información Cultural y Religiosa -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    Información Cultural y Religiosa
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @include('components.forms.combo', [
                        'label' => 'Lengua Materna',
                        'name' => Str::snake('Lengua Materna'),
                        'error' => $errors->first(Str::snake('Lengua Materna')) ?? false,
                        'value' => old(Str::snake('Lengua Materna')),
                        'options' => $data['lenguasmaternas'],
                        'options_attributes' => ['id', 'descripcion']
                    ])

                    @include('components.forms.combo', [
                        'label' => 'Estado Civil',
                        'name' => Str::snake('Estado Civil'),
                        'error' => $errors->first(Str::snake('Estado Civil')) ?? false,
                        'value' => old(Str::snake('Estado Civil')),
                        'options' => $data['estadosciviles'],
                        'options_attributes' => ['id', 'descripcion']
                    ])

                    @include('components.forms.string', [
                        'label' => 'Religión',
                        'name' => Str::snake('Religión'),
                        'error' => $errors->first(Str::snake('Religión')) ?? false,
                        'value' => old(Str::snake('Religión'))
                    ])

                    @include('components.forms.date', [
                        'label' => 'Fecha Bautizo',
                        'name' => Str::snake('Fecha Bautizo'),
                        'error' => $errors->first(Str::snake('Fecha Bautizo')) ?? false,
                        'value' => old(Str::snake('Fecha Bautizo'))
                    ])
                </div>
            </div>

            <!-- Información Educativa -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Información Educativa
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @include('components.forms.string', [
                        'label' => 'Parroquia de Bautizo',
                        'name' => Str::snake('Parroquia de Bautizo'),
                        'error' => $errors->first(Str::snake('Parroquia de Bautizo')) ?? false,
                        'value' => old(Str::snake('Parroquia de Bautizo'))
                    ])

                    @include('components.forms.string', [
                        'label' => 'Colegio de Procedencia',
                        'name' => Str::snake('Colegio de Procedencia'),
                        'error' => $errors->first(Str::snake('Colegio de Procedencia')) ?? false,
                        'value' => old(Str::snake('Colegio de Procedencia'))
                    ])
                </div>
            </div>

            <!-- Información de Transporte y Ubicación -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                    Información de Transporte y Ubicación
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="md:col-span-2">
                        @include('components.forms.string', [
                            'label' => 'Dirección',
                            'name' => Str::snake('Dirección'),
                            'error' => $errors->first(Str::snake('Dirección')) ?? false,
                            'value' => old(Str::snake('Dirección'))
                        ])
                    </div>

                    @include('components.forms.string', [
                        'label' => 'Medio de Transporte',
                        'name' => Str::snake('Medio de Transporte'),
                        'error' => $errors->first(Str::snake('Medio de Transporte')) ?? false,
                        'value' => old(Str::snake('Medio de Transporte'))
                    ])

                    @include('components.forms.string', [
                        'label' => 'Tiempo de Demora',
                        'name' => Str::snake('Tiempo de Demora'),
                        'error' => $errors->first(Str::snake('Tiempo de Demora')) ?? false,
                        'value' => old(Str::snake('Tiempo de Demora'))
                    ])
                </div>
            </div>

            <!-- Información de Vivienda -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Información de Vivienda
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @include('components.forms.string', [
                        'label' => 'Material Vivienda',
                        'name' => Str::snake('Material Vivienda'),
                        'error' => $errors->first(Str::snake('Material Vivienda')) ?? false,
                        'value' => old(Str::snake('Material Vivienda'))
                    ])

                    @include('components.forms.string', [
                        'label' => 'Energía Eléctrica',
                        'name' => Str::snake('Energía Eléctrica'),
                        'error' => $errors->first(Str::snake('Energía Eléctrica')) ?? false,
                        'value' => old(Str::snake('Energía Eléctrica'))
                    ])

                    @include('components.forms.string', [
                        'label' => 'Agua Potable',
                        'name' => Str::snake('Agua Potable'),
                        'error' => $errors->first(Str::snake('Agua Potable')) ?? false,
                        'value' => old(Str::snake('Agua Potable'))
                    ])

                    @include('components.forms.string', [
                        'label' => 'Desagüe',
                        'name' => Str::snake('Desagüe'),
                        'error' => $errors->first(Str::snake('Desagüe')) ?? false,
                        'value' => old(Str::snake('Desagüe'))
                    ])
                </div>
            </div>

            <!-- Información Socioeconómica -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Información Socioeconómica
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @include('components.forms.string', [
                        'label' => 'Servicios Higiénicos',
                        'name' => '',
                        'error' => $errors->first(Str::snake('Servicios Higiénicos')) ?? false,
                        'value' => old(Str::snake('Servicios Higiénicos'))
                    ])

                    @include('components.forms.string', [
                        'label' => 'Número de Habitaciones',
                        'name' => Str::snake('Número de Habitaciones'),
                        'error' => $errors->first(Str::snake('Número de Habitaciones')) ?? false,
                        'value' => old(Str::snake('Número de Habitaciones'))
                    ])

                    @include('components.forms.string', [
                        'label' => 'Número de Habitantes',
                        'name' => Str::snake('Número de Habitantes'),
                        'error' => $errors->first(Str::snake('Número de Habitantes')) ?? false,
                        'value' => old(Str::snake('Número de Habitantes'))
                    ])

                    @include('components.forms.string', [
                        'label' => 'Situación de Vivienda',
                        'name' => Str::snake('Situación de Vivienda'),
                        'error' => $errors->first(Str::snake('Situación de Vivienda')) ?? false,
                        'value' => old(Str::snake('Situación de Vivienda'))
                    ])
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                <input form="form" type="submit"
                    class="cursor-pointer inline-flex items-center gap-2 rounded-lg border border-blue-300 bg-blue-500 px-6 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:border-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700"
                    value="Crear alumno y definir familiares" @click="document.querySelector('.definir_familiares').value = '1';"
                >

                <input form="form" type="submit"
                    class="cursor-pointer inline-flex items-center gap-2 rounded-lg border border-blue-300 px-6 py-2.5 text-sm font-medium text-black dark:text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:border-blue-600"
                    value="Crear alumno únicamente"
                    @click="document.querySelector('.definir_familiares').value = '0';"
                >

                <a href="{{ $data['return'] }}"
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                >
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection

@section('custom-js')
@endsection

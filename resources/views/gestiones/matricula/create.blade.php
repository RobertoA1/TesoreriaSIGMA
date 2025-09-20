@extends('base.administrativo.blank')

@section('titulo')
    Registrar una Matricula
@endsection

@section('extracss')
@endsection

@section('contenido')
    <div class="p-8 m-4 bg-gray-100 dark:bg-white/[0.03] rounded-2xl">
        <!-- Header -->
        <x-ui.section-header
            titulo="Nueva Matrícula"
            subtitulo="Registra una nueva matrícula en el sistema"
            :returnUrl="$data['return']"
        />

        <!-- Formulario -->
        <form method="POST" id="form" action="" class="mt-8">
            @method('PUT')
            @csrf

            <!-- Información del Estudiante -->
            <div class="mb-8">
                <x-ui.section-title :iconColor="'text-blue-500'">
                    <x-slot name="iconPath">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </x-slot>
                    Información del Estudiante
                </x-ui.section-title>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        @include('components.forms.combo', [
                            'label' => 'Alumno',
                            'name' => 'alumno',
                            'error' => $errors->first(Str::snake('Alumno')) ?? false,
                            'value' => old(Str::snake('Alumno')),
                            'options' => $data['alumnos'],
                            'options_attributes' => ['id', 'nombres']
                        ])
                    </div>
                    <div>
                        @include('components.forms.combo', [
                            'label' => 'Año Escolar',
                            'name' => 'año_escolar',
                            'error' => $errors->first(Str::snake('Año Escolar')) ?? false,
                            'value' => old(Str::snake('Año Escolar')),
                            'options' => $data['añosEscolares'],
                            'options_attributes' => ['id', 'descripcion']
                        ])
                    </div>
                </div>
            </div>

            <!-- Información Académica -->
            <div class="mb-8">
                <x-ui.section-title :iconColor="'text-green-500'">
                    <x-slot name="iconPath">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </x-slot>
                    Información Académica
                </x-ui.section-title>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @include('components.forms.combo_dependient', [
                        'label' => 'Nivel Educativo',
                        'name' => 'nivel_educativo',
                        'error' => $errors->first(Str::snake('Nivel Educativo')) ?? false,
                        'placeholder' => 'Seleccionar nivel educativo...',
                        'value' => old(Str::snake('Nivel Educativo'), $data['nivelSeleccionado'] ?? null ),
                        'value_field' => 'id_nivel',
                        'text_field' => 'nombre_nivel',
                        'options' => $data['niveles'],
                        'enabled' => true,
                    ])

                    @include('components.forms.combo_dependient', [
                        'label' => 'Grado',
                        'name' => 'grado',
                        'error' => $errors->first(Str::snake('Grado')) ?? false,
                        'placeholder' => 'Seleccionar grado...',
                        'depends_on' => 'nivel_educativo',
                        'parent_field' => 'id_nivel',
                        'value' => old(Str::snake('Grado'), $data['gradoSeleccionado'] ?? null),
                        'value_field' => 'id_grado',
                        'text_field' => 'nombre_grado',
                        'options' => $data['grados'],
                        'enabled' => false,
                    ])

                    @include('components.forms.combo_dependient', [
                        'label' => 'Sección',
                        'name' => 'seccion',
                        'error' => $errors->first(Str::snake('Seccion')) ?? false,
                        'value' => old(Str::snake('Seccion'), $data['seccionSeleccionada'] ?? null),
                        'placeholder' => 'Seleccionar sección...',
                        'depends_on' => 'grado',
                        'parent_field' => 'id_grado',
                        'value_field' => ['id_grado', 'nombreSeccion'],
                        'text_field' => 'nombreSeccion',
                        'options' => $data['secciones'],
                        'enabled' => false,
                    ])
                </div>
            </div>

            <!-- Información Adicional -->
            <div class="mb-8">
                <x-ui.section-title :iconColor="'text-purple-500'">
                    <x-slot name="iconPath">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </x-slot>
                    Información Adicional
                </x-ui.section-title>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        @include('components.forms.text-area', [
                            'label' => 'Observaciones',
                            'name' => 'observaciones',
                            'error' => $errors->first(Str::snake('Observaciones')) ?? false,
                            'value' => old(Str::snake('Observaciones'))
                        ])
                    </div>
                    <div>
                        <!-- Info Box del Alumno -->
                        <div class="h-full">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Información Financiera
                            </label>
                            <div id="infoBox" class="h-full min-h-[120px] flex items-center justify-center border border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-800/50 text-gray-600 dark:text-gray-400 text-sm transition-all duration-300 ease-in-out">
                                <div class="text-center">
                                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p>Selecciona un alumno para ver detalles financieros</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Campo oculto -->
            <input type="hidden" name="escala" id="escalaInput" value="">

            <!-- Botones de acción -->
            <x-ui.section-botton
                :returnUrl="$data['return']"
                boton="✨ Crear Matrícula"
            />
        </form>
    </div>
@endsection

@section('custom-js')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const gradoSelect = document.getElementById('grado');
        const seccionSelect = document.getElementById('seccion');
        // Cuando cambie el grado
        gradoSelect.addEventListener('change', function () {
            if (gradoSelect.value) {
                seccionSelect.disabled = false;
            } else {
                seccionSelect.disabled = true;
                seccionSelect.value = ''; // Opcional: limpia selección
            }
        });
    });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const alumnoInput = document.querySelector('input[name="alumno"]');
        const infoBox = document.getElementById('infoBox');

        if (alumnoInput && infoBox) {
            alumnoInput.addEventListener('change', function () {
                const alumnoId = alumnoInput.value;

                if (!alumnoId) {
                    infoBox.innerHTML = `
                        <div class="text-center">
                            <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p>Selecciona un alumno para ver detalles financieros</p>
                        </div>
                    `;
                    return;
                }

                infoBox.innerHTML = `
                    <div class="text-center">
                        <svg class="w-6 h-6 mx-auto mb-2 text-blue-500 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <p>Cargando información...</p>
                    </div>
                `;

                fetch(`/matriculas/api/alumnos/${alumnoId}/info`)
                    .then(response => {
                        if (!response.ok) throw new Error("Error en la respuesta.");
                        return response.json();
                    })
                    .then(data => {
                        infoBox.innerHTML = `
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Escala:</span>
                                    <span class="text-gray-900 dark:text-white">${data.escala ?? 'No registrada'}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Deuda mensual:</span>
                                    <span class="text-gray-900 dark:text-white">S/ ${data.deuda_mensual}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Cuotas pendientes:</span>
                                    <span class="text-gray-900 dark:text-white">${data.cuotas_pendientes}</span>
                                </div>
                                <div class="flex justify-between items-center border-t border-gray-200 dark:border-gray-600 pt-2">
                                    <span class="font-semibold text-gray-700 dark:text-gray-300">Deuda total:</span>
                                    <span class="font-semibold text-red-600 dark:text-red-400">S/ ${data.deuda_total}</span>
                                </div>
                            </div>
                        `;

                        // Actualizar el input hidden
                        const escalaInput = document.getElementById("escalaInput");
                        if (escalaInput) {
                            escalaInput.value = data.escala;
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        infoBox.innerHTML = `
                            <div class="text-center text-red-500">
                                <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p>No se pudo cargar la información</p>
                            </div>
                        `;
                    });
            });
        }
    });
    </script>
@endsection

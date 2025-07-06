@extends('base.administrativo.blank')

@section('titulo')
  Editar una Matricula
@endsection

@section('extracss')
<style>
    #infoBox {
    border: 1px solid #e5e7eb;               /* Borde gris claro */
    border-radius: 0.5rem;                    /* Bordes redondeados */
    padding: 1rem;                            /* Espaciado interno */
    background-color: #f9fafb;                /* Fondo claro */
    color: #374151;                           /* Texto gris oscuro */
    font-size: 0.875rem;                      /* Tamaño base de texto */
    line-height: 1.25rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);    /* Sombra suave */
    transition: all 0.3s ease;                /* Transición suave */
    }

    /* Modo oscuro */
    .dark #infoBox {
    background-color: #1f2937;               /* Fondo oscuro */
    border-color: #374151;                   /* Borde oscuro */
    color: #d1d5db;                          /* Texto gris claro */
    }

    /* Animación de aparición */
    #infoBox.fade-in {
    opacity: 0;
    transform: translateY(-0.5rem);
    animation: fadeInSlide 0.3s forwards;
    }

    /* Estilo interno de párrafos */
    #infoBox p {
    margin-bottom: 0.5rem;
    }

    /* Resaltar los labels */
    #infoBox strong {
    color: #111827;                         /* Negro más intenso */
    }

    .dark #infoBox strong {
    color: #f3f4f6;                         /* Blanco casi total */
    }

    /* Keyframes de animación */
    @keyframes fadeInSlide {
    to {
        opacity: 1;
        transform: translateY(0);
    }
    }
</style>
@endsection

@section('contenido')
  <div class="p-8 m-4 dark:bg-white/[0.03] rounded-2xl">
    <div class="flex pb-4 justify-between items-center">
      <h2 class="text-lg dark:text-gray-200 text-gray-800">Estás editando la matricula con ID {{$data['id']}}</h2>

      <div class="flex gap-4">
        <input form="form" target="" type="submit" form=""
          class="cursor-pointer inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-gray-200 px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-300 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
          value="Guardar"
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
      @method('PATCH')
      @csrf

      {{-- Alumno --}}
      @include('components.forms.combo', [
          'label' => 'Alumno',
          'error' => $errors->first(Str::snake('Alumno')) ?? false,
          'value' => old(Str::snake('Alumno')) ?? $data['default'][Str::snake('Alumno')],
          'options' => $data['alumnos'],
          'options_attributes' => ['id', 'nombres']
      ])

      {{-- Año Escolar --}}
      @include('components.forms.combo', [
          'label' => 'Año Escolar',
          'error' => $errors->first(Str::snake('Año Escolar')) ?? false,
          'value' => old(Str::snake('Año Escolar')) ?? $data['default'][Str::snake('Año Escolar')],
          'options' => $data['añosEscolares'],
          'options_attributes' => ['id', 'descripcion']
      ])

      {{-- Nivel Educativo --}}
      @include('components.forms.combo_dependient', [
          'label' => 'Nivel Educativo',
          'name' => 'nivel_educativo',
          'error' => $errors->first(Str::snake('Nivel Educativo')) ?? false,
          'placeholder' => 'Seleccionar nivel educativo...',
          'value' => old(Str::snake('Nivel Educativo')) ?? $data['default'][Str::snake('Nivel Educativo')],
          'value_field' => 'id_nivel',
          'text_field' => 'nombre_nivel',
          'options' => $data['niveles'],
          'enabled' => true,
      ])

      {{-- Grado --}}
      @include('components.forms.combo_dependient', [
          'label' => 'Grado',
          'name' => 'grado',
          'error' => $errors->first(Str::snake('Grado')) ?? false,
          'placeholder' => 'Seleccionar grado...',
          'depends_on' => 'nivel_educativo',
          'parent_field' => 'id_nivel',
          'value' => old(Str::snake('Grado')) ?? $data['default'][Str::snake('Grado')],
          'value_field' => 'id_grado',
          'text_field' => 'nombre_grado',
          'options' => $data['grados'],
          'enabled' => false,
      ])

      {{-- Sección --}}
      @include('components.forms.combo_dependient', [
          'label' => 'Sección',
          'name' => 'seccion',
          'error' => $errors->first(Str::snake('Seccion')) ?? false,
          'value' => old(Str::snake('Seccion')) ?? $data['default'][Str::snake('Seccion')],
          'placeholder' => 'Seleccionar sección...',
          'depends_on' => 'grado',
          'parent_field' => 'id_grado',
          'value_field' => ['id_grado', 'nombreSeccion'],
          'text_field' => 'nombreSeccion',
          'options' => $data['secciones'],
          'enabled' => false,
      ])

      {{-- Observaciones --}}
      <div class="col-span-5">
        @include('components.forms.text-area', [
            'label' => 'Observaciones',
            'error' => $errors->first(Str::snake('Observaciones')) ?? false,
            'value' => old(Str::snake('Observaciones')) ?? $data['default'][Str::snake('Observaciones')]
        ])
      </div>


            {{-- Escala del Alumno --}}

        <div class="col-span-5">
            @include('components.forms.info_box')
        </div>

        <input type="hidden" name="escala" id="escalaInput" value="">

        <input type="hidden" name="fecha_matricula" id="fecha_matriculaInput" value={{$data['default'][Str::snake('fecha_matricula')]}}>

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

  // Función reutilizable para cargar datos
  function cargarInfoAlumno(alumnoId) {
      if (!alumnoId) {
          infoBox.textContent = "Selecciona un alumno para ver detalles.";
          return;
      }

      infoBox.textContent = "Cargando información...";
      infoBox.classList.remove("fade-in");

      fetch(`/matriculas/api/alumnos/${alumnoId}/info`)
          .then(response => {
              if (!response.ok) throw new Error("Error en la respuesta.");
              return response.json();
          })
          .then(data => {
              infoBox.innerHTML = `
                  <p><strong>Escala:</strong> ${data.escala ?? 'No registrada'}</p>
                  <p><strong>Deuda mensual:</strong> S/ ${data.deuda_mensual}</p>
                  <p><strong>Cuotas pendientes:</strong> ${data.cuotas_pendientes}</p>
                  <p><strong>Deuda total:</strong> S/ ${data.deuda_total}</p>
              `;

              // Actualizar el input hidden
              const escalaInput = document.getElementById("escalaInput");
              if (escalaInput) {
                  escalaInput.value = data.escala;
              }
          })
          .catch(error => {
              console.error(error);
              infoBox.textContent = "No se pudo cargar la información.";
          });
  }

  if (alumnoInput && infoBox) {
      // Al cambiar el input
      alumnoInput.addEventListener('change', function () {
          cargarInfoAlumno(alumnoInput.value);
      });

      // Al cargar la página si ya hay un valor
      if (alumnoInput.value) {
          cargarInfoAlumno(alumnoInput.value);
      }
  }
});
</script>

@endsection


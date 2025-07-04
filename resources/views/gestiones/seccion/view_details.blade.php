@extends('base.administrativo.blank')

@section('titulo')
  Sección | Detalles
@endsection

@section('contenido')
<div class="p-8 m-4 bg-white dark:bg-gray-900 shadow rounded-2xl">
  <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 pb-4 border-b border-gray-200 dark:border-gray-700 mb-4">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
      Detalles de la Sección "{{ $seccion->nombreSeccion }}" del Grado {{ $seccion->grado->nombre_grado }}
    </h2>
    <a
      href="{{ route('seccion_view') }}"
      class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 hover:text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
    >
      Volver a la lista
    </a>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    @include('components.forms.string-ineditable', [
      'label' => 'ID Grado',
      'name' => 'id_grado',
      'value' => $seccion->id_grado,
      'readonly' => true
    ])

    @include('components.forms.string-ineditable', [
      'label' => 'Nombre de Sección',
      'name' => 'nombreSeccion',
      'value' => $seccion->nombreSeccion,
      'readonly' => true
    ])
  </div>

  <form method="GET" class="mb-6 flex flex-wrap items-center gap-4">
    <input type="hidden" name="page" value="{{ request('page', 1) }}">
    <input type="hidden" name="showing" value="{{ $Pagination }}">
    <div class="flex items-center gap-2">
        <label for="anioEscolar" class="text-sm text-gray-700 dark:text-gray-300">Año:</label>
        <select name="anioEscolar" id="anioEscolar" onchange="this.form.submit()" class="rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-200">
          @foreach ($añosDisponibles as $a)
            <option value="{{ $a }}" @if ($a == $anioEscolar) selected @endif>{{ $a }}</option>
          @endforeach
        </select>
      </div>

      <div class="flex items-center gap-2">
        <label class="text-sm text-gray-700 dark:text-gray-300">Mostrar:</label>
        <select name="showing" onchange="this.form.submit()" class="rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-200">
          @foreach([5,10,15] as $num)
            <option value="{{ $num }}" @if ($Pagination == $num) selected @endif>{{ $num }}</option>
          @endforeach
        </select>
      </div>
  </form>

  <div>
    <h3 class="text-md font-semibold mb-2 text-gray-800 dark:text-gray-200">
      Alumnos Matriculados en {{ $anioEscolar }}
    </h3>

    @if ($matriculas->count())
      <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead class="bg-gray-50 dark:bg-gray-800">
            <tr>
              <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-700 dark:text-gray-300">
                ID Alumno
              </th>
              <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-700 dark:text-gray-300">
                Nombre Completo
              </th>
              <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-700 dark:text-gray-300">
                Escala
              </th>
              <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-700 dark:text-gray-300">
                Fecha Matrícula
              </th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
            @foreach ($matriculas as $matricula)
              <tr>
                <td class="px-4 py-2 text-gray-700 dark:text-gray-300">
                  {{ $matricula->alumno->id_alumno }}
                </td>
                <td class="px-4 py-2 text-gray-700 dark:text-gray-300">
                  {{ $matricula->alumno->apellido_paterno }}
                  {{ $matricula->alumno->apellido_materno }},
                  {{ $matricula->alumno->primer_nombre }}
                </td>
                <td class="px-4 py-2 text-gray-700 dark:text-gray-300">
                  {{ $matricula->escala }}
                </td>
                <td class="px-4 py-2 text-gray-700 dark:text-gray-300">
                  {{ $matricula->fecha_matricula->format('d/m/Y') }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      {{-- Paginación --}}
      <div class="mt-4">
        @include('components.pagination.pagination-manual', [
          'paginator' => $matriculas,
          'pageQuery' => 'matricula_page'
        ])
      </div>
    @else
      <p class="text-gray-600 dark:text-gray-400 mt-4">
        No hay alumnos matriculados en este año escolar.
      </p>
    @endif
  </div>
</div>
@endsection

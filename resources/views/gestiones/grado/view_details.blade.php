@extends('base.administrativo.blank')

@section('titulo')
  Grado | Detalles
@endsection

@section('contenido')
<div class="p-8 m-4 bg-white dark:bg-gray-900 rounded-2xl shadow-md border border-gray-200 dark:border-gray-700">
  <div class="flex pb-6 justify-between items-center border-b border-gray-200 dark:border-gray-700 mb-4">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
      Detalles del Grado ID {{ $grado->id_grado }}
    </h2>
    <a
      href="{{ route('grado_view') }}"
      class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-gray-100 px-3 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-200 hover:text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600"
    >
      ← Volver a la lista
    </a>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    @include('components.forms.string-ineditable', [
        'label' => 'ID',
        'name' => 'id',
        'value' => $grado->id_grado,
        'readonly' => true
    ])

    @include('components.forms.string-ineditable', [
        'label' => 'Nombre del Grado',
        'name' => 'nombre_grado',
        'value' => $grado->nombre_grado,
        'readonly' => true
    ])

    @include('components.forms.string-ineditable', [
        'label' => 'Nivel Educativo',
        'name' => 'nivel_educativo',
        'value' => $grado->nivelEducativo->descripcion ?? 'Sin asignar',
        'readonly' => true
    ])

    @include('components.forms.string-ineditable', [
        'label' => 'Estado',
        'name' => 'estado',
        'value' => $grado->estado ? 'Activo' : 'Inactivo',
        'readonly' => true
    ])
  </div>

  {{-- CURSOS --}}
  <div class="mt-8">
    <h3 class="text-lg font-semibold mb-3 text-gray-800 dark:text-gray-200">
      Cursos Asociados - Año Escolar {{ $anio }}
    </h3>

    <form method="GET" class="mb-4 flex flex-wrap items-center gap-4">
      <input type="hidden" name="seccion_page" value="{{ request('seccion_page', 1) }}">
      <input type="hidden" name="seccion_showing" value="{{ $seccionPagination }}">

      <div class="flex items-center gap-2">
        <label for="anio" class="text-sm text-gray-700 dark:text-gray-300">Año:</label>
        <select name="anio" id="anio" onchange="this.form.submit()" class="rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-200">
          @foreach ($aniosDisponibles as $a)
            <option value="{{ $a }}" @if ($a == $anio) selected @endif>{{ $a }}</option>
          @endforeach
        </select>
      </div>

      <div class="flex items-center gap-2">
        <label class="text-sm text-gray-700 dark:text-gray-300">Mostrar:</label>
        <select name="curso_showing" onchange="this.form.submit()" class="rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-200">
          @foreach([5,10,15] as $num)
            <option value="{{ $num }}" @if ($cursoPagination == $num) selected @endif>{{ $num }}</option>
          @endforeach
        </select>
      </div>
    </form>

    @if ($cursosQuery->count())
      <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead class="bg-gray-100 dark:bg-gray-800">
            <tr>
              <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Nombre del Curso</th>
              <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Opciones</th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
            @foreach ($cursosQuery as $curso)
              <tr>
                <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $curso->nombre_curso ?? '-' }}</td>
                <td class="px-4 py-3 ">
                  <a href="{{ route('curso_edit', $curso->id_curso) }}"
                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                    Editar
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      @include('components.pagination.pagination-manual', [
          'paginator' => $cursosQuery,
          'pageQuery' => 'curso_page'
      ])
    @else
      <p class="text-gray-600 dark:text-gray-400 mt-2">No hay cursos asignados.</p>
    @endif
  </div>

  {{-- SECCIONES --}}
  <div class="mt-8">
    <h3 class="text-lg font-semibold mb-3 text-gray-800 dark:text-gray-200">
      Secciones Asociadas
    </h3>

    <form method="GET" class="mb-4 flex flex-wrap items-center gap-4">
      <input type="hidden" name="anio" value="{{ $anio }}">
      <input type="hidden" name="curso_page" value="{{ request('curso_page', 1) }}">
      <input type="hidden" name="curso_showing" value="{{ $cursoPagination }}">

      <div class="flex items-center gap-2">
        <label class="text-sm text-gray-700 dark:text-gray-300">Mostrar:</label>
        <select name="seccion_showing" onchange="this.form.submit()" class="rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-200">
          @foreach([5,10,15] as $num)
            <option value="{{ $num }}" @if ($seccionPagination == $num) selected @endif>{{ $num }}</option>
          @endforeach
        </select>
      </div>
    </form>

    @if ($seccionesQuery->count())
      <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead class="bg-gray-100 dark:bg-gray-800">
            <tr>
              <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Sección</th>
              <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Opciones</th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
            @foreach ($seccionesQuery as $seccion)
              <tr>
                <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $seccion->nombreSeccion ?? '-' }}</td>
                <td class="px-4 py-3 ">
                  <a href="{{ route('seccion_view_details', [$seccion->id_grado, $seccion->nombreSeccion]) }}"
                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                    Ver Alumnos
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      @include('components.pagination.pagination-manual', [
          'paginator' => $seccionesQuery,
          'pageQuery' => 'seccion_page'
      ])
    @else
      <p class="text-gray-600 dark:text-gray-400 mt-2">No hay secciones asignadas.</p>
    @endif
  </div>
</div>
@endsection

@section('custom-js')
  <script src="{{ asset('js/tables.js') }}"></script>
  <script src="{{ asset('js/delete-button-modal.js') }}"></script>
@endsection

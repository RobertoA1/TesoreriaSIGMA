@extends('base.administrativo.blank')

@section('titulo')
  {{ $data['titulo'] }}
@endsection

@section('just-after-html')
  <div class="delete-modal hidden">
    @include('layout.modals.modal-01', [
      'caution_message' => '¿Estás seguro?',
      'action' => 'Estás eliminando la Matricula',
      'columns' => [
        'Fecha Matricula',
        'Año Escolar',
        'Alumno',
        'Grado',
        'Seccion',
        'Escala',
        'Observaciones'
      ],
      'rows' => [
        'null',
        'null',
        'null',
        'null',
        'null',
        'null',
        'null'
      ],
      'last_warning_message' => 'Borrar esto afectará a todo lo que esté vinculado a esta Matricula',
      'confirm_button' => 'Sí, bórralo',
      'cancel_button' => 'Cancelar',
      'is_form' => true,
      'data_input_name' => 'id'
    ])
  </div>

@endsection

@section('contenido')
  @if(isset($data['created']))
    @include('layout.alerts.animated.timed-alert',[
      'message' => 'La matricula ha sido registrada exitosamente.',
      'route' => 'layout.alerts.success' 
    ])
  @endif

  @if(isset($data['edited']))
    @include('layout.alerts.animated.timed-alert',[
      'message' => 'La matricula ha sido editada exitosamente.',
      'route' => 'layout.alerts.orange-success' 
    ])
  @endif

  @if(isset($data['abort']))
    @include('layout.alerts.animated.timed-alert',[
      'message' => 'La acción sobre la matricula ha sido cancelada.',
      'route' => 'layout.alerts.info' 
    ])
  @endif

  @if(isset($data['deleted']))
    @include('layout.alerts.animated.timed-alert',[
      'message' => 'La matricula ha sido eliminada exitosamente.',
      'route' => 'layout.alerts.red-success' 
    ])
  @endif

  @include('layout.tables.table-01-2', $data)
@endsection

@section('custom-js')
  <script src="{{ asset('js/tables.js') }}"></script>
  <script src="{{ asset('js/delete-button-modal.js') }}"></script>
@endsection
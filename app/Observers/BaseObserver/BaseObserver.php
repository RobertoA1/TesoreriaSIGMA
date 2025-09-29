<?php

namespace App\Observers\BaseObserver;

use App\Observers\Traits\LogsActions;
use Illuminate\Database\Eloquent\Model;

abstract class BaseObserver
{
    use LogsActions;

    /**
     * Handle the model "created" event.
     */
    public function created(Model $model): void
    {
        $this->logAction($model, 'CREAR', $model);
    }

    /**
     * Handle the model "updated" event.
     */
    public function updated(Model $model): void
    {
        if ($model->isDirty('estado') && $model->estado == 0) {
            $this->logAction($model, 'ELIMINAR', $model, 'Registro marcado como inactivo');
        } else {
            $this->logAction($model, 'EDITAR', $model);
        }
    }

    /**
     * Handle the model "deleted" event.
     */
    public function deleted(Model $model): void
    {
        $this->logAction($model, 'ELIMINAR', $model, 'Eliminación física del registro');
    }

    /**
     * Handle the model "restored" event.
     */
    public function restored(Model $model): void
    {
        $this->logAction($model, 'RESTAURAR', $model);
    }
}

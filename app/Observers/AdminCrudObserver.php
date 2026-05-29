<?php

namespace App\Observers;

use App\Services\AuditLogger;
use Illuminate\Database\Eloquent\Model;

class AdminCrudObserver
{
    public function created(Model $model): void
    {
        AuditLogger::log(
            eventCode: 'ADMIN_CRUD_CREATE',
            severity: 'info',
            message: class_basename($model).' #'.$model->getKey().' created',
            refTable: $model->getTable(),
            refId: $model->getKey(),
        );
    }

    public function updated(Model $model): void
    {
        $changed = array_keys($model->getDirty());
        AuditLogger::log(
            eventCode: 'ADMIN_CRUD_UPDATE',
            severity: 'info',
            message: class_basename($model).' #'.$model->getKey().' updated: '.implode(', ', $changed),
            meta: ['changed' => $changed],
            refTable: $model->getTable(),
            refId: $model->getKey(),
        );
    }

    public function deleted(Model $model): void
    {
        AuditLogger::log(
            eventCode: 'ADMIN_CRUD_DELETE',
            severity: 'warning',
            message: class_basename($model).' #'.$model->getKey().' deleted',
            refTable: $model->getTable(),
            refId: $model->getKey(),
        );
    }
}

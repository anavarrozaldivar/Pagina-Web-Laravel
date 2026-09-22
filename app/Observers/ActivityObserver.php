<?php

namespace App\Observers;

use App\Support\ActivityLogService;
use Illuminate\Database\Eloquent\Model;

class ActivityObserver
{
    public function created(Model $model): void
    {
        ActivityLogService::modelCreated($model);
    }

    public function updated(Model $model): void
    {
        ActivityLogService::modelUpdated($model);
    }

    public function deleted(Model $model): void
    {
        ActivityLogService::modelDeleted($model);
    }
}
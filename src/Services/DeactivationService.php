<?php

namespace NemanjaIlic\ModelDeactivator\Services;

use NemanjaIlic\ModelDeactivator\Models\TemporarilyDeactivated;
use NemanjaIlic\ModelDeactivator\Jobs\ReactivateModelJob;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class DeactivationService
{
    public function deactivateModel(Model $model, int $minutes): TemporarilyDeactivated
    {
        if (method_exists($model, 'getAttributes') && array_key_exists('active', $model->getAttributes())) {
            $model->update(['active' => false]);
        } else {
            $model->active = false;
            $model->save();
        }

        $record = TemporarilyDeactivated::create([
            'deactivatable_type' => get_class($model),
            'deactivatable_id' => $model->getKey(),
            'deactivate_until' => Carbon::now()->addMinutes($minutes),
        ]);

        ReactivateModelJob::dispatch($record->id)->delay(now()->addMinutes($minutes));

        return $record;
    }
}
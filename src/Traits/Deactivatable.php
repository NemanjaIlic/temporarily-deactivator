<?php

namespace NemanjaIlic\ModelDeactivator\Traits;

use NemanjaIlic\ModelDeactivator\Models\TemporarilyDeactivated;
use NemanjaIlic\ModelDeactivator\Services\DeactivationService;
use Illuminate\Database\Eloquent\Model;

trait Deactivatable
{
    public function isTemporarilyDeactivated(): bool
    {
        return TemporarilyDeactivated::where('deactivatable_type', get_class($this))
            ->where('deactivatable_id', $this->getKey())
            ->where('deactivate_until', '>', now())
            ->exists();
    }

    public function deactivateForMinutes(int $minutes): TemporarilyDeactivated
    {
        $svc = app('deactivator');
        return $svc->deactivateModel($this, $minutes);
    }

    public function reactivateNow(): bool
    {
        $this->update(['active' => true]);
        return (bool) TemporarilyDeactivated::where('deactivatable_type', get_class($this))
            ->where('deactivatable_id', $this->getKey())
            ->delete();
    }
}
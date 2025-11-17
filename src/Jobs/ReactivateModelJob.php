<?php

namespace NemanjaIlic\ModelDeactivator\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use NemanjaIlic\ModelDeactivator\Models\TemporarilyDeactivated;

class ReactivateModelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $recordId;

    public function __construct(int $recordId)
    {
        $this->recordId = $recordId;
    }

    public function handle()
    {
        $entry = TemporarilyDeactivated::find($this->recordId);
        if (!$entry) return;

        $model = $entry->deactivatable;
        if ($model) {
            try {
                if (method_exists($model, 'getAttributes') && array_key_exists('active', $model->getAttributes())) {
                    $model->update(['active' => true]);
                } else {
                    $model->active = true;
                    $model->save();
                }
            } catch (\Throwable $e) {
                \Log::error('ReactivateModelJob error: ' . $e->getMessage());
            }
        }
        $entry->delete();
    }
}
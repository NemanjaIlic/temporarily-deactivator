<?php

namespace NemanjaIlic\ModelDeactivator\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use NemanjaIlic\ModelDeactivator\Services\DeactivationService;

class TemporaryDeactivateController extends Controller
{
    public function store(Request $request, DeactivationService $svc)
    {
        $data = $request->validate([
            'model_type' => 'required|string',
            'model_id'   => 'required|integer',
            'minutes'    => 'required|integer|min:1'
        ]);

        if (!class_exists($data['model_type'])) {
            return back()->withErrors(['model_type' => 'Invalid model type.']);
        }

        $modelClass = $data['model_type'];
        $model = $modelClass::findOrFail($data['model_id']);

        $record = $svc->deactivateModel($model, (int)$data['minutes']);

        return back()->with('status', 'Model deactivated until ' . $record->deactivate_until->toDateTimeString());
    }
}
<?php

namespace App\Http\Controllers;

use App\Actions\ConfigureStoreHoursAction;
use App\Http\Requests\ConfigureStoreHoursRequest;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ConfigureStoreHoursRequest $request)
    {
        return ConfigureStoreHoursAction::run($request->input('storeHours'));
    }
}

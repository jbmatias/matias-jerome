<?php

namespace App\Http\Controllers;

use App\Actions\GetStoreHoursAction;
use App\Http\Requests\GetStoreHoursRequest;
use Illuminate\Http\Request;

class GetStoreHoursController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(GetStoreHoursRequest $request)
    {
        return GetStoreHoursAction::run();
    }
}

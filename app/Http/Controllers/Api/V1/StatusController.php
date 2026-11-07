<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\StatusResource;
use App\Services\ApplicationStatusService;

class StatusController extends Controller
{
    public function __invoke(ApplicationStatusService $status): StatusResource
    {
        return new StatusResource((object) $status->current());
    }
}

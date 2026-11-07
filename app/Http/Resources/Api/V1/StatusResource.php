<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatusResource extends JsonResource
{
    /**
     * @return array{application: string, status: string, timestamp: string}
     */
    public function toArray(Request $request): array
    {
        return [
            'application' => $this->application,
            'status' => $this->status,
            'timestamp' => $this->timestamp,
        ];
    }
}

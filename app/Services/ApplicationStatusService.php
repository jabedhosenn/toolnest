<?php

namespace App\Services;

class ApplicationStatusService
{
    /**
     * @return array{application: string, status: string, timestamp: string}
     */
    public function current(): array
    {
        return [
            'application' => (string) config('app.name'),
            'status' => 'ok',
            'timestamp' => now()->toIso8601String(),
        ];
    }
}

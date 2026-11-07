<?php

namespace Tests\Feature;

use Tests\TestCase;

class StatusEndpointTest extends TestCase
{
    public function test_status_endpoint_returns_application_health(): void
    {
        $this->getJson(route('v1.status'))
            ->assertOk()
            ->assertJsonPath('data.status', 'ok')
            ->assertJsonPath('data.application', config('app.name'));
    }

    public function test_spa_shell_is_served_for_the_application_root(): void
    {
        $this->get(route('app'))
            ->assertOk()
            ->assertSee('id="app"', false);
    }
}

<?php

declare(strict_types=1);

test('application health check responds ok', function (): void {
    $response = $this->get('/up');

    $response->assertOk();
});

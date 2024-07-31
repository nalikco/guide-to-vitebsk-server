<?php

declare(strict_types=1);

use App\Services\Telegram\TokenService;
use League\Config\ConfigurationInterface;
use Mockery\MockInterface;

it('should get token from config', function () {
    $token = 'token';

    $configuration = Mockery::mock(
        ConfigurationInterface::class,
        function (MockInterface $mock) use ($token) {
            $mock->shouldReceive('get')
                ->with('telegram.token')
                ->andReturn($token);
        }
    );
    $service = new TokenService($configuration);

    expect($service->getToken())->toBe($token);
});

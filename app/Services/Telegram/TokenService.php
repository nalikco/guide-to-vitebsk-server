<?php

declare(strict_types=1);

namespace App\Services\Telegram;

use App\Contracts\Telegram\TokenProviderContract;
use League\Config\ConfigurationInterface;

readonly class TokenService implements TokenProviderContract
{
    public function __construct(
        private ConfigurationInterface $config,
    ) {}

    #[\Override]
    public function getToken(): string
    {
        return $this->config->get('telegram.token');
    }
}

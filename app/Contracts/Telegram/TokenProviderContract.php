<?php

declare(strict_types=1);

namespace App\Contracts\Telegram;

interface TokenProviderContract
{
    /**
     * Returns the Telegram bot token.
     *
     * @return string Telegram bot token.
     */
    public function getToken(): string;
}

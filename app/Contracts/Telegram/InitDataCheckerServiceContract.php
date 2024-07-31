<?php

declare(strict_types=1);

namespace App\Contracts\Telegram;

interface InitDataCheckerServiceContract
{
    /**
     * Check if the provided init data match the hash value.
     *
     * @param  string  $botToken  The Telegram Bot token.
     * @param  string  $initData  The Telegram Mini App Init Data.
     * @return bool Returns true if the hash matches the calculated hash from the data values, false otherwise.
     */
    public function check(string $botToken, string $initData): bool;
}

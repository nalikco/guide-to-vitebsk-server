<?php

declare(strict_types=1);

namespace App\Services\Telegram;

use App\Contracts\Telegram\InitDataCheckerServiceContract;
use Override;
use Psr\Log\LoggerInterface;

readonly class InitDataCheckerService implements InitDataCheckerServiceContract
{
    public function __construct(
        private LoggerInterface $logger,
    ) {}

    #[Override]
    public function check(string $botToken, string $initData): bool
    {
        $op = __METHOD__;

        parse_str($initData, $initDataValues);
        $initDataValues = array_filter($initDataValues, is_string(...), ARRAY_FILTER_USE_KEY);

        $hash = $initDataValues['hash'] ?? null;

        $this->logger->debug('values prepared', [
            'op' => $op,
            'values' => $initDataValues,
        ]);

        unset($initDataValues['hash']);
        ksort($initDataValues);
        $dataCheckString = implode(
            "\n",
            array_map(
                fn ($n, $v) => "$n=$v",
                array_keys($initDataValues),
                $initDataValues,
            )
        );

        $this->logger->debug('values concatenated', [
            'op' => $op,
            'values' => $initDataValues,
        ]);

        $secretKey = hash_hmac('sha256', $botToken, 'WebAppData', true);
        $key = hash_hmac('sha256', $dataCheckString, $secretKey);

        $this->logger->debug('hash generated', [
            'op' => $op,
            'secret_key' => $secretKey,
            'key' => $key,
        ]);

        return $key === $hash;
    }
}

<?php

declare(strict_types=1);

namespace App\Dto\Telegram;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;

class InitData extends Data
{
    public function __construct(
        #[MapName('auth_date')]
        public string $authDate,
        #[MapName('query_id')]
        public string $queryId,
        public UserData $user,
        public string $hash,
    ) {}
}

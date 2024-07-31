<?php

declare(strict_types=1);

namespace App\Dto\Telegram;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(
        public int $id,
        #[MapName('first_name')]
        public string $firstName,
        #[MapName('last_name')]
        public string $lastName,
        public string $username,
        #[MapName('language_code')]
        public string $languageCode,
        #[MapName('allows_write_to_pm')]
        public bool $allowsWriteToPm,
    ) {}
}

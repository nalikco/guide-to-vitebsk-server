<?php

declare(strict_types=1);

namespace App\Dto\Authenticate;

use App\Models\User;
use Spatie\LaravelData\Data;

class AuthenticateResultData extends Data
{
    public function __construct(
        public readonly User $user,
        public readonly string $accessToken,
    ) {}
}

<?php

declare(strict_types=1);

namespace App\Services\Users;

use App\Contracts\Users\AuthenticateServiceContract;
use App\Models\User;
use Override;

class AuthenticateService implements AuthenticateServiceContract
{
    #[Override]
    public function authenticate(User $user): string
    {
        return $user->createToken('Web')
            ->plainTextToken;
    }
}

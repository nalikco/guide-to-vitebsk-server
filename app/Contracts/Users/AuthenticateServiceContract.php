<?php

declare(strict_types=1);

namespace App\Contracts\Users;

use App\Models\User;

interface AuthenticateServiceContract
{
    /**
     * Create a new token for the user.
     *
     * @param  User  $user  The user to authenticate.
     * @return string The token.
     */
    public function authenticate(User $user): string;
}

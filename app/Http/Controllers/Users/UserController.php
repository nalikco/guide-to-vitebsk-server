<?php

declare(strict_types=1);

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\UserResource;
use Illuminate\Auth\AuthManager;

class UserController extends Controller
{
    public function __construct(
        private readonly AuthManager $authManager,
    ) {}

    public function __invoke(): UserResource
    {
        return new UserResource($this->authManager->user());
    }
}

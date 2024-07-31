<?php

declare(strict_types=1);

namespace App\Http\Controllers\Authenticate;

use App\Actions\Authenticate\AuthenticateAction;
use App\Exceptions\Authenticate\AuthenticateFailedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\LoginRequest;
use App\Http\Resources\Users\AuthenticateResource;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateController extends Controller
{
    public function __construct(
        private readonly AuthenticateAction $action,
    ) {}

    /**
     * Execute the controller action for the given request.
     *
     * @param  LoginRequest  $request  The login request object.
     * @return AuthenticateResource The authenticate resource object.
     */
    public function __invoke(LoginRequest $request): AuthenticateResource
    {
        try {
            $data = ($this->action)($request->validated('init_data'));
        } catch (AuthenticateFailedException) {
            abort(Response::HTTP_UNAUTHORIZED);
        }

        return new AuthenticateResource($data);
    }
}

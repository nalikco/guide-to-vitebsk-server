<?php

declare(strict_types=1);

namespace App\Actions\Authenticate;

use App\Contracts\Telegram\InitDataCheckerServiceContract;
use App\Contracts\Telegram\TokenProviderContract;
use App\Contracts\Users\AuthenticateServiceContract;
use App\Dto\Authenticate\AuthenticateResultData;
use App\Exceptions\Authenticate\AuthenticateFailedException;
use App\Factories\Telegram\InitDataFactory;
use App\Models\User;
use Psr\Log\LoggerInterface;

readonly class AuthenticateAction
{
    public function __construct(
        private InitDataCheckerServiceContract $initDataCheckerService,
        private TokenProviderContract $tokenProvider,
        private AuthenticateServiceContract $authenticateService,
        private LoggerInterface $logger,
    ) {}

    /**
     * Invokes the action with the given initial data string.
     *
     * @param  string  $initDataString  The initial data string.
     * @return AuthenticateResultData The result of the action.
     *
     * @throws AuthenticateFailedException If the initial data is not valid.
     */
    public function __invoke(string $initDataString): AuthenticateResultData
    {
        $op = __METHOD__;

        $this->validateInitData($initDataString);
        $initData = InitDataFactory::make($initDataString);
        $this->logger->debug('initial data object created', ['op' => $op, 'init_data' => $initDataString]);

        $user = User::query()->firstOrCreate([
            'telegram_id' => $initData->user->id,
        ], $initData->user->toArray());
        $this->logger->debug('user created', ['op' => $op, 'init_data' => $initDataString, 'user_id' => $user->id]);

        $accessToken = $this->authenticateService->authenticate($user);
        $this->logger->debug('access token created', ['op' => $op, 'init_data' => $initDataString, 'user_id' => $user->id]);

        return AuthenticateResultData::from([
            'user' => $user,
            'accessToken' => $accessToken,
        ]);
    }

    /**
     * Validates the initial data by checking it against a token using the initDataCheckerService.
     *
     * @param  string  $initData  The initial data to be validated.
     *
     * @throws AuthenticateFailedException If the initial data is not valid.
     */
    private function validateInitData(string $initData): void
    {
        $op = __METHOD__;

        $token = $this->tokenProvider->getToken();
        $this->logger->debug('token received', ['op' => $op, 'init_data' => $initData]);

        if (! $this->initDataCheckerService->check($token, $initData)) {
            $this->logger->warning('initial data is not valid', ['op' => $op, 'init_data' => $initData]);
            throw new AuthenticateFailedException;
        }

        $this->logger->debug('initial data is valid', ['op' => $op, 'init_data' => $initData]);
    }
}

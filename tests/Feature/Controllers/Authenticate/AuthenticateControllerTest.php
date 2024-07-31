<?php

declare(strict_types=1);

use App\Contracts\Telegram\TokenProviderContract;
use App\Http\Resources\Users\UserResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Mockery\MockInterface;
use Symfony\Component\HttpFoundation\Response;

uses(RefreshDatabase::class);

$token = 'a3c8f1bd39c3666a18a92a8d290dc167d71be95e2df899a4b30526a48b9b0a67';

it('can authenticate', function () use ($token) {
    $initData = 'auth_date=1712603287&query_id=QoCJwq2LEOltYeZ0&user=%7B%22id%22%3A3453455%2C%22first_name%22%3A%22John%22%2C%22last_name%22%3A%22Doe%22%2C%22username%22%3A%22johndoe%22%2C%22language_code%22%3A%22en%22%2C%22allows_write_to_pm%22%3Atrue%7D&hash=a572c00d30c1407ec9d7357241b1558c6ec5fcc41cffe6484d0efca54423511b';

    $this->mock(
        TokenProviderContract::class,
        function (MockInterface $mock) use ($token) {
            $mock
                ->shouldReceive('getToken')
                ->andReturn($token);
        }
    );

    $response = $this->postJson(route('login'), [
        'init_data' => $initData,
    ]);

    $user = User::query()->first();

    $response->assertOk();
    $response->assertJsonStructure([
        'data' => [
            'access_token',
            'user',
        ],
    ]);
    $response->assertJson([
        'data' => [
            'user' => (new UserResource($user))->toArray(new Request),
        ],
    ]);
});

it('cant authenticate with wrong init data', function () use ($token) {
    $initData = 'wrong';

    $this->mock(
        TokenProviderContract::class,
        function (MockInterface $mock) use ($token) {
            $mock
                ->shouldReceive('getToken')
                ->andReturn($token);
        }
    );

    $response = $this->postJson(route('login'), [
        'init_data' => $initData,
    ]);

    expect(User::query()->count())->toBe(0)
        ->and($response->status())->toBe(Response::HTTP_UNAUTHORIZED);
});

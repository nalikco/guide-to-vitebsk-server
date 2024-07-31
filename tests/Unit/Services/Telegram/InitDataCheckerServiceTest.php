<?php

declare(strict_types=1);

use App\Services\Telegram\InitDataCheckerService;
use Mockery\MockInterface;
use Psr\Log\LoggerInterface;

$token = 'a3c8f1bd39c3666a18a92a8d290dc167d71be95e2df899a4b30526a48b9b0a67';
$initData = 'auth_date=1712603287&query_id=QoCJwq2LEOltYeZ0&user=%7B%22id%22%3A3453455%2C%22first_name%22%3A%22John%22%2C%22last_name%22%3A%22Doe%22%2C%22username%22%3A%22johndoe%22%2C%22language_code%22%3A%22en%22%2C%22allows_write_to_pm%22%3Atrue%7D&hash=a572c00d30c1407ec9d7357241b1558c6ec5fcc41cffe6484d0efca54423511b';

it('should check', function () use ($token, $initData) {
    $logger = Mockery::mock(
        LoggerInterface::class,
        function (MockInterface $mock) {
            $mock->shouldReceive('debug');
        }
    );
    $dataChecker = new InitDataCheckerService($logger);

    expect($dataChecker->check($token, $initData))->toBeTrue();
});

it('should return false: invalid token', function () use ($initData) {
    $logger = Mockery::mock(
        LoggerInterface::class,
        function (MockInterface $mock) {
            $mock->shouldReceive('debug');
        }
    );
    $dataChecker = new InitDataCheckerService($logger);

    expect($dataChecker->check('invalid', $initData))->toBeFalse();
});

it('should return false: invalid hash', function () use ($token) {
    $initData = 'auth_date=1712603287&query_id=QoCJwq2LEOltYeZ0&user=%7B%22id%22%3A3453455%2C%22first_name%22%3A%22John%22%2C%22last_name%22%3A%22Doe%22%2C%22username%22%3A%22johndoe%22%2C%22language_code%22%3A%22en%22%2C%22allows_write_to_pm%22%3Atrue%7D&hash=invalid';

    $logger = Mockery::mock(
        LoggerInterface::class,
        function (MockInterface $mock) {
            $mock->shouldReceive('debug');
        }
    );
    $dataChecker = new InitDataCheckerService($logger);

    expect($dataChecker->check($token, $initData))->toBeFalse();
});

it('should return false: invalid struct', function () use ($token) {
    $initData = 'auth_date=1712603287&query_id=QoCJwq2LEOltYeZ0&user=%7B%22id%22%3A0%2C%22first_name%22%3A%22John%22%2C%22last_name%22%3A%22Doe%22%2C%22username%22%3A%22johndoe%22%2C%22language_code%22%3A%22en%22%2C%22allows_write_to_pm%22%3Atrue%7D&hash=a572c00d30c1407ec9d7357241b1558c6ec5fcc41cffe6484d0efca54423511b';

    $logger = Mockery::mock(
        LoggerInterface::class,
        function (MockInterface $mock) {
            $mock->shouldReceive('debug');
        }
    );
    $dataChecker = new InitDataCheckerService($logger);

    expect($dataChecker->check($token, $initData))->toBeFalse();
});

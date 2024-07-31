<?php

declare(strict_types=1);

use App\Factories\Telegram\InitDataFactory;

it('should make Dto', function () {
    $initDataString = 'auth_date=1712603287&query_id=QoCJwq2LEOltYeZ0&user=%7B%22id%22%3A3453455%2C%22first_name%22%3A%22John%22%2C%22last_name%22%3A%22Doe%22%2C%22username%22%3A%22johndoe%22%2C%22language_code%22%3A%22en%22%2C%22allows_write_to_pm%22%3Atrue%7D&hash=a572c00d30c1407ec9d7357241b1558c6ec5fcc41cffe6484d0efca54423511b';

    $initData = InitDataFactory::make($initDataString);

    expect($initData->authDate)->toBe('1712603287')
        ->and($initData->queryId)->toBe('QoCJwq2LEOltYeZ0')
        ->and($initData->user->id)->toBe(3453455)
        ->and($initData->user->firstName)->toBe('John')
        ->and($initData->user->lastName)->toBe('Doe')
        ->and($initData->user->username)->toBe('johndoe')
        ->and($initData->user->languageCode)->toBe('en')
        ->and($initData->user->allowsWriteToPm)->toBeTrue()
        ->and($initData->hash)->toBe('a572c00d30c1407ec9d7357241b1558c6ec5fcc41cffe6484d0efca54423511b');
});

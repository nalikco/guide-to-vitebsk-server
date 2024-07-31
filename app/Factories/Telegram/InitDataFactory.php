<?php

declare(strict_types=1);

namespace App\Factories\Telegram;

use App\Dto\Telegram\InitData;

readonly class InitDataFactory
{
    /**
     * Creates an instance of the InitData class from the given initialization data.
     *
     * @param  string  $initData  The initialization data as a string.
     * @return InitData The created instance of the InitData class.
     */
    public static function make(string $initData): InitData
    {
        $initDataValues = [];
        parse_str($initData, $initDataValues);

        $user = json_decode($initDataValues['user'], true);

        return InitData::from([
            ...$initDataValues,
            'user' => $user,
        ]);
    }
}

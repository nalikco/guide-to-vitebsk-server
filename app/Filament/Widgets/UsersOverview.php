<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Override;

class UsersOverview extends BaseWidget
{
    #[Override]
    protected function getStats(): array
    {
        return [];
    }
}

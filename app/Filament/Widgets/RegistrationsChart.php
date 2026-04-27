<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Trader;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class RegistrationsChart extends ChartWidget
{
    protected static ?string $heading = 'User & Trader Registrations';

    protected function getData(): array
    {
        $months = collect(range(1, 12))->map(function ($month) {
            return Carbon::create(null, $month, 1)->format('M');
        });

        $userCounts = [];
        $traderCounts = [];

        foreach (range(1, 12) as $month) {
            $userCounts[] = User::whereYear('created_at', date('Y'))
                ->whereMonth('created_at', $month)
                ->count();

            $traderCounts[] = Trader::whereYear('created_at', date('Y'))
                ->whereMonth('created_at', $month)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Users',
                    'data' => $userCounts,
                    'backgroundColor' => 'rgb(59, 130, 246)',
                    'borderColor' => 'rgb(59, 130, 246)',
                ],
                [
                    'label' => 'Traders',
                    'data' => $traderCounts,
                    'backgroundColor' => 'rgb(16, 185, 129)',
                    'borderColor' => 'rgb(16, 185, 129)',
                ],
            ],
            'labels' => $months->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

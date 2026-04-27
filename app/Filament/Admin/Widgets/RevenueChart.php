<?php

namespace App\Filament\Admin\Widgets;

use App\Models\RechargeOperation;
use Filament\Widgets\ChartWidget;

class RevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Revenue Overview';

    protected static ?int $sort = 5;

    protected function getData(): array
    {
        // Get data for the last 6 months
        $data = [];
        $labels = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $labels[] = $date->format('M Y');

            $total = RechargeOperation::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('amount');

            $data[] = $total ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Revenue',
                    'data' => $data,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.2)',
                    'borderColor' => 'rgb(34, 197, 94)',
                    'borderWidth' => 2,
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    public function getDescription(): ?string
    {
        return 'Monthly revenue from recharge operations';
    }
}

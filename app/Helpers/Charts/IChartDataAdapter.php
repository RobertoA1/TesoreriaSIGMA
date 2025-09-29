<?php

namespace App\Helpers\Charts;

use App\Helpers\Charts\IChartDataset;
use App\Helpers\Charts\IChartOptions;

interface IChartDataAdapter{
    public function type(string $type = null): string;
    public function labels(array $labels = null): array;
    public function datasets(): array;
    public function addDataset(IChartDataset $dataset): int;
    public function removeDataset(int $index): IChartDataset;
    public function options(IChartOptions $options = null): array;
    public function chartData(): array;
}


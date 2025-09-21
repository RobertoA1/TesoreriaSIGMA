<?php

namespace App\Helpers\Charts;

interface IChartDataset {
    public function label(string $label = null): string;
    public function data(array $data = null): array;
    public function options(array $options = null): array;
    public function dataset(): array;
}
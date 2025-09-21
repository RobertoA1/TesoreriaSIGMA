<?php

namespace App\Helpers\Charts;

use App\Helpers\Charts\IChartDataAdapter;
use App\Helpers\Charts\IChartDataset;
use App\Helpers\Charts\IChartOptions;

abstract class ChartDataAdapter implements IChartDataAdapter{
    protected string $type = "";
    protected array $labels = [];
    protected array $datasets = [];
    protected array $options = [];

    public function type(string $type = null): string {
        if ($type != null) $this->type = $type;
        return $this->type;
    }

    public function labels(array $labels = null): array {
        if ($labels != null) $this->labels = $labels;
        return $this->labels;
    }

    public function datasets(): array{
        return $this->datasets;
    }

    public function addDataset(IChartDataset $dataset): int{
        $quantity = array_push($this->datasets, $dataset->dataset());
        return $quantity - 1;
    }

    public function removeDataset(int $index): IChartDataset{
        $removed = $this->datasets[$index];
        array_splice($this->datasets, $index, 1);
        return $removed;
    }

    public function options(IChartOptions $options = null): array{
        if ($options != null) $this->options = $options->options();
        return $this->options;
    }
}
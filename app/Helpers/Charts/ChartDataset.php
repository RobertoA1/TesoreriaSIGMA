<?php

namespace App\Helpers\Charts;

abstract class ChartDataset implements IChartDataset{
    protected string $label = "";
    protected array $data = [];
    protected array $options = [];

    public function label(string $label = null): string{
        if ($label != null) $this->label = $label;
        return $this->label;
    }
    public function data(array $data = null): array{
        if ($data != null) $this->data = $data;
        return $this->data;
    }
    public function options(array $options = null): array{
        if ($options != null) $this->options = $options;
        return $this->options;
    }
}
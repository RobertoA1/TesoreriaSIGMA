<?php

namespace App\Helpers\Charts;

interface IChartOptions
{
    public function setOption(string $key, $value): void;
    public function getOption(string $key);
    public function options(): array;
}
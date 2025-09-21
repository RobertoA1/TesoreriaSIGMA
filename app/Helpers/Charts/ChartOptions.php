<?php

namespace App\Helpers\Charts;

abstract class ChartOptions implements IChartOptions
{
    protected $options = [];

    public function setOption(string $key, $value): void{
        $this->options[$key] = $value;
    }
    public function getOption(string $key){
        return $this->options[$key];
    }
}
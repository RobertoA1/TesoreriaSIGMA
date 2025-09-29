<?php

namespace App\Helpers\GraphJS;

use App\Helpers\Charts\ChartDataAdapter;

class GraphJSDataAdapter extends ChartDataAdapter{
    public function chartData(): array {
        return [
            "type" => $this->type(),
            "data" => [
                "labels" => $this->labels(),
                "datasets" => $this->datasets(),
            ],
            "options" => $this->options(),
        ];
    }
}
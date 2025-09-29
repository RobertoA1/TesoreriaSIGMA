<?php

namespace App\Helpers\GraphJS;

use App\Helpers\Charts\ChartDataset;

class GraphJSDataset extends ChartDataset{
    public function dataset(): array {
        return array_merge(
            [
                "label" => $this->label(),
                "data" => $this->data(),
            ],
            $this->options()
        );
    }
}
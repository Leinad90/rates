<?php

namespace App\Model;

class OrderNumbers
{
    public function sort(array $numbers): array
    {
        uasort($numbers, function ($a, $b) {return $this->compare($a,$b);});
        return $numbers;
    }

    private function toNumber(string $param): float
    {
        return (float)filter_var($param,FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION|FILTER_FLAG_ALLOW_SCIENTIFIC);
    }

    private function compare(string $a, string $b): int
    {
        $a = $this->toNumber($a);
        $b = $this->toNumber($b);
        return $a>$b ? 1 : ($a<$b ? -1 : 0);
    }
}
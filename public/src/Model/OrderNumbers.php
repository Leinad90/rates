<?php

namespace App\Model;

class OrderNumbers
{
    public function sort(array $numbers): array
    {
        usort($numbers, [$this, 'compare']);
        return $numbers;
    }

    private function toNumber(string $param): float
    {
        return (float)filter_var($param,FILTER_SANITIZE_NUMBER_FLOAT);
    }

    private function compare(string $a, string $b): int
    {
        $a=$this->toNumber($a);
        $b=$this->toNumber($b);
        return $a>$b ? 1 : ($a<$b ? -1 : 0);
    }
}
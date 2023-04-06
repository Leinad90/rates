<?php

namespace App\Model;

class CoindeskDownloader
{

    public function __construct(private readonly string $url)
    {

    }
    public function get() : array
    {
        $data = file_get_contents($this->url);
        return json_decode($data,true);
    }
}
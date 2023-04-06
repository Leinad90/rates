<?php

namespace App\Model;

class CoindeskDownloader
{
    public static function get() : \stdClass
    {
        $data = file_get_contents('https://api.coindesk.com/v1/bpi/currentprice.json');
        return json_decode($data);
    }
}
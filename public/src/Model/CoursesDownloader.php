<?php

namespace App\Model;

use App\Entity\CoursesData;

interface CoursesDownloader
{

    /**
     * @throws CoursesDownloadException
     */
    public function get() : CoursesData;
}

class CoursesDownloadException extends \Exception
{

}
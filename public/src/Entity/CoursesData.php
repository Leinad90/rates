<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class CoursesData
{
    /** @var CourseData[] */
    public array $courses=[];

    public \DateTime $updated;

    public string $error="";

}
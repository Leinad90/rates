<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class CoursesData
{
    public array $courses;

    public \DateTime $updated;
}
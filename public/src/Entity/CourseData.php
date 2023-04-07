<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class CourseData
{
    #[Assert\NotBlank, Assert\Positive]
   public float $rate;

     #[Assert\NotBlank]
    public string $code;

     #[Assert\NotBlank]
     public string $symbol;

   public string $description="";
}
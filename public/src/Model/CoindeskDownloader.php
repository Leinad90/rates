<?php

namespace App\Model;

use App\Entity\CourseData;
use App\Entity\CoursesData;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CoindeskDownloader
{

    public function __construct(
        private readonly string $url,
        private readonly ValidatorInterface $validator
    )
    {

    }
    public function get() : CoursesData
    {
        $client = HttpClient::create();
        $interface = $client->request('GET',$this->url);
        $content = $interface->getContent();
        $data = json_decode($content);
        $return = new CoursesData();
        $return->updated = new \DateTime($data->time->updatedISO);
        foreach ($data->bpi as $code => $course) {
            $courseData = new CourseData();
            $courseData->code = $course->code;
            $courseData->rate = $course->rate_float;
            $courseData->symbol = $course->symbol;
            $courseData->description = $course->description;
            $return->courses[$code] = $courseData;
        }
        $errors = $this->validator->validate($return);
        if(count($errors)) {

        }
        return $return;
    }
}
<?php

namespace App\Model;

use App\Entity\CourseData;
use App\Entity\CoursesData;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class CoindeskDownloader implements CoursesDownloader
{

    public function __construct(
        private readonly string $url,
        private readonly ValidatorInterface $validator
    )
    {

    }

    /**
     * @throws CoursesDownloadException
     */
    public function get() : CoursesData
    {
        $client = HttpClient::create();
        try {
            $interface = $client->request('GET', '');
            $content = $interface->getContent();
        } catch (TransportExceptionInterface|HttpExceptionInterface $e) {
            throw new CoursesDownloadException(message: 'Could not download', previous: $e);
        }
        $data = json_decode($content);
        if($data===null) {
            throw new CoursesDownloadException(message: "Could not parse downloaded content\n".$content);
        }
        $return = new CoursesData();
        if(!property_exists($data,'time') || !property_exists($data->time,'updatedISO')) {
            throw new CoursesDownloadException("Downloaded data dosent not contain data->time->updatedIso \n".$data);
        }
        try {
            $return->updated = new \DateTime($data->time->updatedISO);
        } catch (\Exception $e) {
            throw new CoursesDownloadException("Downloaded date is not valid data->time->updatedIso \n".$data);
        }
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
            throw new CoursesDownloadException(message: "Download data is not valid\n".$errors->__toString()."\n".$data);
        }
        return $return;
    }
}


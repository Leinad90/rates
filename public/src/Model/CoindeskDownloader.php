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
            $interface = $client->request('GET', $this->url);
            $content = $interface->getContent();
        } catch (TransportExceptionInterface|HttpExceptionInterface $e) {
            throw new CoursesDownloadException(message: 'Could not download', previous: $e);
        }
        $data = json_decode($content);
        if(!is_object($data)) {
            throw new CoursesDownloadException(message: "Could not parse downloaded content\n".$content."\n".json_last_error_msg());
        }
        $return = new CoursesData();
        if(!property_exists($data,'time') || !property_exists($data->time,'updatedISO')) {
            throw new CoursesDownloadException("Downloaded data dosent not contain time->updatedIso \n".$content);
        }
        try {
            $return->updated = new \DateTime($data->time->updatedISO);
        } catch (\Exception $e) {
            throw new CoursesDownloadException("Downloaded date is not valid time->updatedIso \n".$content);
        }
        if(!property_exists($data,'bpi') || !$data->bpi instanceof \stdClass) {
            throw new CoursesDownloadException('Downloaded data is not valid - bpi is not array '.$content);
        }
        foreach ($data->bpi as $code => $course) {
            $courseData = new CourseData();
            if(!property_exists($course,'code')) {
                throw new CoursesDownloadException('Downloaded data dosent not contain bpi->'.$code."->code\n".$content);
            }
            $courseData->code = $course->code;
            if(!property_exists($course,'rate_float')) {
                throw new CoursesDownloadException('Downloaded data dosent not contain bpi->'.$code."->rate_float\n".$content);
            }
            $courseData->rate = $course->rate_float;
            if(!property_exists($course,'symbol')) {
                throw new CoursesDownloadException('Downloaded data dosent not contain bpi->'.$code."->symbol\n".$content);
            }
            $courseData->symbol = html_entity_decode($course->symbol);
            if(!property_exists($course,'description')) {
                throw new CoursesDownloadException('Downloaded data dosent not contain bpi->'.$code."->description\n".$content);
            }
            $courseData->description = $course->description;
            $return->courses[$code] = $courseData;
        }
        $errors = $this->validator->validate($return);
        if(count($errors)) {
            throw new CoursesDownloadException(message: "Download data is not valid\n".$errors."\n".$content); /** @phpstan-ignore-line ConstraintViolationListInterface is stringable */
        }
        return $return;
    }
}


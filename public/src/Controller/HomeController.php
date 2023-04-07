<?php
namespace App\Controller;

use App\Entity\CoursesData;
use App\Model\CoindeskDownloader;
use App\Model\CoursesDownloadException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    public function __construct (
        protected CoindeskDownloader $coindeskDownloader,
        protected LoggerInterface $logger
    )
    {

    }
   #[Route('/')]
    public function number(): Response
    {
        try {
            $data = $this->coindeskDownloader->get();
            $status = Response::HTTP_OK;
        } catch (CoursesDownloadException $e) {
            $this->logger->error($e);
            $data = new CoursesData();
            $data->error='Nepodařilo se zjistit aktuální kurzy';
            $status = Response::HTTP_SERVICE_UNAVAILABLE;
        }
        return new Response(
            $this->render('home.twig',['data'=>$data]),
            $status
        );
    }
}

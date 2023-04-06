<?php
namespace App\Controller;

use App\Model\CoindeskDownloader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    public function __construct (public CoindeskDownloader $coindeskDownloader)
    {

    }
   #[Route('/')]
    public function number(): Response
    {
        $data = $this->coindeskDownloader->get();
        return new Response(
            $this->render('home.twig',['data'=>$data])
        );
    }
}

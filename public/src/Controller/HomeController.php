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
        return new Response(
            var_export($this->coindeskDownloader->get(), true)
        );
    }
}

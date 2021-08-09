<?php

namespace App\Controller\Main;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends BaseController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $forRender = $this->renderDefault();
        return $this->render('main/index.html.twig', $forRender);
    }
}

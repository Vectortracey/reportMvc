<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    /**
     * @Route(
     *      "/proj",
     *      name="project-home",
     *      methods={"GET","HEAD"}
     * )
     */
    public function home(): Response
    {
        return $this->render('project/phome.html.twig');
    }

    /**
     * @Route(
     *      "/proj/about",
     *      name="project-about",
     *      methods={"GET","HEAD"}
     * )
     */
    public function about(): Response
    {
        return $this->render('project/pabout.html.twig');
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompteController extends AbstractController
{
    /**
     * @Route("/compte/{id<[0-9]+>}", name="app_compte")
     */
    public function index(): Response
    {
        $idUser=$this->getUser();
        return $this->render('compte/index.html.twig', [
            'iduser' => $idUser,
        ]);
    }
}

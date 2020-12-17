<?php

namespace App\Controller;

use App\Entity\Ctables;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TablesController extends AbstractController
{
    /**
     * @Route("/tables", name="tables")
     */
    public function index(Request $request): Response
    {

        $nbretables =new Ctables;
        $form= $this->createForm(NombresTablesType::class,$nbretables);
        $form->handleRequest($request);

        
        return $this->render('tables/index.html.twig', [
            '$nbretables' => $form->createView(),
        ]);
    }
}

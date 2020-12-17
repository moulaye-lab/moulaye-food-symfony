<?php

namespace App\Controller;

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

        $nbretables =new ;
        $form= $this->createForm(PropertySearchType::class,$search);
        $form->handleRequest($request);

        
        return $this->render('tables/index.html.twig', [
            'controller_name' => 'TablesController',
        ]);
    }
}

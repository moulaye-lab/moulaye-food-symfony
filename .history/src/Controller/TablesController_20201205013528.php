<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TablesController extends AbstractController
{
    /**
     * @Route("/tables", name="tables")
     */
    public function index(Request $request): Response
    {

        $search =new PropertySearch();
        $form= $this->createForm(PropertySearchType::class,$search);
        $form->handleRequest($request);

        
        return $this->render('tables/index.html.twig', [
            'controller_name' => 'TablesController',
        ]);
    }
}

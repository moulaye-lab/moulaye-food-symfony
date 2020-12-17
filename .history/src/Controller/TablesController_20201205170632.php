<?php

namespace App\Controller;

use App\Entity\Tables;
use App\Entity\Ctables;
use App\Entity\Restaurants;
use App\Form\NombresTablesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TablesController extends AbstractController
{
    /**
     * @Route("/tables/restaurant/{restaurant}", name="app_ajouter_tables")
     */
    public function index(Request $request,Restaurants $restaurant,EntityManagerInterface $em): Response
    {
        if ($restaurant->getProprietaire() != $this->getUser() | $this->getUser()==null ) {
            $this->addFlash('danger','Accès réfusé');
           return $this->redirectToRoute("app_home");
        }

        $nbretables =new Ctables;
        $form= $this->createForm(NombresTablesType::class,$nbretables);
        $form->handleRequest($request);

        
            if($nbretables){
            for ($i=1; $i<= $nbretables->getNombresTables() ; $i++) { 
               
                $tables=new Tables;
                $tables->setRestaurant($restaurant);
            for ($i=$tables->; $i <0;$i++) { 
                
            }
                $em->persist($tables);
                $em->flush();
            
                $this->addFlash("success","Tables bien ajouter");
    
            }       
    
        }
        
        
        return $this->render('tables/index.html.twig', [
            'nbresTables' => $form->createView(),
        ]);
    }
}
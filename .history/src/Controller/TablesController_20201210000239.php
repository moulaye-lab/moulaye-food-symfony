<?php

namespace App\Controller;

use App\Entity\Tables;
use App\Entity\Ctables;
use App\Form\TablesType;
use App\Entity\Restaurants;
use App\Form\NombresTablesType;
use App\Repository\TablesRepository;
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
    public function index(Request $request,TablesRepository $repo, Restaurants $restaurant,EntityManagerInterface $em): Response
    {
        if ($restaurant->getProprietaire() != $this->getUser() | $this->getUser()==null ) {
            $this->addFlash('danger','Accès réfusé');
           return $this->redirectToRoute("app_home");
        }
        $totalTables=$repo->findAllAll();
        $nbretables =new Ctables;
        $form= $this->createForm(NombresTablesType::class,$nbretables);
        $form->handleRequest($request);


            if($form->isSubmitted() AND $form->isValid()){
                $tablesAjouter=$nbretables->getnombresTables();
            for ($i=1; $i<= $tablesAjouter ; $i++) { 
               
                $tables=new Tables;
                $lastTables = $repo->findAll();

                if (count($lastTables) > 0) {

                    foreach ($lastTables as $value) {
                        $id = $value->getNumero();

                 }  
                 

 
                 $tables->setNumero($id+1);
                 $tables->setRestaurant($restaurant);
                $em->persist($tables);
               
                $em->flush();
                }else {
                    $tables->setNumero(1);

                    $tables->setRestaurant($restaurant);
                    $em->persist($tables);
               
                    $em->flush();
                }
                
            
                
                
    
            }       
            $this->addFlash("success","$tablesAjouter Tables bien ajouter");
            $this->redirectToRoute("app_ajouter_tables",[
                "restaurant" => $restaurant->getId()
            ]);

        }
        
        
        return $this->render('tables/index.html.twig', [
            'nbresTables' => $form->createView(),
            'totalTables' => $totalTables,
            'restaurant' => $restaurant
        ]);
    }



/**
     * @Route("/tables/{id<[0-9]+>}/edit", name="app_edit_tables", methods={"POST","GET"})
     */
    public function ediTables(Tables $table,Request $request,EntityManagerInterface $em): Response
    {   
        
        if ($table->getRestaurant()->getProprietaire() != $this->getUser() | $this->getUser()===null) {
            $this->addFlash('danger','Accès réfusé');
           die();
        }
        
        $form=$this->createForm(TablesType::class,$table);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $em->persist($table);
            $em->flush();
            $nom=$table->getNom();
            $restaurant=$table->getRestaurant()->getId();
            $this->redirectToRoute("app_ajouter_tables",[
                'restaurant'=> $restaurant
            ]);
            $this->addFlash('success',"Votre table s'appelle desormais $nom" );
            

        }
        
        return $this->render('tables/edit.html.twig', [
            'createResto' => $form->createView(),
            'table' => $table
        ]);
    }








}





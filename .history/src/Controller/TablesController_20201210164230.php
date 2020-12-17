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
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\QrCodeResponse;

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
                $resto=$restaurant->getId();
                if (count($lastTables) > 0) {

                    foreach ($lastTables as $value) {
                        $id = $value->getNumero();

                 }  
                 

                
                $tables->setNumero($id+1);
                $Ntable= $tables->getNumero();
                 $qrCode = new QrCode();
                 $qrCode->setText("https://127.0.0.1:8000/restaurant/$resto/table/$Ntable");
                
                
                 $qrCode->setSize(300);
                 $qrCode->setMargin(10); 
                 $qrCode->setWriterByName('png');
                 $qrCode->setEncoding('UTF-8');
                 $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH());
                 $qrCode->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0]);
                    $qrCode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);
                    $qrCode->setLabel('Scan the code');
                    $qrCode->setLogoSize(150, 200);
                    $qrCode->setValidateResult(false);
                 $tables->setCodeQr("$Ntable.png");
                 $tables->setRestaurant($restaurant);
                $em->persist($tables);
               
                $em->flush();

                }else {
                    $tables->setNumero(1);
                    $Ntable= $tables->getNumero();

                    $qrCode = new QrCode();
                 $qrCode->setText("https://127.0.0.1:8000/restaurant/$resto/table/$Ntable");
                 $qrCode->setSize(300);
                 $qrCode->setMargin(10); 
                 $qrCode->setWriterByName('png');
                 $qrCode->setEncoding('UTF-8');
                 $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH());
                 $qrCode->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0]);
                    $qrCode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);
                    $qrCode->setLabel('Scan the code');
                    $qrCode->setLogoSize(150, 200);
                    $qrCode->setValidateResult(false);
                 $tables->setCodeQr("$Ntable.png");
                    $tables->setRestaurant($restaurant);
                    $em->persist($tables);
               
                    $em->flush();
                }
                
            
                
                
    
            }    
              $qrCode->writeFile(__DIR__.'/qrcode.png');
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
            $this->addFlash('success',"Votre table s'appelle desormais $nom" );

          $this->redirectToRoute("app_ajouter_tables",[
                'restaurant'=> $restaurant
            ]);
            

        }
        
        return $this->render('tables/edit.html.twig', [
            'createResto' => $form->createView(),
            'table' => $table
        ]);
    }








}





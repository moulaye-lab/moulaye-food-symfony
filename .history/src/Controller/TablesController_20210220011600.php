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
use Dompdf\Dompdf;
use Dompdf\Options;

class TablesController extends AbstractController

{



    private function getRedirectLater($url, $seconds=0)
{
    $response = new Response;
    $response->headers->set('Refresh', $seconds.'; url='. $url);

    return $response;
}

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
        $totaltablesByResto=$repo->findByResto($restaurant);


            if($form->isSubmitted() AND $form->isValid()){
                $tablesAjouter=$nbretables->getnombresTables();
            for ($i=1; $i<= $tablesAjouter ; $i++) { 
               
                $tables=new Tables;
                $lastTables = $repo->findByResto($restaurant);
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
                 $path="../public/build/restaurant.$resto";
                    if (!is_dir($path)) {
                        mkdir($path, 0777);

                    }

                    $a= $qrCode->writeFile("$path./$Ntable.png");

                    

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
                 $path="../public/build/restaurant.$resto";
                    if (!is_dir($path)) {
                        mkdir($path, 0777);

                    }

                    $a= $qrCode->writeFile("$path./$Ntable.png");
                    $em->persist($tables);
               
                    $em->flush();
                }
                
            
                
                
    
            }    
         
            
            $this->addFlash("success","$tablesAjouter Tables bien ajouter");
           
            return $this->getRedirectLater($this->generateUrl('app_ajouter_tables', [ 'restaurant' => $restaurant->getId() ]));
        }
        
        
        return $this->render('tables/index.html.twig', [
            'nbresTables' => $form->createView(),
            'totalTables' => $totaltablesByResto,
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
                'restaurant'=> $restaurant,
                'table' => $table

            ]);
            

        }
        
        return $this->render('tables/edit.html.twig', [
            'createResto' => $form->createView(),
            'restaurant'=> $table->getRestaurant()->getId(),
            'table' => $table
        ]);
    }

 

        /**
     * @Route("/tables/{id<[0-9]+>}/upload", name="app_uploads_tables", methods="GET")
     */
    public function uploadsTable(Tables $table,Request $request,TablesRepository $repo): Void
    {   
        
        if ($table->getRestaurant()->getProprietaire() != $this->getUser() | $this->getUser()===null) {
            $this->addFlash('danger','Accès réfusé');
           die();
        }

        $resto=$table->getRestaurant();
        $Ntable=$table->getCodeQr();
        
    
        $mpdf = new \Mpdf\Mpdf();

        $mpdf->allow_charset_conversion=true;
        $mpdf->charset_in='UTF-8';
        $html = $this->renderView('tables/uploads.html.twig', [
            
            'restaurant'=> $resto,
            
            'table' => $table,

        ]);
        // Write some HTML code:
        $mpdf->WriteHTML($html,\Mpdf\HTMLParserMode::DEFAULT_MODE);
        $restoEtTable=$resto->getNom().$table->getNumero();
        // Output a PDF file directly to the browser
        $mpdf->Output("$restoEtTable", 'D');
        
    }
        
         

     
    
            
    /**
     * reservation
     *
     * @Route("/tables/{id<[0-9]+>}/reservation", name="app_table_reservation")
     */
    public function reservation(Tables $table) : Response {

     $reservation= $table->getReserved();
        
       if ($reservation===null) {
           
            $table->setReserved(1);

            $this->addFlash("success",",la table apparaitra comme reservée");

       }else if ($reservation===1) {
          
        $table->setReserved(0);
        
        $this->addFlash("success",",la table apparaitra comme libre");

       }


       return $this->redirectToRoute('app_ajouter_tables',[

        "restaurant" => $table->getRestaurant()
       ]);

    }


}





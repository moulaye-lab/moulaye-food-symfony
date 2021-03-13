<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\ImagesResto;
use App\Entity\Restaurants;
use App\Form\CreateRestaurantType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RestaurantsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RestaurantController extends AbstractController
{
    /**
     * @Route("/restaurant", name="app_restaurant")
     */
    public function index(RestaurantsRepository $repo): Response
    {       
        if ($this->getUser()===null ) {
            $this->addFlash('error','Diantre veuillez vous connecter pour y acceder!!!!');
            return $this->redirectToRoute('app_login');  //si le user est deja connecter on le redirige vers la page d'acceuil
       }
           
            $user=$this->getUser()->getId();
            $restaurants= $repo->findByUser($user);
            
            return $this->render('restaurant/index.html.twig', [
                'restaurants' => $restaurants,
            ]);
    
        
       
    }


     /**
     * @Route("/restaurant/create", name="app_create_restaurant", methods={"POST","GET"})
     */
    public function CreateRestaurant(UserRepository $user,Request $request,EntityManagerInterface $em): Response
    {   
         
        $restaurant=new Restaurants;
        $form=$this->createForm(CreateRestaurantType::class,$restaurant);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            // on recupere les images
            $images = $form->get('imagesRestos')->getData();
            //On boucle sur les images recupérées
            foreach($images as $image){
                //On genere un id unique pour les images
               $fichier=md5(uniqid())  . '.' . $image->guessExtension();   

               //On copie l'image recuperer dans le dossier 
               $image->move(
                   $this->getParameter('images_directory'),
                   $fichier
               );

               //On stock l'image dans la base de donnée
               $img=new ImagesResto;
               $img->setName($fichier);
               //cette fonction permettra de set le id du restaurant dans la table image
               $restaurant->addImagesResto($img);
            }



            $restaurant->setProprietaire($this->getUser());
            $restaurant->setActived("0");
            $em->persist($restaurant);
            $em->flush();

            $this->addFlash('success','Votre Restaurant a bien été crée');

        }
        
        return $this->render('restaurant/create.html.twig', [
            'createResto' => $form->createView(),
        ]);
    }

    /**
     * @Route("/restaurant/{id<[0-9]+>}/edit", name="app_edit_restaurant", methods={"POST","GET"})
     */
    public function editRestaurant(Restaurants $restaurant,Request $request,EntityManagerInterface $em): Response
    {   
        
        if ($restaurant->getProprietaire() != $this->getUser()) {
            $this->addFlash('danger','Accès réfusé');
           return $this->redirectToRoute('app_restaurant');
        }
        
        $form=$this->createForm(CreateRestaurantType::class,$restaurant);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 

             $images = $form->get('imagesRestos')->getData();
            //On boucle sur les images recupérées
            foreach($images as $image){
                //On genere un id unique pour les images
               $fichier=md5(uniqid())  . '.' . $image->guessExtension();   

               //On copie l'image recuperer dans le dossier 
               $image->move(
                   $this->getParameter('images_directory'),
                   $fichier
               );

               //On stock l'image dans la base de donnée
               $img=new ImagesResto;
               $img->setName($fichier);
               //cette fonction permettra de set le id du restaurant dans la table image
               $restaurant->addImagesResto($img);
            }

            $restaurant->setProprietaire($this->getUser());
            $em->persist($restaurant);
            $em->flush();

            $this->addFlash('success',' Restaurant mis à jour avec succès');
           return $this->redirectToRoute('app_gestion_restaurant',[
               'id' => $restaurant->getId()
           ]);
        }
        
        return $this->render('restaurant/edit.html.twig', [
            'createResto' => $form->createView(),
            'restaurant' => $restaurant,
            'image' => $restaurant->getImagesRestos()
        ]);
    }

     /**
     * @Route("/restaurant/{id<[0-9]+>}-{slug}/gerer", name="app_gestion_restaurant", methods={"POST","GET"})
     */
    public function gererRestaurant(Restaurants $restaurant,Request $request,EntityManagerInterface $em): Response
    {   
        if ($restaurant->getProprietaire() != $this->getUser()) {
            $this->addFlash('danger','Accès réfusé');
           return $this->redirectToRoute('app_restaurant');
        }
        
        
        return $this->render('restaurant/gestion.html.twig', [
            'restaurant' => $restaurant
        ]);
    }


    
    /**
     * delete
     *
     * @Route("/restaurant/{id}/actived", name="app_actived_restaurant" ,methods={"GET","POST"})  // {id<[0-9]+>} signifie que le id doit etre un nombre
     */
    public function delete(Request $request,Restaurants $restaurant,EntityManagerInterface $em) : Response
    {

        if ($restaurant->getProprietaire() != $this->getUser()) {
            $this->addFlash('danger','Accès réfusé');
           return $this->redirectToRoute('app_restaurant');
        }
       if ($restaurant->getActived()==null) {
         $resto=  $restaurant->setActived("1");
           $em->persist($resto);
           $em->flush();
           $this->addFlash('success','Votre Restaurant a bien été activé');


       }elseif($restaurant->getActived()!==null){
           $resto= $restaurant->setActived("0");
            $em->persist($resto);
            $em->flush();
            $this->addFlash('success','Votre Restaurant a bien été désactivé');

       }


        
        return $this->redirectToRoute('app_gestion_restaurant',[
            'id' => $restaurant->getId()
        ]);   

    }
    
    /**
     * deleteImage
     *
     *@Route("/supprime/image/{id}", name="annonces_delete_image", methods={"DELETE"})
     */
    public function deleteImage(ImagesResto $image,Request $request){
        $data = json_decode($request->getContent(),true);

        if($this->isCsrfTokenValid('delete'.$image->getId(),$data['_token'])){

            $nom = $image->getName();

            unlink($this->getParameter('images_directory').'/'.$nom);

            $em=$this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }else{

            return new JsonResponse(['error' => 'token Invalid'],400);

        }

     
    }
          /**
     * deleteImage
     *
     *@Route("/image/{id}/delete", name="images_delete_image", methods={"DELETE"})
     */
    public function deleteImages(Request $request, ImagesResto $imgresto): Response
    {
        if ($this->isCsrfTokenValid('delete_'.$imgresto->getId(), $request->request->get('csrf_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($imgresto);
            $entityManager->flush();
        }else{

            $this->addFlash('error','une erreur s\' est produite');
        }

        return $this->redirectToRoute('app_restaurant');
    }

    
}

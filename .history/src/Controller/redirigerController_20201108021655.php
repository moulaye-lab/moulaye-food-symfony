 public function rediriger(Restaurants $restaurant)
    {
        if ($restaurant->getProprietaire() != $this->getUser()) {
            $this->addFlash('danger','Accès réfusé');
           return $this->redirectToRoute('app_restaurant');
        }
    }
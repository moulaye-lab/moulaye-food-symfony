/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
 import $ from 'jquery';
 import 'bootstrap';

console.log('Hello Webpack Encore! Edit me in assets/app.js');

window.onload = () => {
        //gestion des liens 'supprimer'

        //on selectionne tout les balises qui on l'attrubut qu'on veux 

        let links= document.querySelectorAll("[data-delete]")

        // On boucle sur les liens 

        for(link of links){


            //on ecoute le clic qui est fait 


            link.addEventListener("clik",function(e){

                //on empeche la navigation

                e.preventDefault()

                //demande de comfirmation de suppression 

                if(confirm("voulez vous supprimer cette image ?")){


                      // On envoie une requet Ajax vers le href du lien avec la methode delete 
                        //on recupere les attribut du href
                      fetch(this.getAttribute("href"),{
                         method: "DELETE",

                         headers : {
                                'X-Requested-with': "XMLHttpRequest",
                                "Content-Type" : "application/json"
                         },

                         body: JSON.stringify({"_token":this.dataset.token})
                      }).then(

                        //A pres le fetch qui est une promesse / maintenant que la promesse est teneu On recupere la reponse en JSON 
                      
                            response => responsejson()                      
                        ).then(data => {
                            if
                        } )
                }


            
            })
        }

}
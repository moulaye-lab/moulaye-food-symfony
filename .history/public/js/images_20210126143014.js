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
                        if(data.success)
                            this.parentElement.remove()

                        else

                            alert(data.error)

                        
                    } ).catch(e => alert(e))
            }
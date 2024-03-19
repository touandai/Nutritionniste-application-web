window.onload =() => {
    let Recettes  = document.querySelectorAll("#recette div");

        for (let Recette of Recettes){
            Recette.addEventListener("click", function(){
               let tag = this.id;
            
               let images = document.querySelectorAll("#galerie img");//aller chercher les images correspondantes
               
               for (let image of images){
                  image.classList.replace("active", "inactive");
                  if (tag in image.dataset || tag ==="tout" ){
                    image.classList.replace("inactive","active");
                  }
               }
            })
        }
}
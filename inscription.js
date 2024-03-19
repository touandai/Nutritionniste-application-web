
let Form = document.getElementById('formulaire');
Form.addEventListener('submit', function(e){
    let pseudo = document.getElementById('pseudo');
    let myRegex = /^[a-zA-Z-\s]+$/;

    if (pseudo.value.trim()="") {
        let monErreur = document.getElementById('erreur');
        monErreur.innerHTML ="Veuillez remplir le champ nom Utilisateur.";
        monErreur.style.color='white';
        e.preventDefault();
    }else if (myRegex.test(pseudo.value) = false){
        let monErreur = document.getElementById('erreur');
        monErreur.innerHTML ="Veullez remplir le champ nom Utilisateur.";
        monErreur.style.color='white';
        e.preventDefault();
    }
console.log(pseudo);
});
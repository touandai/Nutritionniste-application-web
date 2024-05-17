//controle saisie nom //
document.getElementById("nom").addEventListener("input", function (e) {
  let nomformat = /^[a-zA-Z-\s]+$/;

  if (nomformat.test(nom.value) == false) {
    let Erreurnom = document.getElementById("erreurnom");
    Erreurnom.innerHTML = "Le nom doit comporter uniquement des lettres";
    Erreurnom.style.color = "red";
    e.preventDefault();
  } else {
    let Erreurnom = document.getElementById("erreurnom");
    Erreurnom.innerHTML = "Champ valide !";
    Erreurnom.style.color = "green";
  }
});

//controle saisie prenom//

document.getElementById("prenom").addEventListener("input", function (e) {
  let nomformat = /^[a-zA-Z-\s]+$/;

  if (nomformat.test(nom.value) == false) {
    let Erreurnom = document.getElementById("erreurprenom");
    Erreurnom.innerHTML = "Le nom doit comporter uniquement des lettres";
    Erreurnom.style.color = "red";
    e.preventDefault();
  } else {
    let Erreurnom = document.getElementById("erreurprenom");
    Erreurnom.innerHTML = "Champ valide !";
    Erreurnom.style.color = "green";
  }
});

//controle saisie adresse eamail //

document.getElementById("email").addEventListener("input", function (e) {
  let emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,3}$/;

  if (emailRegex.test(email.value) == false) {
    let Erreurmail = document.querySelector("#erreuremail");

    Erreurmail.innerHTML = "Format email invalide !";
    Erreurmail.style.color = "red";
    e.preventDefault();
  } else {
    let Erreurmail = document.querySelector("#erreuremail");
    Erreurmail.innerHTML = "Champ valide !";
    Erreurmail.style.color = "green";
  }
});

//controle saisie mot de passe //
document.getElementById("password").addEventListener("input", function (e) {
  let passRegex = /^[a-zA-Z+[0-9]+[#?!@$%^&*-]+$/;

  if (passRegex.test(password.value) == false) {
    let Erreurpassword = document.querySelector("#erreurpassword");

    Erreurpassword.innerHTML =
      "Invalide!Ce champ doit comporter des lettre, chiffres<br> et au moins un caractère spécial à la fin";
    Erreurpassword.style.color = "red";
    e.preventDefault();
  } else {
    let Erreurpassword = document.querySelector("#erreurpassword");
    Erreurpassword.innerHTML = "Champ valide !";
    Erreurpassword.style.color = "green";
  }
});

let Form = document.getElementById("inscription");

Form.addEventListener("submit", function (e) {
  alert("Je soumets mes informations !");
});

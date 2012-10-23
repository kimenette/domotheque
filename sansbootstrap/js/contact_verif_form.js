//<![CDATA[

//Pour surligner champ incomplet
function surligne(champ, erreur)
{
   if(erreur)
      champ.style.backgroundColor = "#fba";
   else
      champ.style.backgroundColor = "";
}

//Véfifie taille
function verifTaille(champ)
{
   if(champ.value.length < 2 || champ.value.length > 35)
   {
      surligne(champ, true);
      return false;
   }
   else
   {
      surligne(champ, false);
      return true;
   }
}

//Vérie adresse email
function verifEmail(champ)
{
	//définit l'expression régulière d'une adresse email
    var regEmail = new RegExp('^[0-9a-z._-]+@{1}[0-9a-z.-]{2,}[.]{1}[a-z]{2,5}$','i');

   if(!regEmail.test(champ.value))
   {
      surligne(champ, true);
      return false;
   }
   else
   {
      surligne(champ, false);
      return true;
   }
}

//Vérifie champs obligatoires ne sont vides
function valider(form){
	if( (form.elements['societe'].value != "")
	&& (form.elements['nom'].value != "")
	&& (form.elements['prenom'].value != "")
	&& (form.elements['email'].value != "")
	&& (form.elements['objet'].value != "")
	&& (form.elements['message'].value != "") )
	{
		var nomOk = verifTaille(form.elements['nom']);
		var prenomOk = verifTaille(form.elements['prenom']);
		var mailOk = verifEmail(form.elements['email']);
		
		if( nomOk && prenomOk && mailOk)
			return true;
		else 
		{
			alert("Formulaire mal rempli, veuillez vérifier vos saisies s'il vous plait.");
			return false;
		}
	}
	else 
	{
		alert("Formulaire incomplet, veuillez saisir toutes les informations requises s'il vous plait.");
		return false;
	}
}
//]]>
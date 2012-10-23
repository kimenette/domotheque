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
   if(champ.value.length < 4 || champ.value.length > 35)
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

function verifEmail(champ){
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
//]]>
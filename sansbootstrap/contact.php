<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Domothèque - contact</title>
	
	<script type="text/javascript" src="js/contact_verif_form.js"></script>
</head>

<body>
	<form id="contact_form" name="contact_form" method="post" onsubmit="return valider(this)" action="data/contact_email.php">
		<p>
			<label>Nom <span>*</span></label>
			<input id="nom" name="nom" class="element text" maxlength="255" onblur="verifTaille(this)"/>
		</p>
		<p>
			<label>Prénom <span>*</span></label>
			<input id="prenom" name="prenom" maxlength="255" onblur="verifTaille(this)"/>
		</p>
		<p>
			<label for="email">Email <span>*</span></label>
			<input type="text" id="email" name="email" maxlength="255" onblur="verifEmail(this)"/>
		</p>
		<p>
			<label for="objet">Objet</label>
			<input type="text" id="objet" name="objet" maxlength="255"/>
		</p>
		<p>
			<div class="mess">Message <span>*</span></div>
			<textarea id="message" name="message" rows="8" cols="130" ></textarea> 
		</p>
		<p>
			<input type="hidden" name="motif" value="autre"/>
			<input type="submit" name="envoyer" value="Envoyer" />
		</p>
	</form>
</body>

</html> 
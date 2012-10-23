<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Se connecter</title>
		<script text="text/javascript" src="js/inscripVerif.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="container-fluid">
				<div class="row-fluid">
					<div class="span3">
						<legend><h2>Se connecter</h2></legend>
						<form name="connexion" method="post" action="data/connexion.php">
							<label>Pseudo ou adresse email</label>
							<input type="text" name="psemail" placeholder="votre pseudo ou votre adresse email">
							<label>Mot de passe</label>
							<input type="password" name="password" class="input-small" placeholder="Password">
							<button type="submit"  name="connexion" value="se connecter" class="btn btn-primary">Se connecter</button>
						</form>
					</div>
					<div class="span9">
						<legend><h2>S'inscrire</h2></legend>
						<form name="inscription" method="post" action="">
							<label>Pseudo</label>
							<input type="text" name="pseudo" placeholder="votre pseudo" onblur="verifTaille(this)">
							<label>Adresse email</label>
							<input type="text" name="email" placeholder="votre adresse email" onblur="verifEmail(this)">
							<label>Mot de passe</label>
							<input type="password" name="pwd1" class="input-small" placeholder="Password" onblur="verifTaille(this)">
							<label>Retapez votre mot de passe svp</label>
							<input type="password" name="pwd2" class="input-small" placeholder="Password" onblur="verifTaille(this)">
							<button type="submit" class="btn btn-primary">S'inscrire</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
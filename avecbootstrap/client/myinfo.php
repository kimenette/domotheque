<?php
	$sql_info=mysql_query('SELECT cli_password, cli_email FROM client WHERE cli_id="'.$_SESSION['cli_id'].'" ;')or die(mysql_error());
	$_SESSION['info'] = mysql_fetch_assoc($sql_info);
	
	$sql_adresse=mysql_query('SELECT ad_ligne1, ad_ligne2, ville_nom, ville_cp FROM adresse 
	INNER JOIN ville ON adresse.ville_id = ville.ville_id
	WHERE cli_id="'.$_SESSION['cli_id'].'" ;')or die(mysql_error());
	while($row_adresse = mysql_fetch_assoc($sql_adresse))
	{
		$_SESSION['adresse'][] = $row_adresse;
	}
	$_SESSION['adLenght'] = sizeof($_SESSION['adresse']);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title></title>
		<script text="text/javascript" src="js/inscripVerif.js"></script>
	</head>
	<body>
		<h1>Mes informations</h1>
		
		<div id="myInfo">
			<p>
				<label for="pwd">Mot de passe : </label>
				<input id="pwd" type="password" disabled="disabled" value="<?php echo $_SESSION['info']['cli_password'] ?>"></input>
				<i class="icon-pencil"></i>
			</p>
			<p>
				<label for="email">Adresse email : </label>
				<input id="email" type="text" disabled="disabled" value="<?php echo $_SESSION['info']['cli_email'] ?>"></input>
				<i class="icon-pencil"></i>
			</p>
<?php
			for($i=0; $i<$_SESSION['adLenght']; $i++)
			{
				$iconv = $i+1;
				echo'
				<p>
					<label for="adresse'.$iconv.'">Adresse n°'.$iconv.' : </label>
					<input id="adresse'.$iconv.'" type="text" disabled="disabled" value="'.$_SESSION['adresse'][$i]['ad_ligne1'].' '.$_SESSION['adresse'][$i]['ad_ligne2'].' ('.$_SESSION['adresse'][$i]['ville_cp'].' '.$_SESSION['adresse'][$i]['ville_nom'].') "></input>
					<i class="icon-pencil"></i>';
				if($i>=1)
					echo'<i class="icon-remove"></i>
				</p>';
			}
?>	
		</div>
				
	</body>
</html>
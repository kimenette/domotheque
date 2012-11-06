<?php
	require_once("conf/config.php");

	if(isset($_POST['prod_id']))
	{
		$sql_iprod=mysql_query('SELECT prod_libelle, prod_unite, prod_prixTTC, client.cli_id, cli_pseudo
		FROM produit INNER JOIN client ON produit.cli_id=client.cli_id 
		WHERE prod_id="'.$_POST['prod_id'].'" ;')or die(mysql_error());
		
		while($row_iprod=mysql_fetch_assoc($sql_iprod))
		{
			$iprod = $row_iprod;
		}
	}
	else
		header('Location:index.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<a href="index.php">Retour à l'index</a><!--Provisoire-->
		<title>Info objet</title>
		<!--En attendant faire lien-->
		<script text="text/javascript" src="js/inscripVerif.js"></script>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/mycss.css" rel="stylesheet">
		<!--A garder-->
		<script type="text/javascript" src="js/calendrier.js"></script>
		<link rel="stylesheet" media="screen" type="text/css" title="Design" href="css/design.css" />
	</head>
	<body>
		<h2><?php echo $iprod['prod_libelle'].' proposé par '.$iprod['cli_pseudo']; ?>
			<form action="iuser.php" method="post">
				<input type="hidden" name="cli_id" 	value="<?php echo $iprod['cli_id'] ?>"/>
				<input type="submit" value="iuser"/>
			</form>
		</h2>
		<p><strong>Unité : </strong><?php echo $iprod['prod_unite'];?></p>
		<p><strong>Prix TTC : </strong><?php echo $iprod['prod_prixTTC'];?></p>
		
		
		<legend>Quand voulez-vous l'empreinter ?</legend>
		<!-- Tableau obligatoire ! C'est lui qui contiendra le calendrier ! -->
		<table class="ds_box" cellpadding="0" cellspacing="0" id="ds_conclass" style="display: none;">
			<tr>
				<td id="ds_calclass"></td>
			</tr>
		</table>
		
		<form id="objForm" action="#" method="post">
			<p>
				<label for="datedeb">Date de début : </label>
				<input type="text" id="datedeb" onclick="ds_sh(this);" />
			</p>
			<p>
				<label for="datefin">Date de fin : </label>
				<input type="text" id="datefin" onclick="ds_sh(this);" />
			</p>
			<input type="hidden" name="prod_id" 	value="<?php echo $_POST['prod_id']; ?>"/>
			<p><button class="btn btn-large btn-primary" type="button">Envoyer la demande</button></p>
		</form>
		
	</body>
</html>
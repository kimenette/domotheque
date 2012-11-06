<?php
	require_once("conf/config.php");
	require_once("data/fct_calculerrang.php");

	if(isset($_POST['cli_id']))
	{
		$sql_clipseudo = mysql_query('SELECT cli_pseudo FROM client WHERE cli_id="'.$_POST['cli_id'].'" ;')or die(mysql_error());
		$cli_pseudo = mysql_result($sql_clipseudo,0);
		$rang = calculerRang($_POST['cli_id']);
		
		$sql_sesprod=mysql_query('SELECT prod_id, prod_libelle, prod_unite, prod_prixTTC FROM produit WHERE cli_id ="'.$_POST['cli_id'].'" ;')or die(mysql_error());
		while($row_sesprod=mysql_fetch_assoc($sql_sesprod))
		{
			$sesprod[] = $row_sesprod;
		}
		$nbrprod= sizeof($sesprod);
		
		$sql_nbrcom=mysql_query('SELECT COUNT(com_id) FROM commentaire
		INNER JOIN client ON commentaire.cli_idcli = client.cli_id
		WHERE commentaire.cli_id="'.$_POST['cli_id'].'" ;')or die(mysql_error());
		$nbrcom = mysql_result($sql_nbrcom,0);
		if($nbrcom>0)
		{
			$sql_sescom=mysql_query('SELECT com_contenu, cli_pseudo FROM commentaire
			INNER JOIN client ON commentaire.cli_idcli = client.cli_id
			WHERE commentaire.cli_id="'.$_POST['cli_id'].'" ;')or die(mysql_error());
			while($row_sescom = mysql_fetch_array($sql_sescom))
			{
				$sescom[]	= $row_sescom;
			}
		}
		else
			$nbrcom=0;
	}
	else
		header('Location:index.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Info objet</title>
		<!--En attendant faire lien-->
		<script text="text/javascript" src="js/inscripVerif.js"></script>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/mycss.css" rel="stylesheet">
		<!--A garder-->

	</head>
	<body>
		<a href="index.php">Retour à l'index</a><!--Provisoire-->
		<title>Info Utilisateur</title>
		<h2><?php echo $cli_pseudo.' : '.$rang.'/5' ; ?></h2>
		
		<button class="btn btn-large btn-primary" type="button">Laisser un commentaire</button>
		
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span6">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Nom</th>
								<th>Unité</th>
								<th>Prix</th>
							</tr>
						</thead>
						<tbody>
<?php
							for($i=0; $i<$nbrprod; $i++)
							{
								echo'
								<tr>
									<td>'.$sesprod[$i]['prod_libelle'].'
										<form action="iobjet.php" method="post">
											<input type="hidden" name="prod_id" 	value="'.$sesprod[$i]['prod_id'].'"/>
											<input type="submit" value="+ détails"/>
										</form>
									</td>
									<td>'.$sesprod[$i]['prod_unite'].'</td>
									<td>'.$sesprod[$i]['prod_prixTTC'].'</td>
								</tr>';
							}
?>									
						</tbody>
					</table>
				</div>
			
				<div class="span6">
<?php
					if($nbrcom==0)
						echo 'La personne n\'a pas été encore évaluée';
					else
					{
						for($i=0; $i<$nbrcom; $i++)
						{
							echo'
							<div class="bloc_com">
								<h5>'.$sescom[$i]['cli_pseudo'].' : </h5> 
								<p>'.$sescom[$i]['com_contenu'].'</p>
							</div>';
						}
					}
?>
				</div>
			</div>
		</div>
	</body>
</html>
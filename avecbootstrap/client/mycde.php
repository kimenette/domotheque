<?php
	$rang = calculerRang($_SESSION['cli_id']);
	
	if(isset($_SESSION['cde_liste']))
		unset($_SESSION['cde_liste']);
		
	unset($_SESSION['cdeLength']);
	
	$sql_nbrcde=mysql_query('SELECT COUNT(cde_id) FROM commande WHERE cli_id="'.$_SESSION['cli_id'].'" ;')or die(mysql_error());
	$nbrcde=mysql_result($sql_nbrcde,0);
	if($nbrcde>0)
	{
		$sql_cde=mysql_query('SELECT commande.cde_id, cde_datedeb, cde_datefin, cde_acceptee, produit.prod_id, prod_libelle, prod_prixTTC
		FROM commande 
		INNER JOIN cdeprod ON commande.cde_id = cdeprod.cde_id
		INNER JOIN produit ON cdeprod.prod_id = produit.prod_id
		WHERE commande.cli_id="'.$_SESSION['cli_id'].'" ;')or die(mysql_error());

		while($row_cde= mysql_fetch_assoc($sql_cde))
		{
			$_SESSION['cde_liste'][] = $row_cde;
		}
		$_SESSION['cdeLength'] = sizeof($_SESSION['cde_liste']);
		
		for($i=0; $i<$_SESSION['cdeLength']; $i++)
		{
			$sql_proprio=mysql_query('SELECT client.cli_id AS proprio_id, cli_pseudo  AS proprio_pseudo
			FROM produit 
			INNER JOIN client ON produit.cli_id = client.cli_id
			WHERE prod_id="'.$_SESSION['cde_liste'][$i]['cde_id'].'"')or die(mysql_error());

			while($row_proprio = mysql_fetch_assoc($sql_proprio))
			{
				$_SESSION['cde_liste'][$i]['proprio_id'] = $row_proprio['proprio_id'];
				$_SESSION['cde_liste'][$i]['proprio_pseudo'] = $row_proprio['proprio_pseudo'];
			}
		}
	}
	else
		$_SESSION['cdeLength']=0;
		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title></title>
		<script text="text/javascript" src="js/inscripVerif.js"></script>
	</head>
	<body>
		<h1><?php echo $_SESSION['cli_pseudo'].' : '.$rang.'/5'?></h1>
		
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Annuler</th>
					<th>Objet</th>
					<th>Montant</th>
					<th>Prêteur</th>
					<th>Date début</th>
					<th>Date fin</th>
					<th>Accepté</th>
				</tr>
			</thead>
			<tbody>
<?php
			if($_SESSION['cdeLength']>0)
			{
				for($i=0; $i<$_SESSION['cdeLength']; $i++)
				{
					echo'<tr>
						<td><i class="icon-remove"></td>
						<td>'.$_SESSION['cde_liste'][$i]['prod_libelle'].'</td>
						<td>'.$_SESSION['cde_liste'][$i]['prod_prixTTC'].'</td>
						<td>'.$_SESSION['cde_liste'][$i]['proprio_pseudo'].'</td>
						<td>'.$_SESSION['cde_liste'][$i]['cde_datedeb'].'</td>
						<td>'.$_SESSION['cde_liste'][$i]['cde_datefin'].'</td>';
						if($_SESSION['cde_liste'][$i]['cde_acceptee'])
							echo '<td><i class="icon-ok"></i></td>';
						else
							echo '<td><i class="icon-time"></i></td>';
					echo'</tr>';
				}
			}
			else
				echo'<td colspan="7">Aucune commande pour le moment</td>';
?>									
			</tbody>
		</table>
		
	</body>
</html>
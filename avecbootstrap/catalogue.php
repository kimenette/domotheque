<?php
	/*==============================================================*/
	/*Compte tous les produits
	* Si existe $_SESSION['catalLength'] et existe $_SESSION['catalogue'] Alors
	*	Vérifie si doit faire un mise à j de la session grâce taille $_SESSION['catalLength']
	* Sinon (n'existe $_SESSION['catalLength']) Alors créer $_SESSION['catalogue'][]
	/*==============================================================*/
	if(isset($_SESSION['catalLength']) && isset($_SESSION['catalogue']))
	{
		$sql_catalLenghtBdD=mysql_query("SELECT COUNT(prod_id) FROM produit ;")or die(mysql_error());
		$catalLengthBdD = mysql_result($sql_catalLenghtBdD,0);
		
		if($catalLengthBdD > $_SESSION['catalLength'])
		{
			getCatalogue("prod_id");
		}
	}
	else
	{
		getCatalogue("prod_id");
	}
	
	/*==============================================================*/
	/*Compte tous les partenaires
	* Si existe $_SESSION['partLength'] et existe $_SESSION['partenaires'] Alors
	*	Vérifie si doit faire un mise à j de la session grâce taille $_SESSION['partLength']
	* Sinon (n'existe $_SESSION['partLength']) Alors créer $_SESSION['partenaires'][]
	/*==============================================================*/
	if(isset($_SESSION['partLength']) && isset($_SESSION['partenaires']))
	{
		$sql_partLenghtBdD=mysql_query("SELECT COUNT(part_id) FROM partenaire ;")or die(mysql_error());
		$partLengthBdD = mysql_result($sql_partLenghtBdD,0);
		
		if($partLengthBdD > $_SESSION['partLength'])
		{
			getPartenaires();
		}
	}
	else
	{
		getPartenaires();
	}
	
	/*==============================================================*/
	/* Participant le mieux noté
	/*==============================================================*/
	$sql_userBestRanked = mysql_query("
	SELECT SUM(rang_nbr)/COUNT(rang_id) AS ranked, rang.cli_id , cli_pseudo FROM rang
	INNER JOIN client ON rang.cli_id = client.cli_id
	GROUP BY rang.cli_id
	HAVING ranked>=ALL(
		SELECT SUM(rang_nbr)/COUNT(rang_id) FROM rang
		INNER JOIN client ON rang.cli_id = client.cli_id
		GROUP BY rang.cli_id);")or die(mysql_error());
	$userBestRanked = mysql_fetch_assoc($sql_userBestRanked);
	
	/*==============================================================*/
	/* Participant le plus préteur -> chez qui on a emprunté le plus -> nbr commande
	/*==============================================================*/
	$sql_userShareMost = mysql_query("
	SELECT COUNT(cde_id) AS nbrCde, client.cli_id, cli_pseudo FROM client
	INNER JOIN commande ON client.cli_id = commande.cli_id
	WHERE cde_acceptee=1 
	GROUP BY client.cli_id
	HAVING nbrCde >=ALL(
		SELECT COUNT(cde_id) FROM commande
		WHERE cde_acceptee=1 GROUP BY cli_id);")or die(mysql_error());
	$userShareMost = mysql_fetch_assoc($sql_userShareMost);
	
	/*==============================================================*/
	/* Le plus populaire : objet emprunté -> produit le plus commandé sans tenir compte quantité
	/*==============================================================*/
	$sql_prodMostPop = mysql_query("
	SELECT COUNT(commande.cde_id) AS nbrCde, produit.prod_id, produit.prod_libelle FROM produit
	INNER JOIN cdeprod ON produit.prod_id = cdeprod.prod_id
	INNER JOIN commande ON cdeprod.cde_id = commande.cde_id
	WHERE cde_acceptee=1
	GROUP BY prod_id
	HAVING nbrCde >=ALL( SELECT COUNT(commande.cde_id) FROM commande
		INNER JOIN cdeprod ON commande.cde_id = cdeprod.cde_id
		GROUP BY prod_id);") or die(mysql_error());
	$prodMostPop = mysql_fetch_assoc($sql_prodMostPop);
	
	/*==============================================================*/
	/* Fonctions php
	/*==============================================================*/
	function getCatalogue($p_order){
		$sql_catal=mysql_query("SELECT prod_id, prod_libelle, prod_prixTTC, prod_dateaj, cat_libelle FROM produit 
		INNER JOIN categorie ON produit.cat_id = categorie.cat_id
		ORDER BY ".$p_order." ;")or die(mysql_error());
		while($row_catal = mysql_fetch_assoc($sql_catal))
		{
			$_SESSION['catalogue'][] = $row_catal;
		}
		$_SESSION['catalLength'] = sizeof($_SESSION['catalogue']);
	}
	
	function getPartenaires(){
		$sql_partenaires=mysql_query("SELECT part_id,part_raisoc FROM partenaire ORDER BY part_raisoc;")or die(mysql_error());
		while($row_partenaires = mysql_fetch_assoc($sql_partenaires))
		{
			$_SESSION['partenaires'][] = $row_partenaires;
		}
		$_SESSION['partLength'] = sizeof($_SESSION['partenaires']);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Catalogue</title>
	</head>
	<body>
		<div class="container">
		<legend><h1>Catalogue</h1></legend>
			<div class="container-fluid">
				<div class="row-fluid">
					<div class="span1">
						<h3>Ordre</h3>
						<select>
<?php
							for($i=0; $i<$_SESSION['categLenght']; $i++)
							{
								echo'<option value="categ'.$_SESSION["categories"][$i]["cat_id"].'">'.$_SESSION['categories'][$i]["cat_libelle"].'</option> ';
							}
?>
						</select>
						<h3>Catégorie</h3>
							<div class="control-group">
								<div class="controls">
<?php
								for($i=0; $i<$_SESSION['categLenght']; $i++)
								{
									echo'<label class="checkbox">
										<input type="checkbox" id="inlineCheckbox'.$_SESSION['categories'][$i]['cat_id'].'" value=categ'.$_SESSION['categories'][$i]['cat_id'].'"> '.$_SESSION['categories'][$i]['cat_libelle'].'</input>
									</label>';
								}
?>
								</div>
							</div>
					</div>
					<div class="span9 offset2">
						<div class="span8">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>Nom</th>
										<th>Catégorie</th>
										<th>Prix</th>
									</tr>
								</thead>
								<tbody>
<?php
									for($i=0; $i<$_SESSION['catalLength']; $i++)
									{
										echo'
										<tr>
											<td>'.$_SESSION['catalogue'][$i]['prod_libelle'].'</td>
											<td>'.$_SESSION['catalogue'][$i]['cat_libelle'].'</td>
											<td>'.$_SESSION['catalogue'][$i]['prod_prixTTC'].'</td>
										</tr>';
									}
?>									
								</tbody>
							</table>
						</div>
						<div class="span1">
							<h4>Participant(e) le/la mieux noté(e)</h4> <?php echo $userBestRanked['cli_pseudo']." : ".$userBestRanked['ranked']."/5" ; ?>
							<h4>Le(/La) plus préteur(/euse)</h4> <?php echo $userShareMost['cli_pseudo'] ;?>
							<h4>Produit phare</h4> <?php echo $prodMostPop['prod_libelle'];?>
							<h4>Liste des partenaires</h4>
<?php
							for($i=0; $i<$_SESSION['partLength']; $i++)
							{
								echo'<ul>
									<li>'.$_SESSION['partenaires'][$i]['part_raisoc'].'</li>
								</ul>';
							}
?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
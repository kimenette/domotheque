<?php
	//Affichage du catalogue en fonction des catégories et de l'ordre demandé
	if(isset($_GET["catalOrdre"]))
		$catalOrdre = $_GET["catalOrdre"];
	else
		$catalOrdre = 'precent';
		
	switch($catalOrdre)
	{
		case 'precent':
			$sqlOrdre = 'ORDER BY prod_datemis DESC, prod_libelle';
			break;
		case 'mrecent':
			$sqlOrdre = 'ORDER BY prod_datemis ASC, prod_libelle';
			break;
		case 'alpha':
			$sqlOrdre = 'ORDER BY prod_libelle ASC';
			break;
		case 'nalpha':
			$sqlOrdre = 'ORDER BY prod_libelle DESC';
			break;
		case 'prixC':
			$sqlOrdre = 'ORDER BY prod_prixTTC ASC';
			break;
		case 'prixD':
			$sqlOrdre = 'ORDER BY prod_prixTTC DESC';
			break;
	}
	
	if(isset($_GET["categ"]))
	{
		$sql_catal=mysql_query("SELECT prod_id, prod_libelle, prod_prixTTC, cat_libelle FROM produit
		INNER JOIN categorie ON produit.prod_idcat = categorie.cat_id
		WHERE cat_id=".$_GET["categ"]." ".$sqlOrdre.";")or die(mysql_error());
	}
	else
	{
		$sql_catal=mysql_query("SELECT prod_id, prod_libelle, prod_prixTTC, cat_libelle FROM produit
		INNER JOIN categorie ON produit.prod_idcat = categorie.cat_id
		".$sqlOrdre.";")or die(mysql_error());
	}
	while($row_catal = mysql_fetch_assoc($sql_catal))
	{
		$catalogue[] = $row_catal;
	}
	$catalogueLenght = sizeof($catalogue);
	
	//Obtenir l'objet le plus populaire
	$sql_mostPopular=mysql_query("SELECT prod_id, prod_libelle, SUM(cdeprod_qte) AS qte FROM produit
	INNER JOIN cdeprod ON produit.prod_id = cdeprod.cdeprod_idprod GROUP BY prod_id
	HAVING qte >=ALL(SELECT SUM(cdeprod_qte) AS qte FROM cdeprod GROUP BY cdeprod_idprod ORDER BY qte DESC)
	")or die(mysqlerror());
	$mostPopular = mysql_fetch_assoc($sql_mostPopular);
	
	//Obtenir les partenaires
	$sql_partenaires=mysql_query("SELECT part_id, part_raisoc, part_url FROM partenaire ORDER BY part_raisoc")or die(mysql_error());
	while($row_part = mysql_fetch_assoc($sql_partenaires))
	{
		$partenaires[] = $row_part;
	}
	$partLenght = sizeof($partenaires);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Catalogue</title>
	
	<script type="text/javascript">
		<!--fonction $_GET[] en js-->
		function getQuerystring(key, default_){
		  if (default_==null) default_="";
			key = key.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
			
		  var regex = new RegExp("[\\?&]"+key+"=([^&#]*)");
		  var qs = regex.exec(window.location.href);
		  
		  if(qs == null)
			return default_;
		  else
			return qs[1];
		}
	
		<!--Ordonner le catalogue-->
		function OrdonnerCatal(){		
			var cible=document.getElementById("catalOrdre");
			var categ_value = getQuerystring('categ');
			window.location.href="?p=catalogue&t=Catalogue&catalOrdre="+cible.value+"&categ="+categ_value;
		}
	</script>
</head>

<body>
	<nav id="catalNav">
		<h2>Ordre</h2>
		<select id="catalOrdre" onchange="OrdonnerCatal();">
			<option value="precent"	<?php if($catalOrdre=='precent') echo " selected='selected'"; ?>	>Plus récent			</option>
			<option value="mrecent"	<?php if($catalOrdre=='mrecent') echo " selected='selected'"; ?>	>Plus ancien			</option>
			<option value="alpha"	<?php if($catalOrdre=='alpha') echo " selected='selected'"; ?>		>Alphabétique			</option>
			<option value="nalpha"	<?php if($catalOrdre=='nalpha') echo " selected='selected'"; ?>		>Inverse alphabéthique	</option>
			<option value="prixC"	<?php if($catalOrdre=='prixC') echo " selected='selected'"; ?>		>Prix croissant			</option>
			<option value="prixD"	<?php if($catalOrdre=='prixD') echo " selected='selected'"; ?>		>prix décroissant		</option>
		</select>
		<h2>Catégories</h2>
		<div id="catalCateg">
<?php
			for($i=0; $i<$categLenght; $i++)
			{
				echo'
					<p>
						<a href="index.php?p=catalogue&t=Catalogue&catalOrdre='.$catalOrdre.'&categ='.$categories[$i]["cat_id"].'">'.$categories[$i]["cat_libelle"].'</a>
					</p>
				';
			}
?>
		</div>
		
	</nav>
	
	<section id="catalSection">
		<table>
			<thead>
				<tr>
					<th>Nom</th>
					<th>Catégorie</th>
					<th>Prix</th>
				</tr>
			</thead>
				<tbody>
<?php
			for($i=0; $i<$catalogueLenght; $i++)
			{
				echo'
					<tr>
						<td>'.$catalogue[$i]['prod_libelle'].'</td>
						<td>'.$catalogue[$i]['cat_libelle'].'</td>
						<td>'.$catalogue[$i]['prod_prixTTC'].' €</td>
					</tr>
				';
			}
?>
			</tbody>
		</table>
	</section>
	
	<aside id="pop">
		<h2>Le plus populaire</h2>
<?php		echo $mostPopular['prod_libelle'];?>
	</aside>
	
	<aside id="part">
		<h2>Liste des partenaires</h2>
<?php		for($i=0; $i<$partLenght; $i++)
			{
				echo'
					<p><a href="'.$partenaires[$i]['part_url'].'">'.$partenaires[$i]['part_raisoc'].'</a></p>
				';
			}
?>
	</aside>

</body>

</html> 
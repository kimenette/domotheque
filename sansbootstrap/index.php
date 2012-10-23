<?php
	require_once("conf/config.php");
	require_once("conf/plan.php");
	require_once("data/contenu.php");
	
	//Obtenir les catalogues
	$sql_categ=mysql_query("SELECT cat_libelle, cat_id FROM categorie ORDER BY cat_libelle")or die(mysql_error());
	while($row_categ = mysql_fetch_assoc($sql_categ))
	{
		$categories[] = $row_categ;
	}
	$categLenght = sizeof($categories);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Domothèque</title>
	
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body>
	<header>
		
		<div id="titleIndex">
			<h1>Domothèque</h1>
		</div>
		
		<div id="indexSearch">
			<form action="index.php" method="post">
				<select>
					<option value="catDef">Catégorie</option>
<?php
			for($i=0; $i<$categLenght; $i++)
			{
				echo'
					<option value="cat'.$categories[$i]['cat_id'].'">'.$categories[$i]['cat_libelle'].'</option>
				';
			}
?>
				</select>
				<input id="txtSearchIndex" name="txtSearchIndex" type="text" value="mots clés" onclick="this.value='';">
				<input id="btnSearchIndex" name="btnSearchIndex" type="submit" value="Rechercher">
				<a href="">avancée</a>
			</form>
		</div>
		
		<nav id="navIndex">
			<ul>
<?php		
				foreach($plansite as $titre => $lien)
				{
					if($lien[1]=='menu')
					{
						echo'
						<li>
							<a href="index.php?p='.$lien[0].'&amp;t='.$titre.'">'.$titre.'</a>
						</li>';
					}
				}
?>
			</ul>
		</nav>
	</header>
	
	<div id="contenu">
		<?php require_once($plansite[$indice_titre][0].".php"); ?>
	</div>

</body>

</html> 
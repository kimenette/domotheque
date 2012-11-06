<?php
	$rang = calculerRang($_SESSION['cli_id']);
	getProduits();
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
	
		<button class="btn btn-large btn-primary" type="button">Ajouter</button>

		<table class="table table-hover">
			<thead>
				<tr>
					<th>Modifier</th>
					<th>Nom</th>
					<th>Catégorie</th>
					<th>Prix</th>
					<th>Supprimer</th>
				</tr>
			</thead>
			<tbody>
<?php
			if($_SESSION['prodLength']>0)
			{
				for($i=0; $i<$_SESSION['prodLength']; $i++)
				{
					echo'
					<tr>
						<td><i class="icon-pencil"></i></td>
						<td>'.$_SESSION['prod_liste'][$i]['prod_libelle'].'</td>
						<td>'.$_SESSION['prod_liste'][$i]['cat_libelle'].'</td>
						<td>'.$_SESSION['prod_liste'][$i]['prod_prixTTC'].'</td>
						<td><i class="icon-remove"></i></td>
					</tr>';
				}
			}
			else
				echo'<td colspan="5">Aucun objet pour le moment<td>';
?>									
			</tbody>
		</table>
							
	</body>
</html>
<?php
	function getProduits(){
		unset($_SESSION['prodLength']);
		unset($_SESSION['prod_liste']);
	
		$sql_nbrprod=mysql_query('SELECT COUNT(prod_id) FROM produit WHERE produit.cli_id="'.$_SESSION['cli_id'].'" ;')or die(mysql_error());
		$nbrprod=mysql_result($sql_nbrprod,0);
		if($sql_nbrprod>0)
		{
			for($i=0; $i< sizeof($_SESSION['prod_id']); $i++)
			{
				$sql_prod=mysql_query('SELECT prod_id, prod_libelle, prod_prixTTC, cat_libelle 
				FROM produit INNER JOIN categorie ON produit.cat_id=categorie.cat_id
				WHERE prod_id="'.$_SESSION['prod_id'][$i].'" ;')or die(mysql_error());
			
				while($row_prod= mysql_fetch_assoc($sql_prod))
				{
					$_SESSION['prod_liste'][] = $row_prod;
				}
			}
			$_SESSION['prodLength'] = sizeof($_SESSION['prod_liste']);
		}
		else
				$_SESSION['prodLength'] = 0;
	}
?>
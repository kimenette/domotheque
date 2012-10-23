<?php
require_once "../conf/config.php";

if(isset($_POST['connexion']) && $_POST['connexion']=='se connecter')
{
	if(isset($_POST['psemail']) && isset($_POST['password']))
	{
		$_POST['psemail']=htmlspecialchars($_POST['psemail'], ENT_QUOTES);
		$_POST['psemail']=mysql_escape_string($_POST['psemail']);
		$_POST['password']=htmlspecialchars($_POST['password'], ENT_QUOTES);
		$_POST['password']=mysql_escape_string($_POST['password']);
		
		//Teste si une entrée de la base contient ce couple psemail / password
		$sql=mysql_query('SELECT count(cli_id) FROM client WHERE (cli_pseudo="'.$_POST['psemail'].'" OR cli_email="'.$_POST['psemail'].'") AND cli_password="'.$_POST['password'].'" ;') or die(mysql_error());
		$data=mysql_result($sql,0); 
		mysql_free_result($sql);
		
		// Si obtient une réponse, alors crée variables de session
		if ($data[0] == 1) 
		{		
			session_start();
			//infos client
			$sql_session = mysql_query('SELECT cli_id, cli_email, cli_pseudo, cli_password FROM client WHERE cli_pseudo="'.$_POST['psemail'].'" OR cli_email="'.$_POST['psemail'].'" ;')or die(mysql_error());
			$data_session = mysql_fetch_array($sql_session);
			
			$_SESSION['cli_id'] = $data_session['cli_id'];
			$_SESSION['cli_email'] = $data_session['cli_email'];
			$_SESSION['cli_password'] = $data_session['cli_password'];
			$_SESSION['cli_pseudo'] = $data_session['cli_pseudo'];
			
			//id des produits associés au client
			$sql_prod = mysql_query('SELECT prod_id FROM client INNER JOIN produit ON client.cli_id = produit.cli_id')or die(mysql_error());
			while($row_prod =  mysql_fetch_array($sql_prod))
			{
				$_SESSION['prod_id'][] = $row_prod['prod_id'];
			}
			
			//id des commandes associés au client
			$sql_cde = mysql_query('SELECT cde_id FROM client INNER JOIN commande ON client.cli_id = commande.cli_id')or die(mysql_error());
			while($row_cde =  mysql_fetch_array($sql_cde))
			{
				$_SESSION['cde_id'][] = $row_cde['cde_id'];
			}
			header('Location:../client/index.php');
		}
		else
			header('Location:../index.php');
	}
}
else
{
	header('Location:../index.php');
}

?>
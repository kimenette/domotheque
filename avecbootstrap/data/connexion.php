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
			$sql_nbrprod=mysql_query('SELECT COUNT(prod_id) FROM produit WHERE produit.cli_id="'.$_SESSION['cli_id'].'" ;')or die(mysql_error());
			$nbrprod=mysql_result($sql_nbrprod,0);
			if($sql_nbrprod>0)
			{
				$sql_prod = mysql_query('SELECT prod_id FROM produit WHERE cli_id="'.$_SESSION['cli_id'].'" ;')or die(mysql_error());
				while($row_prod =  mysql_fetch_array($sql_prod))
				{
					$_SESSION['prod_id'][] = $row_prod['prod_id'];
				}
				$_SESSION['prodLength'] = sizeof($_SESSION['prod_id']);
			}
			else
				$_SESSION['prodLength'] = 0;
			
			//id des commandes associés au client
			$sql_nbrcde=mysql_query('SELECT COUNT(cde_id) FROM commande WHERE cli_id="'.$_SESSION['cli_id'].'" ;')or die(mysql_error());
			$nbrcde=mysql_result($sql_nbrcde,0);
			if($nbrcde>0)
			{
				$sql_cde = mysql_query('SELECT cde_id FROM commande WHERE cli_id ="'.$_SESSION['cli_id'].'" ;')or die(mysql_error());
				while($row_cde =  mysql_fetch_array($sql_cde))
				{
					$_SESSION['cde_id'][] = $row_cde['cde_id'];
				}
				$_SESSION['cdeLength'] = sizeof($_SESSION['cde_id']);
			}
			else 
				$_SESSION['cdeLength']=0;
			
			header('Location:../index.php');
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
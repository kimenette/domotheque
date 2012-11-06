<?php
	if(isset($_SESSION['com_liste']) && isset($_SESSION['comLenght']))
	{
		unset($_SESSION['com_liste']);
		unset($_SESSION['comLenght']);
	}

	$sql_nbrcom=mysql_query('SELECT COUNT(com_id) FROM commentaire WHERE cli_id="'.$_SESSION['cli_id'].'" ;')or die(mysql_error());
	$nbrcom=mysql_result($sql_nbrcom,0);
	if($nbrcom>0)
	{
		$sql_coms=mysql_query('SELECT com_contenu, cli_pseudo FROM commentaire
		INNER JOIN client ON commentaire.cli_idcli = client.cli_id
		WHERE commentaire.cli_id="'.$_SESSION['cli_id'].'" ;')or die(mysql_error());
		
		while($row_com = mysql_fetch_array($sql_coms))
		{
			$_SESSION['com_liste'][] = $row_com;
		}
		$_SESSION['comLenght'] = sizeof($_SESSION['com_liste']);
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title></title>
		<script text="text/javascript" src="js/inscripVerif.js"></script>
	</head>
	<body>
		<h1>Les commentaires</h1>
<?php
		if($nbrcom==0)
			echo 'Vous n\'avez pas encore été évalué(e)';
		else
		{
			for($i=0; $i<$_SESSION['comLenght']; $i++)
			{
				echo'
				<div class="bloc_com">
					<h5>'.$_SESSION['com_liste'][$i]['cli_pseudo'].' : </h5> 
					<p>'.$_SESSION['com_liste'][$i]['com_contenu'].'</p>
				</div>';
			}
		}
?>
		
	</body>
</html>
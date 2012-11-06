<?php
	function calculerRang($p_user){
		$sql_nbrang=mysql_query('SELECT COUNT(rang_id) FROM client INNER JOIN rang ON client.cli_id=rang.cli_id WHERE client.cli_id="'.$p_user.'" ;')or die(mysql_error());
		$nbrang=mysql_result($sql_nbrang,0);
		if($nbrang==0)
			$rang = 0;
		else
		{
			$sql_rang=mysql_query('SELECT SUM(rang_nbr) FROM client INNER JOIN rang ON client.cli_id=rang.cli_id WHERE client.cli_id="'.$p_user.'" ;')or die(mysql_error());
			$rang=mysql_result($sql_rang,0);
			return $rang = $rang/$nbrang;
		}
	}
?>
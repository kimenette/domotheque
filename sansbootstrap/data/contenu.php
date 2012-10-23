<?php
if(isset($_REQUEST["p"]) && isset($_REQUEST["t"]))
	{
		$indice_titre=$_REQUEST["t"];
		$indice_page=$_REQUEST["p"];
	}
	else
	{
		$indice_titre='Catalogue';
		$indice_page='accueil';
	}
?>
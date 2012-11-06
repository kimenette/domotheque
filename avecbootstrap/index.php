<?php
	session_start();

	require_once("conf/config.php");
	require_once("conf/plan.php");
	
	/*==============================================================*/
	/*Obtenir les catégories
	* Choix session : catégories ne changent pas au fil du temps
	* Non modifiable pas les clients, que par admin
	/*==============================================================*/
	if(!isset($_SESSION['categories']) && !isset($_SESSION['categLenght']))
	{
		$sql_categ=mysql_query("select cat_libelle, cat_id FROM categorie ORDER BY cat_libelle ;")or die(mysql_error());
		while($row_categ = mysql_fetch_assoc($sql_categ))
		{
			$_SESSION['categories'][] = $row_categ;
		}
		$_SESSION['categLenght'] = sizeof($_SESSION['categories']);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Domothèque</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/mycss.css" rel="stylesheet">
	</head>
	<body>
		<div class="navbar">
			<div class="navbar-inner">
				<div id="brand" class="brand">Domothèque</div>
				<ul id="myTab"  class="nav">
<?php				foreach($plansite as $titre => $lien)
					{
						if($lien[1]=='menu')
						{
							if($lien[2]=='catalogue')
								echo'<li class="active"><a href="#'.$lien[2].'" data-toggle="tab">'.$titre.'</a></li>';
							else
							{
								if($lien[2]!='seconnecter' && $lien[2]!='monespace')
									echo'<li><a href="#'.$lien[2].'" data-toggle="tab">'.$titre.'</a></li>';
								else
								{
									if(isset($_SESSION['cli_id']) && $lien[2]=='monespace')	
										echo'<li><a href="#'.$lien[2].'" data-toggle="tab">'.$titre.'</a></li>';
									else
									{
										if(!isset($_SESSION['cli_id']) && $lien[2]=='seconnecter')	
											echo'<li><a href="#'.$lien[2].'" data-toggle="tab">'.$titre.'</a></li>';
									}
								}
							}
						}
					}
?>
				</ul>
				<form class="form-search">
					<div class="navbar-search pull-left">
						<div class="input-append">
							<select>
								<option value="cat">Choisir une catégorie</option>
<?php
								for($i=0; $i<$_SESSION['categLenght']; $i++)
								{
									echo'<option value="categ'.$_SESSION["categories"][$i]["cat_id"].'">'.$_SESSION['categories'][$i]["cat_libelle"].'</option> ';
								}
?>
							</select>
					
					
							<input type="text" class="search-query span2" placeholder="Search">
							<button type="submit" class="btn">Search</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		
		<div class="tab-content">
<?php		foreach($plansite as $titre => $lien)
			{
				if($lien[1]=='menu')
				{
					if($lien[2]=='catalogue')
					{
?>
						<div class="tab-pane fade in active" id="<?php echo $lien[2];?>"><?php require_once($lien[0].".php");?></div>
<?php
					}
					else
					{
?>
						<div class="tab-pane fade" id="<?php echo $lien[2];?>"><?php require_once($lien[0].".php")?></div>
<?php
					}
				}
			}
?>
		</div>
		
		
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<!--Pour travailler en local en cas que le réseau ne soit pas accessible
		<script text="text/javascript" src="js/latestjquery.js"
		-->
		<script src="js/bootstrap.min.js"></script>
		<script>
			    $('#myTab a').click(function (e) {
				e.preventDefault();
				$(this).tab('show');
				})
		</script>
<?php
	session_unset();
?>
	</body>
</html>
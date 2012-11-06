<?php
	require_once("data/fct_calculerrang.php");
	require_once("data/fct_listeproduits.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Index du client</title>
		<script text="text/javascript" src="js/inscripVerif.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="tabbable tabs-left">
				<ul class="nav nav-tabs">
<?php				foreach($plansite as $titre => $lien)
					{
						if($lien[1]=='client')
						{
							if($lien[2]=='mesobjets')
								echo'<li class="active"><a href="#'.$lien[2].'" data-toggle="tab">'.$titre.'</a></li>';
							else
								echo'<li><a href="#'.$lien[2].'" data-toggle="tab">'.$titre.'</a></li>';
						}
					}
?>
				</ul>
				<div class="tab-content">
<?php			foreach($plansite as $titre => $lien)
				{
					if($lien[1]=='client')
					{
						if($lien[2]=='mesobjets')
						{
?>
							<div class="tab-pane active" id="<?php echo $lien[2];?>"><?php require_once($lien[0].".php");?></div>
<?php
						}
						else
						{
?>
							<div class="tab-pane" id="<?php echo $lien[2];?>"><?php require_once($lien[0].".php");?></div>
<?php
						}
					}
				}
?>
				</div>
			</div> <!-- /tabbable -->
		</div>
	</body>
</html>
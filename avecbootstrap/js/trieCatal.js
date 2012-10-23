//fonction $_GET[] en js
function getQuerystring(key, default_){
  if (default_==null) default_="";
	key = key.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	
  var regex = new RegExp("[\\?&]"+key+"=([^&#]*)");
  var qs = regex.exec(window.location.href);
  
  if(qs == null)
	return default_;
  else
	return qs[1];
}

//Ordonner le catalogue
function OrdonnerCatal(){
	var cible=document.getElementById("ordreCatal")
	
	var categ_value;
	if(getQuerystring('categ'))
		categ_value = getQuerystring('categ');
	else
		categ_value = 'all'
		
	window.location.href="?categ="+categ_value+"&ordre="+cible.value;
}

//Trier le catalogue
function TrierCatal(){		
	var cible=document.getElementById("categCatal");
	
	var ordre_value;
	if(getQuerystring('ordre'))
		ordre_value = getQuerystring('ordre');
	else 
		ordre_value = 'precent';
		
	window.location.href="?categ="+cible.value+"&ordre="+ordre_value;
}
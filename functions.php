<?php
function html($string){
	return utf8_encode(htmlspecialchars($string, ENT_QUOTES));
}

function url_format($string){
	$string = str_replace(' ', '-', strtolower($string));
	return html(preg_replace('#[^a-z0-9-]#', '', $string));
}
function sgbd($string){
	return utf8_decode($string);//mysql_real_escape_string(
}
function generic_autoload($class){
	require_once str_replace('_', '/', $class).'.php';
}
/**
Validate an email address.
Provide email address (raw input)
Returns true if the email address has the email 
address format and the domain exists.
*/
function validEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
	 // local part length exceeded
	 $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
	 // domain part length exceeded
	 $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
	 // local part starts or ends with '.'
	 $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
	 // local part has two consecutive dots
	 $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
	 // character not valid in domain part
	 $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
	 // domain part has two consecutive dots
	 $isValid = false;
      }
      else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',  str_replace("\\\\","",$local)))
      {
	 // character not valid in local part unless 
	 // local part is quoted
	 if (!preg_match('/^"(\\\\"|[^"])+"$/',
	     str_replace("\\\\","",$local)))
	 {
	    $isValid = false;
	 }
      }
      if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
      {
	 // domain not found in DNS
	 $isValid = false;
      }
   }
   return $isValid;
}

function validMDP($mdp){
	
	// check de la longueur du mdp 
	if(strlen($mdp) < 6 || strlen($mdp) > 20){
	    return false; 
	} 
	//On vérifie la présence de chiffres et de lettres
	else if(!preg_match("/[a-zA-Z][0-9]|[a-zA-Z][0-9]/",$mdp)){   
		return false;   
	}
	else{
		return true;
	}
}

function estRempli($value){
	if(isset($value) && !empty($value)){
		return true;
	}
	else{
		return false;
	}
}

function compare($un, $deux){
	if ($un > $deux){
		return 1;
	}elseif ($un == $deux){
		return 0;
	}else{
		return -1;
	}
}

//compare une date a la date du serveur
//retourn 1 si le film est deja sorti
//0 si il sort aujourd'hui
//-1 si il va sortir
function compareDate($date){
			if ($date=='NC'){
				return -1;
			}
			//on compare l'annee
			//Si l'annee en cours est supperieur
			if (compare(date('Y'), $date[2])==1){//=> le film est deja sorti
				//echo 'annee courrante plus grande<br/>';
				//var_dump($date);
				//echo "<br/>";
				//echo date('Y');
				//echo "<br/>";
				return 1;
				
			//si l'annee en cours est egale
			}elseif (compare(date('Y'), $date[2])==0){//=> comparer le mois 
				//echo 'annees egales : comparaison des mois<br/>';
				
				//si le mois en cours est supperieur
				if (compare(date('m'), $date[1])==1){//=> le film est deja sorti
					//echo 'mois courrant plus grand<br/>';
					return 1;
				//si le mois en cours est egale
				}elseif (compare(date('m'), $date[1])==0){//=> comparer le jour 
				
					//echo 'mois egaux : comparaison des jours<br/>';
					//Si le jours est supperieur
					if (compare(date('j'), $date[0])==1){//=> le film est deja sorti
						//echo 'jour courrant plus grand<br/>';
						return 1;
						
					//Si le jours est egale
					}elseif (compare(date('j'), $date[0])==0){// => le film sort aujourd'hui !!!!!!!!!!
						//echo 'jours egaux<br/>';
						return 0;
						
					//Si le jours est inferieur
					}else {//=> le film va sortir
						//echo 'jour courrante plus petit<br/>';
						return -1;
					}
					
				//si le mois en cours est inferieur
				}else {//=> le film va sortir
					//echo 'mois courrant plus petit<br/>';
					return -1;
				}
			
			//si l'annee en cours est inferieur 	
			}else {//=> le film va sortir
				//echo 'annee courrante plus petite<br/>';
				return -1;
			}
}
?>

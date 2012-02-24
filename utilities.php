<?php

/*** UTILITIES ***/

/* code based on http://www.linuxjournal.com/article/9585 */
function checkEmail($email) {
  if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",
               $email)){
    list($username,$domain)=split('@',$email);
    if(!checkdnsrr($domain,'MX')) {
      return false;
    }
    return true;
  }
  return false;
}

function checkPassword($password) {
	if ( strlen($password) < 4 || strlen($password) > 16 )
	{	return false; }

	if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*$/",$password))
	{
    	return true;
    }
  return false;
}

function checkLogin($login)
{
	if ( strlen($login) < 1 || strlen($login) > 32 )
	{	return false; }
	
	if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*$/",$login))
	{
    	return true;
    }
  return false;
}

?>
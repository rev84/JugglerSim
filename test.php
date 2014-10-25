<?php

require_once(dirname(__FILE__).'/machines/JugglerApex.php');

$app = new JugglerApex(6);

$medal = 0;

while(true){
	$stdin = trim(fgets(STDIN));
	$result = $app->Game();
	$medal += ($result === false ? 0 : $result['pay'])-3;
	echo $result['name']."\t".$medal."\n";
}


?>
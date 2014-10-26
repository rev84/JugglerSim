<?php

// 0 <= n < 1 の乱数取得
function MyRand(){
	return mt_rand() / (mt_getrandmax()+1);
}


?>
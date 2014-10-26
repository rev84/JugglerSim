<?php

require_once(dirname(__FILE__).'/Player.php');
require_once(dirname(__FILE__).'/Hall.php');

// 何日間やるか
define('DAYS',	100000);

Class World{
	protected $player;

	public function __construct(){
		$this->player	= new Player();
		
		$this->run();
	}
	
	protected function run(){
		for($i = 0; $i < DAYS; $i++){
			$hall	= new Hall($this->player);
		}
		
		$this->player->Output();
	}
}

$app	= new World();

?>
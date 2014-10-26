<?php

require_once(dirname(__FILE__).'/Utility.php');
require_once(dirname(__FILE__).'/../machines/JugglerApex.php');

Class Hall{
	protected $player;
	protected $machines;
	
	// 残り時間
	protected $time;
	
	public function __construct($iPlayer){
		// プレイヤー
		$this->player	= $iPlayer;
		// 台の初期化
		$this->Initialize();
		// 残り時間
		$this->time = $this->DefineTime();
		
		// プレイヤーに開店を知らせる
		$this->player->Open($this->machines);
		
		// プレイヤーの立ち回り
		while($this->time > 0){
			// 立ち回り
			list($decreaseTime, $machines)	= $this->player->Action($this->machines);
			$this->machines = $machines;
			// 時間減らす
			$this->time -= $decreaseTime;
		}
		
		$this->player->Close($this->machines);
	}
	
	// 台の初期化
	protected function Initialize(){
		// 台数
		$max	= $this->DefineMachineNum();
		
		// 台初期化
		$this->machines = array();
		for($i = 0; $i < $max; $i++){
			$this->machines[$i] = new JugglerApex($this->GetRank());
			$this->machines[$i]->PreGame($this->GetPreGame());
		}
	}
	
	// 台の数
	protected function DefineMachineNum(){
		return 30;
	}
	
	// 設定の入れ方
	protected function DefineRank(){
		/*return array(
			1	=> 0.900,
			2	=> 0.050,
			3	=> 0.025,
			4	=> 0.0125,
			5	=> 0.0100,
			6	=> 0.0025,
		);*/
		return array(
			1	=> 0.950,
			2	=> 0.025,
			3	=> 0.0125,
			4	=> 0.00625,
			5	=> 0.003125,
			6	=> 0.003125,
		);
	}
	
	// 既に回されている回転数の設定
	protected function DefinePreGame(){
		return array(
			array(	'p'	=> 0.1, 'min'	=> 0,		'max'	=> 99),
			array(	'p'	=> 0.2, 'min'	=> 100,		'max'	=> 299),
			array(	'p'	=> 0.2, 'min'	=> 500,		'max'	=> 999),
			array(	'p'	=> 0.2, 'min'	=> 1000,	'max'	=> 1999),
			array(	'p'	=> 0.2, 'min'	=> 2000,	'max'	=> 2999),
			array(	'p'	=> 0.1, 'min'	=> 3000,	'max'	=> 5000),
		);
	}
	
	// 設定の定義に従い設定の取得
	protected function GetRank(){
		$rand	= MyRand();
		$defs	= $this->DefineRank();
		
		$pCount	= 0;
		foreach($defs as $rank => $p){
			$pCount += $p;
			if($pCount > $rand){
				return $rank;
			}
		}
		
		return 1;
	}
	
	// 既に回されている回転数を定義に従い取得
	protected function GetPreGame(){
		$rand	= MyRand();
		$defs	= $this->DefinePreGame();
		
		$pCount	= 0;
		foreach($defs as $def){
			$pCount += $def['p'];
			if($pCount > $rand){
				return mt_rand($def['min'], $def['max']);
			}
		}
		
		return 0;
	}
	
	// プレイヤーに許す開店中の1日あたり回転回数
	protected function DefineTime(){
		// 1時間あたり650回転＊3.75時間（19時～22時45分）
		return floor(650*3.75);
	}
}


?>
<?php

require_once(dirname(__FILE__).'/../env/Utility.php');

Class SlotMachine{
	// 設定
	protected $rank;
	
	// 総回転数
	protected $count	= 0;
	// 現回転数
	protected $countNow	= 0;
	// 現回転数リセットフラグ
	protected $countReset	= false;
	// BB回数
	protected $big		= 0;
	// RB回数
	protected $reg		= 0;
	
	// 差枚
	protected $samai	= 0;
	
	// 役
	protected $yaku;
	
	public function __construct($iRank){
		$this->SetRank($iRank);
	}
	
	// 事前に回す
	public function PreGame($iGameCount){
		for($i = 0; $i < $iGameCount; $i++){
			$this->Game();
		}
	}
	
	// 回す
	public function Game(){
		// 現回転数リセットフラグ
		if($this->countReset){
			$this->countNow = 0;
			$this->countReset = false;
		}
		
		// 回転
		$this->count++;
		$this->countNow++;
		$this->samai -= 3;
		
		// 乱数生成
		$rand	= MyRand();
		
		// 役判定
		$pCount = 0;
		foreach($this->yaku as $yaku){
			$pCount += $yaku['p'];

			// 成立
			if($pCount > $rand){
				// ビッグ
				if($yaku['isBig']){
					$this->big++;
					$this->countReset	= true;
				}
				// レグ
				if($yaku['isReg']){
					$this->reg++;
					$this->countReset	= true;
				}
				// 差枚
				$this->samai += $yaku['pay'];
				
				return $yaku;
			}
		}
		
		// ハズレ
		return false;
	}

	// 設定変更
	protected function SetRank($iRank){
		$yaku	= $this->GetYaku();
		
		$this->yaku	= isset($yaku[$iRank]) ? $yaku[$iRank] : array();
		$this->rank	= $iRank;
	}
	
	// 役
	public function GetYaku(){
	}
	
	// 自分の機種名
	public function GetMyName(){
	}
	
	// 合成確率
	public function GetBonusP(){
		return $this->count == 0 ? 0 : ($this->big + $this->reg) / $this->count;
	}
	// BIG回数
	public function GetBigCount(){
		return $this->big;
	}
	// REG回数
	public function GetRegCount(){
		return $this->reg;
	}
	// BIG確率
	public function GetBigP(){
		return $this->count == 0 ? 0 : $this->big / $this->count;
	}
	// REG確率
	public function GetRegP(){
		return $this->count == 0 ? 0 : $this->reg / $this->count;
	}
	// 総回転数
	public function GetGameTotal(){
		return $this->count;
	}
	// 現回転数
	public function GetGameNow(){
		return $this->countNow;
	}
	// 設定
	public function GetRank(){
		return $this->rank;
	}
}


?>
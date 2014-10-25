<?php

Class SlotMachine{
	// 設定
	protected $rank;
	
	// 回転数
	protected $count	= 0;
	// BB回数
	protected $big		= 0;
	// RB回数
	protected $reg		= 0;
	
	// 差枚
	protected $samai	= 0;
	
	// 役
	protected $yaku;
	
	public function __construct($rank){
		$this->SetRank($rank);
	}
	
	// 回す
	public function Game(){
		// 回転
		$this->count++;
		$this->samai -= 3;
		
		// 乱数生成
		$rand	= $this->Rand();
		
		// 役判定
		$pCount = 0;
		foreach($this->yaku as $yaku){
			$pCount += $yaku['p'];

			// 成立
			if($pCount > $rand){
				// ビッグ
				if($yaku['isBig']){
					$this->big++;
				}
				// レグ
				if($yaku['isReg']){
					$this->reg++;
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
	protected function SetRank($rank){
		$yaku	= $this->GetYaku();
		
		$this->yaku	= isset($yaku[$rank]) ? $yaku[$rank] : array();
	}
	
	// 役
	protected function GetYaku(){
	}
	
	// 合成確率
	protected function GetBonusP(){
		return $this->count == 0 ? 0 : ($this->big + $this->reg) / $this->count;
	}
	// BIG確率
	protected function GetBigP(){
		return $this->count == 0 ? 0 : $this->big / $this->count;
	}
	// REG確率
	protected function GetRegP(){
		return $this->count == 0 ? 0 : $this->reg / $this->count;
	}
		
	// 乱数取得
	protected function Rand(){
		return mt_rand() / (mt_getrandmax()+1);
	}
	
	public function PubGetYaku(){
		return $this->GetYaku();
	}
}


?>
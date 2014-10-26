<?php

// これ以上の合算であれば打つ
define('PLAY_BASELINE_BONUSP',	1/130);
// ログファイル
define('LOG_FILE_PATH',	'./result/log.html');
// データカウンタを出力するか
define('IS_OUTPUT_DATACOUNTER', false);

Class Player{
	// ログ
	protected $log;
	// 開始時の台のログ
	protected $logMachinesStart;
	// 終了時の台のログ
	protected $logMachinesEnd;
	
	// 設定別ゲーム数
	protected $gamePerRank;
	
	// 日数
	protected $day			= 0;
	// 打たずに帰るフラグ
	protected $noGameDayFlag= true;
	// 打たずに帰った日
	protected $noGameDay	= 0;
	// 合計差枚
	protected $samaiTotal	= 0;
	// 当日差枚
	protected $samaiToday	= 0;
	// その台の差枚
	protected $samaiMachine	= 0;
	// 取りこぼした枚数
	protected $missPay		= 0;
	
	// 打っている台
	protected $sitNow		= false;
	// 同じ台を打ち始めてからの回転数
	protected $game			= 0;
	// 今日はもう打たないという意志
	protected $neverPlay	= false;
	
	// 作成
	public function __construct(){
		$this->samaiTotal		= 0;
		$this->medalToday		= 0;
		$this->sitNow			= false;
		$this->log				= array();
		$this->logMachinesStart	= array();
		$this->logMachinesEnd	= array();
		$this->gamePerRank		= array(
			1	=> 0,
			2	=> 0,
			3	=> 0,
			4	=> 0,
			5	=> 0,
			6	=> 0,
		);
	}
	
	// 開店を知らされる
	public function Open($iMachines){
		$this->day++;
		$this->game			= 0;
		$this->samaiToday	= 0;
		$this->samaiMachine	= 0;
		$this->sitNow		= false;
		$this->neverPlay	= false;
		
		$this->log[$this->day]	= array();
		if(IS_OUTPUT_DATACOUNTER)	$this->logMachinesStart[$this->day]	= $this->CloneMachine($iMachines);
		
		// 打たずに帰ったかチェック
		$this->noGameDayFlag	= true;
	}
	
	// 閉店を知らされる
	public function Close($iMachines){
		// 打たずに帰ったか
		if($this->noGameDayFlag) $this->noGameDay++;
		
		if(IS_OUTPUT_DATACOUNTER)	$$this->logMachinesEnd[$this->day]	= $this->CloneMachine($iMachines);

		if($this->sitNow !== false){
			$this->Log($this->sitNow.'番台を打っていて、閉店でやめた（この台で'.$this->samaiMachine.'差枚）');
		}
		$this->Log('閉店した。（今日は'.$this->samaiToday.'差枚、トータルで'.$this->samaiTotal.'差枚）');
		
		echo $this->day.' day end'."\t".$this->samaiTotal."\t".$this->missPay."\t".($this->day-$this->noGameDay).' day went'."\n";
	}
	
	// 台情報を見て打つ
	public function Action($iMachines){
		$play	= false;
		
		// 打っている状態なら
		if($this->sitNow !== false){
			// 合算が基準を下回れば
			if(!$this->CanChoice($iMachines[$this->sitNow])){
				// 打つのをやめる
				$this->Log($this->sitNow.'番台を打つのをやめた（この台で'.$this->samaiMachine.'差枚、今日は'.$this->samaiToday.'差枚）');
				$this->sitNow	= false;
			}
		}

		// 打ってない状態なら
		if($this->sitNow === false){
			// 台探し
			$isMachineFound	= false;
			/*
			foreach($iMachines as $key => $machine){
				// 合算が基準以上の台を探して、あれば
				if($this->CanChoice($machine)){
					// その台に座る
					$this->sitNow	= $key;
					$isMachineFound	= true;
					$this->Log(''.$this->sitNow.'番台を打つことにした（今日は'.$this->samaiToday.'差枚）');
					$this->samaiMachine	= 0;
					$this->game = 0;
					break;
				}
			}
			*/
			$maxPointMachineKey	= $this->GetMaxPointMachineKey($iMachines);
			if($maxPointMachineKey !== false){
				// その台に座る
				$this->sitNow	= $maxPointMachineKey;
				$isMachineFound	= true;
				$this->Log(''.$this->sitNow.'番台を打つことにした（今日は'.$this->samaiToday.'差枚）');
				$this->samaiMachine	= 0;
				$this->game = 0;
			}
			
			// 台が見つからなかったら
			if(!$isMachineFound){
				// もう打つのはやめる
				$this->neverPlay	= true;
				$this->Log('もう今日は打たないと決めた');
				
				return array(99999999, $iMachines);
			}
		}
		
		// 打つかどうか決めて、打つ
		if(!$this->neverPlay && $this->sitNow !== false){
			$result	= $iMachines[$this->sitNow]->Game();
			
			// 打ってしまった
			$this->noGameDayFlag	= false;
			
			$this->samaiMachine	-= 3;
			$this->samaiToday	-= 3;
			$this->samaiTotal	-= 3;
			$this->game++;
			$this->gamePerRank[$iMachines[$this->sitNow]->GetRank()]++;
			
			// ハズレ
			if($result === false){
				// 結果を返す
				return array(1, $iMachines);
			}
			// 何かに当選
			else{
				// ピエロとベルは取りこぼす
				if(!($result['name'] == 'Pierrot' || $result['name'] == 'Bell')){
					$this->samaiMachine	+= $result['pay'];
					$this->samaiToday	+= $result['pay'];
					$this->samaiTotal	+= $result['pay'];
				} else {
					$this->missPay		+= $result['pay'];
				}
			
				// BIG引いた
				if($result['isBig']){
					$this->Log($this->sitNow.'番台でBIG当選（'.$iMachines[$this->sitNow]->GetGameNow().'回転　'.$this->samaiToday.'差枚）');
				}
				// REG引いた
				if($result['isReg']){
					$this->Log($this->sitNow.'番台でREG当選（'.$iMachines[$this->sitNow]->GetGameNow().'回転　'.$this->samaiToday.'差枚）');
				}
				
				// 結果を返す
				return array($result['time'], $iMachines);
			}
		}
		
	}
	
	// ログをとる
	protected function Log($iLogMessage){
		$this->log[$this->day][]	= $iLogMessage;
	}
	
	// ログをアウトプット
	public function Output(){
		$buf	= '<html><head><meta charset="UTF-8" /><link rel="stylesheet" href="./log.css"></head><body>';
		foreach($this->log as $day => $logDay){
			$buf	.= '<h1>'.$day.'日目</h1>';
			
			// 初期台
			if(IS_OUTPUT_DATACOUNTER){
				$buf	.= $this->GetMachineHtml($this->logMachinesStart[$day]);
			}
			
			// 立ち回りログ
			foreach($logDay as $logRecord){
				$buf	.= $logRecord."<br>";
			}
			
			// 終了台
			if(IS_OUTPUT_DATACOUNTER){
				$buf	.= $this->GetMachineHtml($this->logMachinesEnd[$day]);
				$buf	.= '<hr>';
			}
		}
		
		// 設定別ゲーム数
		$buf	.= '<hr><h1>設定別ゲーム数</h1><table border="1"><tr><th>設定</th><th>ゲーム数</th></tr>';
		for($i = 1; $i <= 6; $i++){
			$buf	.= '<tr><td>'.$i.'</td><td>'.$this->gamePerRank[$i].'</td></tr>';
		}
		$buf	.= '</table>';
		
		// 打たずに帰った日
		$buf	.= '<hr><h1>打たずに帰った日</h1>'.$this->noGameDay.'日';
		
		// 取りこぼし
		$buf	.= '<hr><h1>取りこぼしたベルとピエロ</h1>'.$this->missPay.'枚';
		
		$buf	.= '</body></html>';
		file_put_contents(LOG_FILE_PATH, $buf);
	}
	
	protected function GetMachineHtml($iMachines){
		$buf	= <<<EOM
<table border="1">
<tr>
<th>番号</th>
<th>データ</th>
</tr>
EOM;
		foreach($iMachines as $num => $machine){
			$gameTotal	= $machine->GetGameTotal();
			$gameNow	= $machine->GetGameNow();
			$bonusP		= $machine->GetBonusP() == 0 ? '-' : sprintf('1/%.1f', 1/$machine->GetBonusP());
			$bigP		= $machine->GetBigP() == 0 ? '-' : sprintf('1/%.1f', 1/$machine->GetBigP());
			$regP		= $machine->GetRegP() == 0 ? '-' : sprintf('1/%.1f', 1/$machine->GetRegP());
			$big		= $machine->GetBigCount();
			$reg		= $machine->GetRegCount();
			$rank		= $machine->GetRank();

			$buf	.= <<<EOM
<tr>
<td>{$num}</td>
<td>
<table class="dataBack">
<tbody>
<tr class="titlebar">
<th class="bb">BB</th>
<th class="rb">RB</th>
<th class="st">スタート</th>
<th class="to">トータル</th>
<th class="go">合成</th>
<th class="rank">設定</th>
</tr>
<tr class="counter">
<td class="bb">{$big}</td>
<td class="rb">{$reg}</td>
<td class="st">{$gameNow}</td>
<td class="to">{$gameTotal}</td>
<td class="go">{$bonusP}</td>
<td class="rank">{$rank}</td>
</tr>
</tbody>
</table>
</td>
</tr>
EOM;
		}
		$buf	.= '</table>';
		
		return $buf;
	}
	
	protected function CloneMachine($iMachines){
		$result = array();
		
		foreach($iMachines as $key => $val){
			$result[$key] = clone $val;
		}
		
		return $result;
	}
	
	// 台を選ぶ条件
	protected function CanChoice($iMachine){
		return (
			$iMachine->GetBonusP() > PLAY_BASELINE_BONUSP &&
			$iMachine->GetGameTotal() >= 3000 &&
			$iMachine->GetRegP() >= 1/300
		);
	}
	
	// 最も点数の高い台を返す
	protected function GetMaxPointMachineKey($iMachines){
		$maxKey		= false;
		$maxPoint	= -1;
		foreach($iMachines as $key => $machine){
			$nowPoint	= $this->JudgeMachine($machine);
			
			// 話にならない
			if($nowPoint === false) continue;
			
			// 合計点で勝っている
			if($nowPoint > $maxPoint){
				$maxKey		= $key;
				$maxPoint	= $nowPoint;
			}
			// 合計点が同じ
			elseif($nowPoint == $maxPoint){
				// 合算を優先
				if($machine->GetBonusP() > $iMachines[$maxKey]->GetBonusP()){
					$maxKey		= $key;
					$maxPoint	= $nowPoint;
				}
				// それさえ同じなら、回転数勝負
				elseif($machine->GetBonusP() == $iMachines[$maxKey]->GetBonusP() && $machine->GetGameTotal() > $iMachines[$maxKey]->GetGameTotal()){
					$maxKey		= $key;
					$maxPoint	= $nowPoint;
				}
			}
		}
		
		return $maxKey;
	}
	
	// 台を採点
	protected function JudgeMachine($iMachine){
		$regPoint	= 0;
		$totalPoint	= 0;
		$gamePoint	= 0;
		
		$bonusP		= $iMachine->GetBonusP();
		$totalGame	= $iMachine->GetGameTotal();
		$regP		= $iMachine->GetRegP();
		
		// ボーナス合算を採点
		if($bonusP >= 1/105){
			$bonusPoint	= 5;
		}
		elseif($bonusP >= 1/110){
			$bonusPoint	= 4;
		}
		elseif($bonusP >= 1/115){
			$bonusPoint	= 3;
		}
		elseif($bonusP >= 1/120){
			$bonusPoint	= 2;
		}
		elseif($bonusP >= 1/125){
			$bonusPoint	= 1;
		}
		elseif($bonusP >= 1/130){
			$bonusPoint	= 0;
		}
		else{
			return false;
		}
		
		// REG確率を採点
		if($regP >= 1/220){
			$regPoint	= 5;
		}
		elseif($regP >= 1/230){
			$regPoint	= 4;
		}
		elseif($regP >= 1/240){
			$regPoint	= 3;
		}
		elseif($regP >= 1/250){
			$regPoint	= 2;
		}
		elseif($regP >= 1/270){
			$regPoint	= 1;
		}
		elseif($regP >= 1/300){
			$regPoint	= 0;
		}
		else{
			return false;
		}
		
		// 回転数を採点
		if($totalGame >= 5000){
			$totalPoint	= 5;
		}
		elseif($totalGame >= 4600){
			$totalPoint	= 4;
		}
		elseif($totalGame >= 4200){
			$totalPoint	= 3;
		}
		elseif($totalGame >= 3800){
			$totalPoint	= 2;
		}
		elseif($totalGame >= 3400){
			$totalPoint	= 1;
		}
		elseif($totalGame >= 3000){
			$totalPoint	= 0;
		}
		else{
			return false;
		}
		
		return $regPoint+$totalPoint+$bonusPoint;
	}
}

?>
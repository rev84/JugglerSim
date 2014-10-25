<?php

require_once(dirname(__FILE__).'/SlotMachine.php');

Class JugglerApex extends SlotMachine{
	// 設定変更
	protected function GetYaku(){
		$yaku	= array();
		
		// 設定1
		$yaku[1]	= array(
			array(	'name'	=> 'Replay',		'pay'	=> 3,		'p'	=> 1/7.3,			'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'Bell',			'pay'	=> 10,		'p'	=> 1/1092.27,		'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'Pierrot',		'pay'	=> 14,		'p'	=> 1/1092.27,		'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'Grape',		'pay'	=> 7,		'p'	=> 1/6.49,			'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'Cherry',		'pay'	=> 2,		'p'	=> (5.73/100)-(1/963.76)-(1/1489.45),	'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'CherryBIG',	'pay'	=> 2+324,	'p'	=> 1/963.76,		'isBig'	=> true,	'isReg'	=> false,	),
			array(	'name'	=> 'CherryREG',	'pay'	=> 2+103,	'p'	=> 1/1489.45,		'isBig'	=> false,	'isReg'	=> true,	),
			array(	'name'	=> 'OnlyBIG',		'pay'	=> 324,		'p'	=> 1/409.6,			'isBig'	=> true,	'isReg'	=> false,	),
			array(	'name'	=> 'OnlyREG',		'pay'	=> 103,		'p'	=> 1/655.36,		'isBig'	=> false,	'isReg'	=> true,	),
		);
		// 設定2
		$yaku[2]	= array(
			array(	'name'	=> 'Replay',		'pay'	=> 3,		'p'	=> 1/7.3,			'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'Bell',			'pay'	=> 10,		'p'	=> 1/1092.27,		'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'Pierrot',		'pay'	=> 14,		'p'	=> 1/1092.27,		'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'Grape',		'pay'	=> 7,		'p'	=> 1/6.49,			'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'Cherry',		'pay'	=> 2,		'p'	=> (5.73/100)-(1/963.76)-(1/1489.45),	'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'CherryBIG',	'pay'	=> 2+324,	'p'	=> 1/963.76,		'isBig'	=> true,	'isReg'	=> false,	),
			array(	'name'	=> 'CherryREG',	'pay'	=> 2+103,	'p'	=> 1/1489.45,		'isBig'	=> false,	'isReg'	=> true,	),
			array(	'name'	=> 'OnlyBIG',		'pay'	=> 324,		'p'	=> 1/399.61,		'isBig'	=> true,	'isReg'	=> false,	),
			array(	'name'	=> 'OnlyREG',		'pay'	=> 103,		'p'	=> 1/630.15,		'isBig'	=> false,	'isReg'	=> true,	),
		);
		// 設定3
		$yaku[3]	= array(
			array(	'name'	=> 'Replay',		'pay'	=> 3,		'p'	=> 1/7.3,			'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'Bell',			'pay'	=> 10,		'p'	=> 1/1092.27,		'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'Pierrot',		'pay'	=> 14,		'p'	=> 1/1092.27,		'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'Grape',			'pay'	=> 7,		'p'	=> 1/6.49,			'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'Cherry',		'pay'	=> 2,		'p'	=> (6.37/100)-(1/963.76)-(1/1489.45),	'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'CherryBIG',		'pay'	=> 2+324,	'p'	=> 1/963.76,		'isBig'	=> true,	'isReg'	=> false,	),
			array(	'name'	=> 'CherryREG',		'pay'	=> 2+103,	'p'	=> 1/1170.29,		'isBig'	=> false,	'isReg'	=> true,	),
			array(	'name'	=> 'OnlyBIG',		'pay'	=> 324,		'p'	=> 1/399.61,		'isBig'	=> true,	'isReg'	=> false,	),
			array(	'name'	=> 'OnlyREG',		'pay'	=> 103,		'p'	=> 1/496.48,		'isBig'	=> false,	'isReg'	=> true,	),
		);
		// 設定4
		$yaku[4]	= array(
			array(	'name'	=> 'Replay',		'pay'	=> 3,		'p'	=> 1/7.3,			'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'Bell',			'pay'	=> 10,		'p'	=> 1/1092.27,		'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'Pierrot',		'pay'	=> 14,		'p'	=> 1/1092.27,		'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'Grape',			'pay'	=> 7,		'p'	=> 1/6.49,			'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'Cherry',		'pay'	=> 2,		'p'	=> (6.69/100)-(1/910.22)-(1/1092.27),	'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'CherryBIG',		'pay'	=> 2+324,	'p'	=> 1/910.22,		'isBig'	=> true,	'isReg'	=> false,	),
			array(	'name'	=> 'CherryREG',		'pay'	=> 2+103,	'p'	=> 1/1092.27,		'isBig'	=> false,	'isReg'	=> true,	),
			array(	'name'	=> 'OnlyBIG',		'pay'	=> 324,		'p'	=> 1/390.1,			'isBig'	=> true,	'isReg'	=> false,	),
			array(	'name'	=> 'OnlyREG',		'pay'	=> 103,		'p'	=> 1/455.11,		'isBig'	=> false,	'isReg'	=> true,	),
		);
		// 設定5
		$yaku[5]	= array(
			array(	'name'	=> 'Replay',		'pay'	=> 3,		'p'	=> 1/7.3,			'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'Bell',			'pay'	=> 10,		'p'	=> 1/1092.27,		'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'Pierrot',		'pay'	=> 14,		'p'	=> 1/1092.27,		'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'Grape',			'pay'	=> 7,		'p'	=> 1/6.49,			'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'Cherry',		'pay'	=> 2,		'p'	=> (7.26/100)-(1/910.22)-(1/910.22),	'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'CherryBIG',		'pay'	=> 2+324,	'p'	=> 1/910.22,		'isBig'	=> true,	'isReg'	=> false,	),
			array(	'name'	=> 'CherryREG',		'pay'	=> 2+103,	'p'	=> 1/910.22,		'isBig'	=> false,	'isReg'	=> true,	),
			array(	'name'	=> 'OnlyBIG',		'pay'	=> 324,		'p'	=> 1/390.1,			'isBig'	=> true,	'isReg'	=> false,	),
			array(	'name'	=> 'OnlyREG',		'pay'	=> 103,		'p'	=> 1/381.02,		'isBig'	=> false,	'isReg'	=> true,	),
		);
		// 設定6
		$yaku[6]	= array(
			array(	'name'	=> 'Replay',		'pay'	=> 3,		'p'	=> 1/7.3,			'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'Bell',			'pay'	=> 10,		'p'	=> 1/1092.27,		'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'Pierrot',		'pay'	=> 14,		'p'	=> 1/1092.27,		'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'Grape',			'pay'	=> 7,		'p'	=> 1/6.18,			'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'Cherry',		'pay'	=> 2,		'p'	=> (7.26/100)-(1/910.22)-(1/910.22),	'isBig'	=> false,	'isReg'	=> false,	),
			array(	'name'	=> 'CherryBIG',		'pay'	=> 2+324,	'p'	=> 1/910.22,		'isBig'	=> true,	'isReg'	=> false,	),
			array(	'name'	=> 'CherryREG',		'pay'	=> 2+103,	'p'	=> 1/910.22,		'isBig'	=> false,	'isReg'	=> true,	),
			array(	'name'	=> 'OnlyBIG',		'pay'	=> 324,		'p'	=> 1/381.02,		'isBig'	=> true,	'isReg'	=> false,	),
			array(	'name'	=> 'OnlyREG',		'pay'	=> 103,		'p'	=> 1/381.02,		'isBig'	=> false,	'isReg'	=> true,	),
		);
		
		return $yaku;
	}
}

?>
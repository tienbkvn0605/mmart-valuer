<?php
/**
 * 勝手に売上創る商品登録
 * 2024/01/22   ナム    バルル委託販売機能作成（休業日設定表登録）
 */

include_once('/var/www/html3/outlet/valeur/lib/config.php');

// 商品のインスタンス生成
$c_item = new Item();
$c_seller = new Seller();
//ログインチェック開始-----------------------------------------------

//出店者情報取得
$A_seller = array();

//出品社管理ページ経由id
$S_id = '';
if (isset($_SESSION[DF_session_key][DF_seller_admin_session]['id'])) {
	$S_id = trim($_SESSION[DF_session_key][DF_seller_admin_session]['id']);
}

if(empty($S_id)){
	header('Location: '.'https://'.$_SERVER['HTTP_HOST'].'/outlet/valeur/admin/index.php');
	exit;
}


$A_seller = $c_seller->get_seller_valeur($S_id);
if(empty($A_seller) || empty($A_seller['day_debut']) || ($A_seller['valeur_kakunin_flg'] == 0)){
	header('Location: '.'https://'.$_SERVER['HTTP_HOST'].'/outlet/admin/index.php');
	exit;
}
//ログインチェック終了-----------------------------------------------

$p_kind = 'reg';
isset($_POST['p_kind']) && $p_kind = $_POST['p_kind'];

// ヘッダーのタイトル
$header_title = '休業日設定';
$error_mess = [
	'mess' => isset($_SESSION[DF_session_key]['set_calendar_mess']['mess']) ? $_SESSION[DF_session_key]['set_calendar_mess']['mess'] : '',
	'status' => isset($_SESSION[DF_session_key]['set_calendar_mess']['status'])? $_SESSION[DF_session_key]['set_calendar_mess']['status']: '',
];

unset($_SESSION[DF_session_key]['set_calendar_mess']);

$y=date('Y');	//当年
$m=date('n');	//当月
$disp_rest1=F_make_rest($y,$m);
	if(++$m>12){
		$m=1;
		$y++;
	}
	//休業日カレンダー作成次月
$disp_rest2=F_make_rest($y,$m);
// 商品情報入力
$holiday_arr = $c_item->get_all_holiday($S_id);

if($p_kind === 'set_calendar'){
	
	$data_insert = [
		'holiday_name' => mb_convert_encoding($_POST['holiday_name'], 'SJIS', 'auto'),
		'valeur_id' => $S_id,
		'kyugyou_date' => (mb_convert_encoding($_POST['selected_calendar'], 'UTF-8', 'auto')),
	];
	
	if($c_item -> set_holiday_table($data_insert)){
		$_SESSION[DF_session_key]['set_calendar_mess']['mess'] = '休業日設定表を登録しました。';
		$_SESSION[DF_session_key]['set_calendar_mess']['status'] = 'ok';
	}else{
		$_SESSION[DF_session_key]['set_calendar_mess']['mess'] = '休業日設定表の登録が失敗しました。';
		$_SESSION[DF_session_key]['set_calendar_mess']['status'] = 'err';
	}
	header('Location: '.'https://'.$_SERVER['HTTP_HOST'].'/outlet/valeur/seller/calendar_reg.php');
	exit;
}
// 休業日設定表名をチェック
else if($p_kind === 'holiday_name_check'){
	$data = [
		'holiday_name' => mb_convert_encoding($_POST['holiday_name'], 'SJIS', 'auto'),
		'valeur_id' => $S_id,
	];
	$cnt = $c_item -> holiday_table_name_check($data);
	
	if((int)$cnt > 0){
		echo ':r:error:r:';
		exit;
	}
	echo ':r:OK:r:';
	exit;
}
// 休業日設定表を削除
else if($p_kind == 'remove_holiday_by_serial'){
	if(isset($_POST['holiday_serial'])){
		$data = [
			'serial' => $_POST['holiday_serial'],
			'valeur_id' => $S_id,
		];
		$c_item -> remove_holiday_by_serial($data);
		echo ':r:OK:r:';
		//header('Location: '.'https://'.$_SERVER['HTTP_HOST'].'/outlet/valeur/seller/calendar_reg.php');
		exit;
	}
	exit;
}

include_once('/var/www/html3/outlet/valeur/seller/tpl/tpl_calendar_reg.php');

?>
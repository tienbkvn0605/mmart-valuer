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
	header('Location: '.'https://'.$_SERVER['HTTP_HOST'].'/outlet/valeur/admin/index.php');
	exit;
}
//ログインチェック終了-----------------------------------------------

$p_kind = 'reg';
isset($_POST['p_kind']) && $p_kind = $_POST['p_kind'];

$error_mess = [
	'mess' => isset($_SESSION[DF_session_key]['set_soryo_mess']['mess']) ? $_SESSION[DF_session_key]['set_soryo_mess']['mess'] : '',
	'status' => isset($_SESSION[DF_session_key]['set_soryo_mess']['status'])? $_SESSION[DF_session_key]['set_soryo_mess']['status']: '',
];

// 地方区分取得
$A_region_master = $c_item->get_region_master();
// 商品情報入力
$soryo_arr = $c_item->get_all_soryo_table($S_id);
$A_region = $c_item->get_region_master();

// ヘッダーのタイトル
$header_title = '配送料表設定';

unset($_SESSION[DF_session_key]['set_soryo_mess']);
if($p_kind === 'set_soryo'){
	
	$data_insert = [
		'soryo_table_name' => mb_convert_encoding($_POST['soryo_table_name'], 'SJIS', 'auto'),
		'valeur_id' => $S_id,
		'soryo_data' => mb_convert_encoding((json_decode($_POST['soryo_data'], true)), 'SJIS', 'auto'),
	];
	
	if($c_item -> set_soryo_table($data_insert)){
		$_SESSION[DF_session_key]['set_soryo_mess']['mess'] = '配送料表を登録しました。';
		$_SESSION[DF_session_key]['set_soryo_mess']['status'] = 'ok';

	}else{
		$_SESSION[DF_session_key]['set_soryo_mess']['mess'] = '配送料表の登録が失敗しました。';
		$_SESSION[DF_session_key]['set_soryo_mess']['status'] = 'err';
	}
	header('Location: '.'https://'.$_SERVER['HTTP_HOST'].'/outlet/valeur/seller/soryo_reg.php');
	exit;
}
// 配送料表名をチェック
else if($p_kind === 'soryo_table_name_check'){
	$data = [
		'soryo_table_name' => mb_convert_encoding($_POST['soryo_table_name'], 'SJIS', 'auto'),
		'valeur_id' => $S_id,
	];
	$cnt = $c_item -> soryo_table_name_check($data);
	
	if((int)$cnt > 0){
		echo ':r:error:r:';
		exit;
	}
	echo ':r:OK:r:';
	exit;
}
// 配送料表を削除
else if($p_kind == 'remove_soryo_by_serial'){
	
	if(isset($_POST['soryo_master_serial'])){
		$data = [
			'soryo_master_serial' => $_POST['soryo_master_serial'],
			'valeur_id' => $S_id,
		];
		$c_item -> remove_soryo_by_serial($data);
		echo ':r:OK:r:';
		exit;
	}
	exit;
}

include_once('/var/www/html3/outlet/valeur/seller/tpl/tpl_soryo_reg.php');

?>
<?php
/**********************************************
商品一覧画面
2024/01/26  機能追加	
***********************************************/
require_once("/var/www/html3/outlet/valeur/lib/config.php");
// 商品のインスタンス生成
$c_item = new Item();
$c_seller = new Seller();

//MAILオブジェクト実体化
require_once('/var/php_class/class_mail.php');
$c_mail=new G_class_mail;

//○配列
$A_debut_shinsei = []; 		// 商品登録申請リスト
$A_item_koukai = [];		// 商品登録公開リスト
$A_item_henshin = [];		// 商品登録返信リスト

//○変数
//ログイン出店社名
$A_seller=[];

//出品社管理ページ経由id
$S_id = '';
if (isset($_SESSION[DF_session_key][DF_seller_admin_session]['id'])) {
	$S_id = trim($_SESSION[DF_session_key][DF_seller_admin_session]['id']);
}
if(empty($S_id)){
	header('Location: '.'https://'.$_SERVER['HTTP_HOST'].'/outlet/valeur/admin/index.php');
	exit;
}

//●ログインチェック
$A_seller = $c_seller->F_check_login($S_id);
if(empty($A_seller) || empty($A_seller['day_debut']) || ($A_seller['valeur_kakunin_flg'] == 0)){
	header('Location: '.'https://'.$_SERVER['HTTP_HOST'].'/outlet/valeur/admin/index.php');
	exit;
}
// 渡す値
$p_kind = '';
isset($_REQUEST['p_kind']) && $p_kind = $_REQUEST['p_kind'];

// ヘッダーのタイトル
$header_title = 'バルル商品一覧';
// 出品社登録商品
$A_items = [
	'wait' => [],
	'done' => [],
	'henshin' => [],
];
$A_items['all'] = $A_items_total = $c_item->get_all_items($S_id);
if(count($A_items_total) > 0){
	foreach ($A_items_total as $key => $item) {
		
		//登録申請中
		if($item['review_flg'] == 0 && empty($item['review_time']) && empty($item['shounin_time']) && ($item['shounin_flg'] == 0)){
			$A_items['wait'][] = $item;
		}

		//公開済み
		if($item['review_flg'] == 1 && !empty($item['review_time']) && !empty($item['shounin_time']) && ($item['shounin_flg'] == 1)){
			$A_items['done'][] = $item;
		}

		//返信
		if( ($item['review_flg'] == 2 && !empty($item['review_time'])) || ($item['shounin_flg'] == 2)){
			$A_items['henshin'][] = $item;
		}
	}
}
if($p_kind == 're_set_price'){

	if(isset($_POST['ai_serial'])){
		$data = [
			'm_tanka' => $_POST['new_tanka'],
			'm_price_lot' => $_POST['new_lotkingaku'],
			'seller_id' => $S_id,
			'ai_serial' => $_POST['ai_serial'],
		];
		$c_item -> re_set_price($data);
		echo ':r:OK:r:';
		exit;
	}

}

//2024-02-08 h.nguyen start
//商品編集機能
if ($p_kind === 'item_edit') {
	if(isset($_POST['ai_serial'])) {
		$item_data = $c_item ->get_item_info($_POST['ai_serial']);

		// dump($data);
		include_once('/var/www/html3/outlet/valeur/seller/tpl/tpl_item_edit.php');
		exit;
	}
}
//2024-02-08 h.nguyen end

//情報処理----------------------------------------

//html
include_once('/var/www/html3/outlet/valeur/seller/tpl/tpl_list_item_bak240208hung.php');
?>

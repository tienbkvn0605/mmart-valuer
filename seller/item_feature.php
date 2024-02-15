<?php
/**
 * 商品情報特徴を追加
 * 2024/01/22   ナム    バルル委託販売機能作成
 */

include_once('/var/www/html3/outlet/valeur/lib/config.php');

// 商品のインスタンス生成
$c_item = new Item();
$c_seller = new Seller();

//ログインチェック開始-----------------------------------------------

//出店者情報取得
$A_seller = array();
header("Content-type: text/html; charset=UTF-8");
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
isset($_REQUEST['p_kind']) && $p_kind = $_REQUEST['p_kind'];
$f_ai_serial = '';
isset($_REQUEST['ai_serial']) && $f_ai_serial = $_REQUEST['ai_serial'];

// ヘッダーのタイトル
$header_title = '商品情報特徴を登録';
// 商品情報入力
// dump($p_kind);
if($p_kind === 'reg'){

	$item_data = $c_item->get_item_feature($f_ai_serial);
	
	if(empty($item_data)){
		header("Content-type: text/html; charset=UTF-8");
		echo('<script>
			alert("該当商品情報がありません。\\n商品一覧に戻します。");
			location.href = "/outlet/valeur/seller/list_item.php";
		</script>');
		exit;
	}
	$contents = isset($item_data['content_wysiwyg']) ? $item_data['content_wysiwyg'] : '';
	
}
// 特徴を保存
else if($p_kind == 'save_feature'){
	ini_set('memory_limit', '512M');
	$contents = $_POST['contents'];
	$contents = strip_tags($contents, $config['richtext_allows_tags']);
	
	if (strlen($contents) <= DF_content_size) {
		$c_item->update_feature($f_ai_serial, $contents);
		$success = true;
		$message = '商品特徴を保存できました。';
	} else {
		$success = false;
		$message = '制限サイズ['.DF_content_size.']バイトを超えました';
	}
	// テンプレート
	include_once('/var/www/html3/outlet/valeur/seller/tpl/tpl_item_feature.php');
	exit;
}

// テンプレート
include_once('/var/www/html3/outlet/valeur/seller/tpl/tpl_item_feature.php');

?>
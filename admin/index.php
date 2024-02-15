<?php
/************************************
 * バルル出品社　ログイン画面
2024/01/22	機能作成	ナム	バルル商品登録機能
*************************************/ 
// 出品社IDの取得
require('/var/www/html3/outlet/valeur/lib/config.php');

$c_seller = new Seller();
if (isset($_SESSION[DF_session_key][DF_seller_admin_session]['id'])) {
	$seller_id		= $_SESSION[DF_session_key][DF_seller_admin_session]['id'];
	$seller_pass	= $_SESSION[DF_session_key][DF_seller_admin_session]['password'];
}

// ログインチェック
if (empty($seller_id)) {
	header('Location: /outlet/valeur/admin/login.php');
	exit;
}

$seller_valuer = $c_seller->F_check_login($seller_id);

if(isset($seller_valuer) && !empty($seller_valuer)){
	$_SESSION[DF_session_key][DF_seller_admin_session]['id'] = $seller_valuer['valeur_id'];
	$_SESSION[DF_session_key][DF_seller_admin_session]['shop_name'] = $seller_valuer['valeur_coname'];
	// $_SESSION[DF_session_key][DF_seller_admin_session]['password'] = $seller_valuer['password'];
	$_SESSION[DF_session_key][DF_seller_admin_session]['valeur_tantou'] = $seller_valuer['valeur_tantou'];

	// 商品登録申請に遷移
	header('Location: /outlet/valeur/seller/itemreg.php');
	exit;
}else{
	// 出店社ログイン画面に遷移
	header('Location: /outlet/valeur/admin/login.php');
	exit;
}

//関数----------------------------------------------

?>


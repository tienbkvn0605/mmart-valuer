<?php
/*****************************************
バルル出品社ログイン画面
2024/02/01		ナム		【開1-23-0021】バルル委託販売機能作成
******************************************/
session_start();
// DBオブジェクト実体化
require('/var/php_class/class_dbi.php');
$c_dbi = new G_class_dbi;

// DB
$table_arr = array();
$table_arr['valeur_seller_outlet']	= 'mmart_uriba.valeur_seller_outlet';	// バルル出品社情報
$db_name = 'mmart_uriba';
// 値受け取り
$p_type = '';	// 種別（login or logout）
isset($_REQUEST['p_type']) && $p_type = $_REQUEST['p_type'];

$p_id = '';		// 出品社ID
isset($_POST['p_id']) && $p_id = $_POST['p_id'];

$p_pass = '';	// 出品社パスワード
isset($_POST['p_pass']) && $p_pass = $_POST['p_pass'];

$p_kind = '';   //スマホアプリ用の追加パラメータ
isset($_POST['p_kind']) && $p_kind = $_POST['p_kind'];

$show_mess = false;

//定数
define('DF_session_key', 'valeur');
define('DF_seller_admin_session', 'seller_admin');
define('DF_site_name', 'バルル出品社');


// ログアウト
if ($p_type == 'logout') {
	unset($_SESSION[DF_session_key][DF_seller_admin_session]['id']);
	unset($_SESSION[DF_session_key][DF_seller_admin_session]['password']);
	if (isset($_SESSION['SELLER'])) {
		unset($_SESSION['SELLER']);
	}

// ログイン
} else {
	// セッションにIDがある時は、管理画面にリダイレクト
	if (isset($_SESSION[DF_session_key][DF_seller_admin_session]['id'])) {
		$seller_id = ($_SESSION[DF_session_key][DF_seller_admin_session]['id']);
		$seller_valuer = F_get_valeur_seller($seller_id);
		if(!empty($seller_valuer)){
			header('Location: /outlet/valeur/seller/itemreg.php');
			exit;
		}
		
	}

	// ログインチェック
	if ($p_id && $p_pass){
		$seller_outlet = F_get_valeur_seller($p_id, $p_pass);	// 出品社データ取得
		
		if ($seller_outlet == false){
			$show_mess = true;
		} else {
			
			$_SESSION[DF_session_key][DF_seller_admin_session]['id']	= $p_id;
			$_SESSION[DF_session_key][DF_seller_admin_session]['password']	= $p_pass;
			$show_mess = false;
			header('Location: /outlet/valeur/seller/itemreg.php');
			exit;
		}
	}
}

//関数---------------------------------------------

/**
 * 出品社データ取得
 *
 * @param	string	$f_id
 * @param	string	$f_pass
 *
 * @return	array
 */
function F_get_valeur_seller($f_id, $f_pass=""){
	global $c_dbi, $table_arr, $db_name;
	
	$c_dbi->DB_on($db_name);
	
	$f_condition_pass = '';
	if(!empty($f_pass)){
		$f_condition_pass = sprintf(' AND t1.valeur_pass = %1$s', $c_dbi->DB_qq($f_pass) );
	}
	$sql = sprintf('SELECT t1.valeur_coname, t1.valeur_id, t1.valeur_mail, t1.valeur_tantou
			,t1.valeur_kakunin_flg, t1.day_debut
		FROM %1$s AS t1
		WHERE 
			BINARY(t1.valeur_id) = %2$s 
			%3$s
			AND t1.day_debut IS NOT NULL 
			AND t1.valeur_kakunin_flg = 1
			AND t1.valeur_kakunin_date IS NOT NULL;'
		, $table_arr['valeur_seller_outlet']
		, $c_dbi->DB_qq($f_id)
		, $f_condition_pass
	);
	
	mysqli_set_charset($c_dbi->G_DB, 'utf8');

	$res = $c_dbi->DB_exec($sql);
	!$res && die(mb_convert_encoding('ログインチェックエラー#', 'sjis', 'utf-8' ).__LINE__);
	$row = mysqli_fetch_array($res, MYSQLI_ASSOC);
	
	return $row;
}

include_once('/var/www/html3/outlet/valeur/admin/tpl/tpl_login.php');


?>

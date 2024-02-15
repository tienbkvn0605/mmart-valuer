<?php
/**
 * バルル出品社受注一覧ページ
 */

include_once('/var/www/html3/outlet/valeur/lib/config.php');
include_once('/var/www/html3/outlet/valeur/lib/order.php');
include_once('/var/www/html3/outlet/valeur/lib/mail.php');
header("Content-type: text/html; charset=UTF-8");

$c_seller = new Seller();
$c_order = new Order();
$c_mail = new Mail();
$A_payment = [
	0 => "代金引",
	1 => "カード決済",
	2 => "大量購入のその他",
	3 => "Mコイン",
	4 => "銀行振込"
];
//出品社管理ページ経由id
$A_seller=[];
$S_id = '';
$action = '';
$p_kind = "top";
$order_serial = NULL;
$kind = "";
if(isset($_GET["p_kind"]) && $p_kind = $_GET["p_kind"]);
if(isset($_POST["no"]) && $order_serial = $_POST["order_serial"]);
if(isset($_REQUEST["action"]) && $action = $_REQUEST["action"]);
if(isset($_REQUEST["kind"]) && $kind = $_REQUEST["kind"]);


if (isset($_SESSION[DF_session_key][DF_seller_admin_session]['id'])) {
	$S_id = trim($_SESSION[DF_session_key][DF_seller_admin_session]['id']);
}
if(empty($S_id)){
	header('Location: '.'https://'.$_SERVER['HTTP_HOST'].'/outlet/valeur/admin/index.php');
	exit;
}
$A_seller = $c_seller->F_check_login($S_id);
if(empty($A_seller) || empty($A_seller['day_debut']) || ($A_seller['valeur_kakunin_flg'] == 0)){
	header('Location: '.'https://'.$_SERVER['HTTP_HOST'].'/outlet/valeur/admin/index.php');
	exit;
}

//銀行口座情報
$bank = $c_seller->get_seller_bank_info($S_id);

if($action == "add_mail_info"){
	$post = $_POST;
	$post["takuhai_gyosya_name"] = $c_seller->Fcv($post["takuhai_gyosya_name"],"en");
	$post["bin_type"] = $c_seller->Fcv($post["bin_type"],"en");
	// $c_order->F_setmail_info($post);
	exit;
}
// 出品社の銀行口座情報取得
if($kind == 'show_bank_info' ){
	if(empty($bank['bank_info'])){
		$bank['bank_info'] = 'この度は、ご注文頂きまして有難うございます。
　下記口座に『ご請求総額 ●●●円』をお振込下さい。お振込確認後、発送致します。
　【金融機関名】：
　【支　店　名】：
　【口座番号】　：
　【預金種別】　：
　【口座名義人】：
　※お振込手数料は貴社ご負担でお願いします。';
	}
	echo ':r:OK:r:'.json_encode($bank['bank_info']).':r:';
	exit;
}

// 出品社の銀行口座情報処理
else if($kind == 'bank_info_reg' ){
	if(isset($_POST['bank_content']) && $_POST['bank_content']){
		$c_seller->set_seller_bank_info($_POST['bank_content'], $S_id);
		echo '<script>
			alert("銀行口座情報を登録しました。");
			location.href = "/outlet/valeur/seller/order_list.php";
		</script>';
		exit;
	}
}

if($p_kind == "top"){
    // require_once('/var/www/html3/outlet/valeur/seller/tpl/tpl_list_item.php');
	// header('Location: '.'https://'.$_SERVER['HTTP_HOST'].'/outlet/valeur/seller/list_item.php');
    require_once('/var/www/html3/outlet/valeur/seller/tpl/tpl_juchu_ichiran.php');
	exit;
}





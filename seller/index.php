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

//出品社管理ページ経由id
$A_seller=[];
$S_id = '';
$action = '';
$button_type = '';
if(isset($_REQUEST["action"]) && $action = $_REQUEST["action"]);
if(isset($_REQUEST["button_type"]) && $button_type = $_REQUEST["button_type"]);

$p_kind = "top";

if(isset($_GET["p_kind"]) && $p_kind = $_GET["p_kind"]);

if (isset($_SESSION[DF_session_key][DF_seller_admin_session]['id'])) {
	$S_id = trim($_SESSION[DF_session_key][DF_seller_admin_session]['id']);
}
if(empty($S_id)){
	header('Location: '.'https://'.$_SERVER['HTTP_HOST'].'/outlet/valeur/admin/index.php');
	exit;
}
if($action == "add_mail_info"){
	$post = $_POST;
	$post["takuhai_gyosya_name"] = $c_seller->Fcv($post["takuhai_gyosya_name"],"en");
	$post["bin_type"] = $c_seller->Fcv($post["bin_type"],"en");
	// $c_order->F_setmail_info($post);
	exit;
}
if($action == "delete_mail"){
	$order_mail_serial = $_POST["order_mail_serial"];
	$c_mail->update_delete_mail($order_mail_serial);
	// header('Location: '.'https://'.$_SERVER['HTTP_HOST'].'/outlet/valeur/seller/index.php?p_kind=mailbox');
	exit;
}
if($action == "readed_mail"){
	$order_mail_serial = $_POST["order_mail_serial"];
	$c_mail->update_readed_mail($order_mail_serial);
	// header('Location: '.'https://'.$_SERVER['HTTP_HOST'].'/outlet/valeur/seller/index.php?p_kind=mailbox');
	exit;
}

$A_seller = $c_seller->F_check_login($S_id);
if(empty($A_seller) || empty($A_seller['day_debut']) || ($A_seller['valeur_kakunin_flg'] == 0)){
	header('Location: '.'https://'.$_SERVER['HTTP_HOST'].'/outlet/valeur/admin/index.php');
	exit;
}
if($button_type == "sendmail"){
	$data = [
		"order_serial" => $_REQUEST["order_serial"],
		"subject" => $_REQUEST["titleName"],
		"honbun" => $_REQUEST["messageText"],
		"frm_name" => "valeurtest",
		"frm_add" => "valeurtest",
		"to_add" => "namtest",
	];
	// $c_mail->seller_sendmail($data);
	exit;
}

if($p_kind == "mailbox"){
	$header_title = "注文関連メール";
	$A_mail = $c_mail->get_mail_seller($S_id);
    require_once('/var/www/html3/outlet/valeur/seller/tpl/tpl_mailbox.php');
	exit;
}
if($p_kind == "top"){
    // require_once('/var/www/html3/outlet/valeur/seller/tpl/tpl_list_item.php');
	header('Location: '.'https://'.$_SERVER['HTTP_HOST'].'/outlet/valeur/seller/list_item.php');
	exit;
}

if($p_kind == "juchu"){
	$header_title = '受注一覧管理';
    require_once('/var/www/html3/outlet/valeur/seller/tpl/tpl_juchu_ichiran.php');
	exit;
}



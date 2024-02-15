<?php
/**
 * 出品社の受注情報取得
 * 2024/02/08       開1　23-0021】バルル委託販売機能作成
 */
include_once('/var/www/html3/outlet/valeur/lib/config.php');
$c_seller = new Seller();
$order = new Order();

$S_id = '';
if (isset($_SESSION[DF_session_key][DF_seller_admin_session]['id'])) {
	$S_id = trim($_SESSION[DF_session_key][DF_seller_admin_session]['id']);
}
if(empty($S_id)){
	header('Location: '.'https://'.$_SERVER['HTTP_HOST'].'/outlet/valeur/admin/index.php');
	exit;
}
$p_kind = "top";
if(isset($_GET["p_kind"]) && $p_kind = $_GET["p_kind"]);
if($p_kind == "juchu"){
    $A_list =  $order->get_all_order($S_id);
    echo json_encode($A_list);
    exit;
}
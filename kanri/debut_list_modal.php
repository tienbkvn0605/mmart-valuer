<?php
require_once("/var/www/html3/outlet/valeur/lib/config.php");
require_once('/var/php_class/class_dbi.php');
//DBオブジェクト実体化
$c_dbi=new G_class_dbi;
$c_item = new Item();
//出品社管理ページ経由id
$S_id = '';
if (isset($_SESSION[DF_session_key][DF_seller_admin_session]['id'])) {
	$S_id = trim($_SESSION[DF_session_key][DF_seller_admin_session]['id']);
}
$item_serial = "";
if(isset($_REQUEST["f_serial"]) && $item_serial = $_REQUEST["f_serial"]);
if(isset($_REQUEST["log_type"]) && $_REQUEST["log_type"] == 'kanri'){
    $item_detail = $c_item->get_item_info($item_serial);
    echo json_encode($item_detail);
    exit;
}
if(!empty($item_serial)){
    if(!empty($S_id)){
        $item_detail = $c_item->get_item_info($item_serial, $S_id);
    }else{
        $item_detail = $c_item->get_item_info($item_serial);
    }
    echo json_encode($item_detail);
    exit;
}

function Fcv($text,$type="ja"){
    $res = "";
    if($type=="ja"){
        $res = mb_convert_encoding($text, "UTF-8", "SJIS");
    }else{
        $res = mb_convert_encoding($text, "SJIS", "UTF-8");
    }
    return $res;
}
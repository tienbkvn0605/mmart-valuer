<?php
require_once('/var/www/html3/outlet/valeur/lib/seller.php');
require_once('/var/www/html3/outlet/valeur/lib/config.php');

$seller = new Seller;

$FL_shacho = false; //
$FL_edit = false;
$FL_login = false;
$FL_kanri = false;

//ログインチェック
if (isset($_SESSION['ID'])) {
	$FL_login = true;
	$login_staff = '管理者：'.$seller->Fcv($_SESSION["LOGIN_USER"]);
	$FL_kanri = true;
    $FL_edit = true;
}

if (isset($_SESSION['pay_kanri']) && $_SESSION['pay_kanri']=='kanri') {
	$FL_login = true;
    $FL_shacho = true;
	$FL_kanri = true;
	$login_staff = $seller->Fcv($_SESSION['LOGIN_USER']);
}

if (!$FL_login) {
	die($seller->Fcv('<br>表示権限エラー<br><br>',"en"));
	$error_msg = '権限エラー';
}


$total_records = $seller->F_count_seller();

$mode = "";
$search_val = "";
$sql_con = "";
if(isset($_REQUEST["edit_type"]) && $mode = $_REQUEST["edit_type"]);
if(isset($_REQUEST["search_val"]) && $search_val = trim($_REQUEST["search_val"]));
if(!empty($search_val)){
    $search_val = $seller->Fcv($search_val,"en");
    $sql_con = "AND `out_coname` LIKE '%".$search_val."%'";
}

$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 500;
$total_page = ceil($total_records / $limit);
if ($current_page > $total_page){
    $current_page = $total_page;
}
else if ($current_page < 1){
    $current_page = 1;
}
$start= 1;
$start = ($current_page - 1) * $limit;
$A_seller = $seller->F_get_all_seller($start, $limit,$sql_con);
$A_seller = $seller->Fcv($A_seller);

if($mode == "resign"){
    $serial = $_REQUEST["f_serial"];
    $valeur_listed = $_REQUEST["f_listed"];
    $valeur_capital = $_REQUEST["f_capital"];
    $valeur_annual_sales = $_REQUEST["f_annual_sales"];

    $insert_data = [
        "serial" => $serial,
        "valeur_listed" => $valeur_listed,
        "valeur_capital" => $valeur_capital,
        "valeur_annual_sales" => $valeur_annual_sales,
    ];

    $seller->F_insert_seller($insert_data);
}
require_once('/var/www/html3/outlet/valeur/kanri/tpl/tpl_seller_all.php');
?>
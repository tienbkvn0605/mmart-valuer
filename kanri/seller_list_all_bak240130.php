<?php
require_once('/var/www/html3/outlet/valeur/lib/seller.php');

$seller = new Seller;

$A_seller = $seller->F_get_all_seller();
$A_seller = $seller->Fcv($A_seller);

$mode = "";
if(isset($_REQUEST["edit_type"]) && $mode = $_REQUEST["edit_type"]);

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
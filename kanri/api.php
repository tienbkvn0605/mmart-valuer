<?php
require_once('/var/www/html3/outlet/valeur/lib/seller.php');

$seller = new Seller;

$mode = "";

if(isset($_GET["mode"]) && $mode = $_GET["mode"]);

if($mode == "all"){
    $A_list =  $seller->F_get_all_seller();
    $A_list = $seller->Fcv($A_list);
    echo json_encode($A_list);
    exit;
}
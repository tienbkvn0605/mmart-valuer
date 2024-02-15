<?php
/**
 * バルルの詳細画面対応
 * 
 * 2024-02-09   新規作成    ダット
 */
include_once("/var/www/html3/outlet/valeur/lib/config.php");
include_once('/var/www/html3/outlet/valeur/item/lib/config.php');
include_once('lib/item_detail_helper.php');

$helper = new ItemDetailHelper();

$num = $_GET['num'] ?? null;
$id = $_GET['id'] ?? null;
$type = $_GET['type'] ?? 'buybuyn';
$g_banar = $_GET['bn'] ?? $type;
$g_ichiba = $_GET['ichiba'] ?? null;
$chumon_cate = $_GET['chumon_cate'] ?? '';

if($id != DF_m_data_dat_valeur_id || !is_numeric($num))
{
    header("Location: /");
    exit;
}

$item = $helper->get_item_card_type($id, $num);

// 商品がなければ、TOPページへ移動する
if(empty($item))
{
    header("Location: /");
    exit;
}


$categories = $helper->get_item_categories($id, $num);

$sns_info = $helper->get_sns_button_info($item);

$valeur_info = $helper->get_id_valeur($id, $num);
$region_master = $soryo_info = [];
if($valeur_info){
    $soryo_master = $valeur_info['soryo_master_serial'];
    $valeur_id = $valeur_info['valuer_id'];
    $region_master = $helper->get_region_master();
    $soryo_info = $helper->get_valeur_soryo_info($valeur_id, $soryo_master);
}


// define header/ title

// View
$title = $item['m_item'] . "｜仕入れなら業務用食材卸売市場Mマート";
$description = substr(preg_replace('/<br>/', '', $item['m_setsumei']), 0, 240);
$keyword = implode(',', array_merge($categories['name'], array('業務用','食材','卸売','Mマート')));


include_once 'tpl/tpl_detail.php';
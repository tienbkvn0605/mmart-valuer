<?php
/**
 * バルル出品社　新規出品社登録申請　Mマート担当者行う
 * * 2024-01-22   ティエン    【開1-23-0021】バルル委託販売機能作成
 * 
 */

require_once('/var/www/html3/outlet/valeur/lib/config.php');

$c_seller = new Seller;

$FL_shacho = false; //
$FL_edit = false;
$FL_login = false;
$FL_kanri = false;

//ログインチェック
if (isset($_SESSION['ID'])) {
	$FL_login = true;
	$login_staff = '管理者：'.$c_seller->Fcv($_SESSION["LOGIN_USER"]);
	$FL_kanri = true;
    $FL_edit = true;
}

if (isset($_SESSION['pay_kanri']) && $_SESSION['pay_kanri']=='kanri') {
	$FL_login = true;
    $FL_shacho = true;
	$FL_kanri = true;
	$login_staff = $c_seller->Fcv($_SESSION['LOGIN_USER']);
}
if (!$FL_login && !$FL_kanri) {
	die(mb_convert_encoding('表示権限エラー', 'SJIS', 'auto'));
}
$resign_id = '';
isset($_POST['resign_id']) && $resign_id = $_POST['resign_id'];
$resign_pass = '';
isset($_POST['resign_pass']) && $resign_pass = $_POST['resign_pass'];
$corp = '';
isset($_POST['corp']) && $corp = $_POST['corp'];
$name = '';
isset($_POST['name']) && $name = $_POST['name'];
$zip1 = '';
isset($_POST['zip1']) && $zip1 = $_POST['zip1'];
$zip2 = '';
isset($_POST['zip2']) && $zip2 = $_POST['zip2'];
$address = '';
isset($_POST['address']) && $address = $_POST['address'];
$address_2 = '';
isset($_POST['address_2']) && $address_2 = $_POST['address_2'];
$tel = '';
isset($_POST['tel']) && $tel = $_POST['tel'];
$mail = '';
isset($_POST['mail']) && $mail = $_POST['mail'];
$item = '';
isset($_POST['item']) && $item = $_POST['item'];
$listed = 0;
isset($_POST['listed']) && $listed = $_POST['listed'];

$capital = '';
isset($_POST['capital']) && $capital = $_POST['capital'];
$annual_sales = '';
isset($_POST['annual_sales']) && $annual_sales = $_POST['annual_sales'];

if(isset($_POST['p_kind']) && $_POST['p_kind'] == 'id_reg_check'){
	$p_id = $_POST['id'];
	$K_m = $c_seller -> F_check_id('dami2.seller_mmart','m_id',$p_id);
	$K_mm_open = $c_seller -> F_check_id('dami2.seller_master','id',$p_id,'site','m','open');
	$K_mo = $c_seller -> F_check_id('dami2.seller_mmart_old','m_id',$p_id);
	$K_mm_close = $c_seller -> F_check_id('dami2.seller_master','id',$p_id,'site','m','close');
	$K_o = $c_seller -> F_check_id('dami2.seller_outlet','out_id',$p_id);
	$k_oo = $c_seller -> F_check_id('dami2.seller_outlet_t','out_id',$p_id);
	$k_va = $c_seller -> F_check_id('mmart_uriba.valeur_seller_outlet','valeur_id',$p_id);

	if($K_m == 0 && $K_mm_open == 0 && $K_mo == 0 
	&& $K_mm_close == 0 && $K_o == 0 &&$k_oo == 0 && $k_va == 0){
		echo ':r:OK:r:';
		exit;
	}else{
		echo ':r:ERROR:r:';
		exit;
	}
}
require_once('/var/www/html3/outlet/valeur/kanri/tpl/tpl_seller_reg.php');
?>
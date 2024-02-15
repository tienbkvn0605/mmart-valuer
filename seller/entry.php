<?php
/************************************
即売からの売り手登録
2024/01/22	機能作成	ナム	バルル商品登録機能
*************************************/ 
require_once('/var/www/html3/outlet/valeur/lib/config.php');
// メール送信
require_once('/var/www/html3/outlet/valeur/kanri/valeur_sendmail.php');
// DBオブジェクト実体化
$c_seller = new Seller;

$p_kind = 'top';
isset($_REQUEST['p_kind']) && $p_kind = $_REQUEST['p_kind'];

$p_id = '';
isset($_SESSION['outlet_seller_id']) && $p_id = $_SESSION['outlet_seller_id'];

if(empty($p_id)){
	header('Location: '.'https://'.$_SERVER['HTTP_HOST'].'/outlet/admin/index.php');
	exit;
}

if($p_kind=='top'){

	$seller_exist = $c_seller->get_seller_valeur($p_id);

	if(!$seller_exist){
		$_SESSION[DF_session_key][DF_seller_admin_session]["resign_type"] = 0; //申込前
		$resign_type = 0;
	};

	if($seller_exist){

		if($seller_exist["day_debut"]==NULL){
			$_SESSION[DF_session_key][DF_seller_admin_session]["resign_type"] = 1; //審査待ち
			$resign_type = 1;
		}elseif(isset($seller_exist["day_debut"]) && !empty($seller_exist["day_debut"])){
			$_SESSION[DF_session_key][DF_seller_admin_session]["resign_type"] = 2; //承認済み
			$resign_type = 2;
		}

		$_SESSION[DF_session_key][DF_seller_admin_session]['id']=$p_id;
		$_SESSION[DF_session_key][DF_seller_admin_session]['serial']=$seller_exist["serial"];
		$_SESSION[DF_session_key][DF_seller_admin_session]['day_debut']=$seller_exist["day_debut"];
		$_SESSION[DF_session_key][DF_seller_admin_session]['shop_name']=$seller_exist["valeur_coname"];
		if($resign_type == 2){
			header('Location: /outlet/valeur/seller/itemreg.php');
			exit;
		}
		// $url = "entry.php";
		// header('Location: /outlet/valeur/seller/'.$p_page.'.php'.$params);
		// header('Location: /outlet/valeur/seller/entry.php?p_site=outlet&p_page=index');
		// exit;

	}
}elseif($p_kind=='seller_reg'){
	// テスト用
	$data["seller_id"] = $p_id;
	$reg_err  = $c_seller->F_insert_seller($data);
	// テストend
	// $reg_err  = $c_seller->F_insert_seller($p_id);
	//売り手登録
	if($reg_err==true){
		// 登録した情報取得
		$seller_infor = $c_seller->get_seller_valeur($p_id);
		$seller_infor = Fcv($seller_infor);

			// メールテンプレートを準備する
		// 置換対象設定
		$replacements = [
			'{{seller_shop}}' => $seller_infor["valeur_coname"],
			'{{seller_tantou}}' => $seller_infor["valeur_tantou"],
			'{{sys_title}}' => DF_site_name,
		];
		// メールテンプレートを取得
		$mail_tpl = null;
		$mail_tpl = file_get_contents('../kanri/tpl/tpl_sendmail_resign_thank.txt', true);
		$mail_tpl = str_replace(array_keys($replacements), array_values($replacements), $mail_tpl);
		$mail_tpl = Fcv($mail_tpl, "en");

		$f_set_values = [
			'order_serial' => 0,
			'seller_id' => $p_id,
			'buyer_id' => "",
			'kind' => DF_mail_seller_reg,
			'title' => Fcv("バルルにご登録ありがとうございます。","en"),
			'maildata' => $mail_tpl,
		];
		// F_insert_seller_out_mail($f_set_values);
		// email送信
		$path = '../kanri/tpl/tpl_sendmail_resign_thank.txt';
		$data = [
			"valeur_coname" => $seller_infor["valeur_coname"],
			"valeur_tantou" => $seller_infor["valeur_tantou"],
			"valeur_mail" => $seller_infor["valeur_mail"],
			"sys_title" => DF_site_name,
			"subject" => "バルルにご登録ありがとうございます。"
			];
		// sendmail_email_signup($data, $path);
		// ホームページに戻り
		$redirect_url="https://".$_SERVER['HTTP_HOST']."/outlet/admin/index.php";
		header('Location: '.$redirect_url);
		exit;
	}

	//エラーの場合
	if($reg_err==false){
		echo ("エラーが発生しました！");
		echo mb_convert_encoding('ID情報エラーです、<a href="../">管理ページリンク</a>よりもう一度このページを開いてください<br/>',"UTF-8","SJIS");
		exit;
	}
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
include_once('./tpl/tpl_seller_agree.php');
exit;
//関数----------------------------------------------

?>


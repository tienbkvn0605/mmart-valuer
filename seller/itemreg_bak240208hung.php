<?php
/**
 * 勝手に売上創る商品登録
 * 2024/01/22   ナム    バルル委託販売機能作成
 */

include_once('/var/www/html3/outlet/valeur/lib/config.php');

// 商品のインスタンス生成
$c_item = new Item();
$c_seller = new Seller();
//MAILオブジェクト実体化
require_once('/var/php_class/class_mail.php');
$c_mail = new G_class_mail;

//ログインチェック開始-----------------------------------------------

//出店者情報取得
$A_seller = array();

//出品社管理ページ経由id
$S_id = '';
if (isset($_SESSION[DF_session_key][DF_seller_admin_session]['id'])) {
	$S_id = trim($_SESSION[DF_session_key][DF_seller_admin_session]['id']);
}
if(empty($S_id)){
	header('Location: '.'https://'.$_SERVER['HTTP_HOST'].'/outlet/valeur/admin/index.php');
	exit;
}

$A_seller = $c_seller->get_seller_valeur($S_id);
if(empty($A_seller) || empty($A_seller['day_debut']) || ($A_seller['valeur_kakunin_flg'] == 0)){
	header('Location: '.'https://'.$_SERVER['HTTP_HOST'].'/outlet/valeur/admin/index.php');
	exit;
}
//ログインチェック終了-----------------------------------------------

$p_kind = 'reg';
isset($_REQUEST['p_kind']) && $p_kind = $_REQUEST['p_kind'];

// 全て配送料表情報取得
$soryo_arr = $c_item->get_all_soryo_table($S_id);

// 全て休業日表情報取得
$holiday_arr = $c_item->get_all_holiday($S_id);

$A_region = $c_item->get_region_master();

// ヘッダーのタイトル
$header_title = 'バルル商品登録申請';
// 商品情報入力
if($p_kind === 'reg'){
	
	$item_data = [];
	if(isset($_POST['cate1no']) && !empty($_POST['cate1no'])){
		$item_data = $_POST;
		
	}
	
	// 画像
	$A_gazo = [
		'new_pic' => ''
		, 'new_pic2' => ''
		, 'new_pic3' => ''
		, 'new_pic4' => ''
		, 'new_pic5' => ''
		, 'new_pic6' => ''
		, 'new_pic7' => ''
	];
	foreach ($A_gazo as $key => $gazo) {
		if(isset($item_data[$key]) && !empty($item_data[$key])){
			$A_gazo[$key] = '<img src="'.DF_f_pic_fold.$item_data[$key].'" style="max-width: 600px"><br>';
		}
	}
	// 第一カテゴリー取得
	$A_cate = $c_item->get_cate1_all();
	
    // テンプレート
	
    include_once('/var/www/html3/outlet/valeur/seller/tpl/tpl_itemreg.php');
}
// 商品情報確認
else if ($p_kind === 'item_register_kakunin'){
	
	$item_data = $_POST;	
	$f_calendar_arr = array_filter($holiday_arr, function($v) {
		return $v['serial'] == $_POST['select_holiday_table'];
	}, ARRAY_FILTER_USE_BOTH);
	
	// カテゴリー
	$A_cate = $c_item->get_cate1_all();
	if(isset($item_data['cate1no'])){
		$item_data['cate1_text'] = array_flip($A_cate)[$item_data['cate1no']];
		$A_cate2 = $c_item->get_cate2_by_serial($_POST['cate1no']);

		if(isset($item_data['cate2no']) && !empty($A_cate2)){
			$item_data['cate2_text'] = $A_cate2[$item_data['cate2no']];
			$A_cate3 = $c_item->get_cate3_by_serial($_POST['cate1no'], $_POST['cate2no']);

			if(isset($item_data['cate3no']) && !empty($A_cate3)){
				$item_data['cate3_text'] = $A_cate2[$item_data['cate3no']];
				$A_cate4 = $c_item->get_cate4_by_serial($_POST['cate1no'], $_POST['cate2no'], $_POST['cate3no']);
				
				if(isset($item_data['cate4no']) && !empty($A_cate4)){
					$item_data['cate4_text'] = $A_cate4[$item_data['cate4no']];
				}
				
				if($item_data['cate1no'] == 1 && $item_data['cate2no'] == 1 && $item_data['cate3no'] == 3){
					$item_data['cate5_text'] = $item_data['cate5no'];
				}
			}	
		}
	}

	// 記載期限
	$f_displimit = '';
	$displimit_style = 'style="display: none"';
	if(isset($item_data['m_disp_limit_y']) && !empty($item_data['m_disp_limit_y']) 
	&& isset($item_data['m_disp_limit_m']) && !empty($item_data['m_disp_limit_m']) 
	&& isset($item_data['m_disp_limit_d']) && !empty($item_data['m_disp_limit_d']) 
	&& isset($item_data['m_disp_limit_h']) && !empty($item_data['m_disp_limit_h']) ){
		$f_displimit = $item_data['m_disp_limit_y'].'年'.$item_data['m_disp_limit_m'].'月'.$item_data['m_disp_limit_d'].'日'.$item_data['m_disp_limit_h'].'時まで';
		$displimit_style = 'style=""';
	}
	
	// 画像
	$f_path = DF_pic_upload;
	// 画像が存在するかをチェック
	$A_gazo = [
		'gazo' => 'new_pic'
	, 'gazo2' => 'new_pic2'
	, 'gazo3'=> 'new_pic3'
	, 'gazo4'=> 'new_pic4'
	, 'gazo5'=> 'new_pic5'
	, 'gazo6'=> 'new_pic6'
	, 'gazo7'=> 'new_pic7'];
	foreach ($A_gazo as $key => $name) {
		if(isset($_REQUEST[$key]) && !empty($_REQUEST[$key])){
			$item_data[$name] = $_REQUEST[$key];
		}
	}
	
	//■===========新規登録実行
	if(isset($_REQUEST['new_pic_resize']) && !isset($item_data['new_pic'])){
		// 拡張子取得
		$image_base64 = preg_replace('/data:(.+)?base64,/', '', $_REQUEST['new_pic_resize']);

		// $f_path = '/var/www/html3/'.$S_id.'/ireg/tmp/';	// 保存先ディレクトリ
		$filename = $S_id.'_'.date('YmdHis').'.jpg';	// 画像ファイル名 = DB
		file_put_contents( $f_path.$filename, base64_decode($image_base64) ) ;

		$item_data['new_pic'] = $filename;
	}
	//■===========新規別画像登録実行(2～6枚目)
	for ($i=1; $i <= 6; $i++) { 
		if(isset($_REQUEST['new_pic'.$i.'_resize']) && !isset($item_data['new_pic'.$i])){
			// 拡張子取得
			$image_base64 = preg_replace('/data:(.+)?base64,/', '', $_REQUEST['new_pic'.$i.'_resize']);

			// $f_path = '/var/www/html3/'.$S_id.'/ireg/tmp/';	// 保存先ディレクトリ
			$filename = $S_id.'_pic'.$i.'_'.date('YmdHis').'.jpg';	// 画像ファイル名 = DB
			file_put_contents( $f_path.$filename, base64_decode($image_base64) ) ;

			$item_data['new_pic'.$i] = $filename;
		}
	}
	//■===========栄養画像新規登録実行
	if(isset($_REQUEST['new_pic7_resize']) && !isset($item_data['new_pic7'])){
		// 拡張子取得
		$image_base64 = preg_replace('/data:(.+)?base64,/', '', $_REQUEST['new_pic7_resize']);

		// $f_path = '/var/www/html3/'.$S_id.'/ireg/tmp/';	// 保存先ディレクトリ
		$filename = $S_id.'_pic_eiyo_'.date('YmdHis').'.jpg';	// 画像ファイル名 = DB
		file_put_contents( $f_path.$filename, base64_decode($image_base64) ) ;

		$item_data['new_pic7'] = $filename;
	}

	
	include_once('/var/www/html3/outlet/valeur/seller/tpl/tpl_itemreg_kakunin.php');
	exit;
}
// 商品情報登録を処理
else if ($p_kind === 'item_register_run') {
	
	$A_pval_notag = $_POST;
	foreach( $config['A_tagkey'] AS $ky=>$vl ){
		$A_pval_notag[$vl]=preg_replace('/</','&lt;',$A_pval_notag[$vl]) ;
		$A_pval_notag[$vl]=preg_replace('/>/','&gt;',$A_pval_notag[$vl]) ;
		
		$A_pval_notag[$vl]=preg_replace('/http[:\/a-zA-Z0-9\?=\-\.\%\&]+/','',$A_pval_notag[$vl]) ;	// HTML疑い
		$A_pval_notag[$vl]=preg_replace('/([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+\.([a-zA-Z0-9\._-]+)+/','',$A_pval_notag[$vl]) ;	// メアド疑い
	}
	
	$c_item -> set_item_new_valeur($S_id,$A_pval_notag);	//商品DB登録、シリアル取得
	

	// メール送信
	$subject = '【Mマート市場】商品登録申請完了の件';
	$subject = mb_convert_encoding($subject, 'sjis', 'utf-8');
	//メール送信
	$mail_str = '';
	$mail_data = [
		'item' 	 		=> $A_pval_notag["item"],
		'valeur_coname' => mb_convert_encoding($A_seller["valeur_coname"], 'sjis', 'utf-8'),
		'valeur_tantou' => mb_convert_encoding($A_seller["valeur_tantou"], 'sjis', 'utf-8'),
		'valeur_mail'   => $A_seller["valeur_mail"],
		'valeur_id'     => $A_seller["valeur_id"],
	];
	$A_seller['item'] = $A_pval_notag["item"];
	$mail_body = item_debut_shinsei_mail_body($A_seller);
	//メール送信処理
	$mail_body = mb_convert_encoding($mail_body, 'sjis', 'utf-8');
	$mail_str = send_mail_item_regist($c_mail, $mail_data, $mail_body, $subject);


	// 売り手宛メールをDBに格納
	 //メール本文
	
	 $maildata = sprintf($mail_body
	 , mb_convert_encoding($A_seller['valeur_coname'], 'UTF-8', 'sjis')  //1
	 , mb_convert_encoding($A_seller['valeur_tantou'], 'UTF-8', 'sjis')  //2
	 , $item = '■'.$A_pval_notag['item']     //3
	 );
	
	$set_values = array(
		'order_serial'	=> 0,
		'seller_id'		=> $S_id,
		'buyer_id'		=> '',
		'kind'			=> DF_mail_item_debut_shinsei,
		'title'			=> $subject,
		'maildata'		=> $maildata,
	);

	//情報本登録の売り手の場合
	$insert_mail_serial = $c_item->insert_seller_out_mail($set_values);
	if(empty($insert_mail_serial)) {
		$ret_str = 'NG';
	}

	if ($mail_str === 'NG') {
		echo 'NG';
		exit;
	}

	header('Location: /outlet/valeur/seller/list_item.php');
	exit;
}
// 第二カテゴリー取得
else if($p_kind == 'get_category_2'){
	if(isset($_POST['cate1_serial'])){
		$A_cate2 = $c_item->get_cate2_by_serial($_POST['cate1_serial']);
		echo ':r:OK:r:'.json_encode(mb_convert_encoding($A_cate2, 'UTF-8', 'auto')).':r:';
		exit;
	}
	echo 'error';
	exit;
}
// 第三カテゴリー取得
else if($p_kind == 'get_category_3'){
	if(isset($_POST['cate1_serial']) && isset($_POST['cate2_serial'])){
		$A_cate3 = $c_item->get_cate3_by_serial($_POST['cate1_serial'], $_POST['cate2_serial']);
		echo ':r:OK:r:'.json_encode(mb_convert_encoding($A_cate3, 'UTF-8', 'auto')).':r:';
		exit;
	}
	echo 'error';
	exit;
}
// 第四カテゴリー取得
else if($p_kind == 'get_category_4'){
	if(isset($_POST['cate1_serial']) && isset($_POST['cate2_serial']) && isset($_POST['cate3_serial'])){
		$res_cate = [];
		
		// 第三カテゴリ：国産牛肉11
		$A_shubetsu = [];
		if($_POST['cate1_serial'] == 1 && $_POST['cate2_serial'] == 1 && $_POST['cate3_serial'] == 3){
			$A_shubetsu = $config['G_cate5_arr'];
		}
		$A_cate4 = $c_item->get_cate4_by_serial($_POST['cate1_serial'], $_POST['cate2_serial'], $_POST['cate3_serial']);
		
		if(count($A_cate4) > 0){
			if(count($A_shubetsu) > 0){
				$res_cate = [
					'cate4' => $A_cate4,
					'shubetsu' => $A_shubetsu,
				];
			}else{
				$res_cate = ['cate4' => $A_cate4];
			}
			echo ':r:OK:r:'.json_encode(mb_convert_encoding($res_cate, 'UTF-8', 'auto')).':r:';
			exit;
		}else{
			echo 'error';
			exit;
		}
	}
	echo 'error';
	exit;
}
// 商品名存在しているかチェック
else if($p_kind == 'item_register_check'){
	// 同じ商品名かをチェック
	$f_name_check = $c_item->get_sameitemcount($S_id, $_POST['item']);
	if( ((int)$f_name_check == 0) ){		//	登録商品数の上限をチェック
		echo 'REGISTER_OK';
	}elseif((int)$f_name_check != 0){
		echo 'NAME_ERROR';
	}
	exit;	
}

?>
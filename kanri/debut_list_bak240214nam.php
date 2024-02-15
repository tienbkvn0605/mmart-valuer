<?php
/**
* 商品に関するクラス
* 2024-01-22   tien   【開1-23-0021】バルル委託販売機能作成
*/

require_once('/var/php_class/class_dbi.php');
//DBオブジェクト実体化
$c_dbi=new G_class_dbi;

require_once('/var/www/html3/outlet/valeur/kanri/valeur_sendmail.php');
require_once('/var/www/html3/outlet/valeur/lib/config.php');

//商品処理クラス
$c_item = new Item;

//権限チェック
$FL_shacho = false; //
$FL_edit = false;
$FL_login = false;
$FL_kanri = false;

//ログインチェック
if (isset($_SESSION['ID']) && $_SESSION['ID']== 276) {
	$FL_login = true;
	$login_staff = '管理者：'.Fcv($_SESSION["LOGIN_USER"]);
	$FL_kanri = true;
    $FL_edit = true;
}

if (isset($_SESSION['pay_kanri']) && $_SESSION['pay_kanri']=='kanri') {
	$FL_login = true;
    $FL_shacho = true;
	$FL_kanri = true;
    $FL_edit = false;
	$login_staff = Fcv($_SESSION['LOGIN_USER']);
}

if (!$FL_login && !$FL_kanri) {
	die(Fcv('<br>表示権限エラー<br><br>',"en"));
	$error_msg = '権限エラー';
}

// 変数宣言
$empty_item = "商品がありません。";
$DF_uriba = "バルル";

$A_item_type = [];
$A_item_type = [
    0 => "承認待ち",
    1 => "承認済み",
    2 => "保留"
];

$A_item = F_get_item();

$button_type = "";
$mode = "";
if(isset($_REQUEST["button_type"]) && $button_type = $_REQUEST["button_type"]);
if(isset($_REQUEST["mode"]) && $mode = $_REQUEST["mode"]);

if($button_type == "kakunin"){
    $item_serial = $_REQUEST["f_serial"];
    F_kakunin($item_serial);
}
$item_detail = [];
if($mode == "detail"){
    $item_serial = $_REQUEST["f_serial"];
    // $item_detail = F_get_one_item($item_serial);
    // $item_detail = Fcv($item_detail);
    // echo json_encode($item_detail);
}
$senmail_item = "";
if($button_type == "henshin"){
    $item_serial = $_REQUEST["f_serial"];
    $message = Fcv($_REQUEST["message"],"en");
    $senmail_item = F_henshin($message, $item_serial);
    $path = "tpl/tpl_sendmail_review.txt";
    // mailbox
    $data = [
        "valeur_coname" =>$senmail_item["valeur_coname"],
        "valeur_tantou" =>$senmail_item["valeur_tantou"],
        "item_name"     =>$senmail_item["m_item"],
        "message"       =>$senmail_item["review_message"],
        "sys_title"     =>DF_site_name
    ];
    $mail_tpl = F_getmail_tpl($path, $data);

    $data_insert = [
        'order_serial' => 0,
        'seller_id' => $senmail_item["m_id"],
        'buyer_id' => "",
        'kind' => DF_mail_seller_reg,
        'title' => Fcv("バルルにご登録ありがとうございます。","en"),
        'maildata' => $mail_tpl
    ];
    // F_insert_seller_out_mail($data_insert);
    // email send
    // sendmail_review_valeur($senmail_item, $path);
}
if($button_type == "complete-item"){
    $valeur_ai_serial = $_REQUEST["ai_serial"];

    // dami2.m_data_datにインサート
    list($m_data_dat_ai_serial, $m_serial) = $c_item->set_item_m_data_data($valeur_ai_serial);
    if($m_data_dat_ai_serial > 0){

        // mmart_uriba.valeur_m_data_datのm_data_data_ai_serialを更新します。
        $c_item->update_valeur_m_data_data($valeur_ai_serial, $m_data_dat_ai_serial);

        // バルル商品情報
        $item_info = $c_item -> get_item_info($valeur_ai_serial);
     
        // メール送る
        $path = "tpl/tpl_sendmail_complete_item.txt";
        // mailbox
        $data = [
            "valeur_coname" =>$item_info["valeur_coname"],
            "valeur_tantou" =>$item_info["valeur_tantou"],
            "item_name"     =>$item_info["m_item"],
            "item_url"     =>'https://'.$_SERVER['HTTP_HOST'].'/search/item.php?type=buybuyc&id=valeur&num='.$m_serial.'',
            "sys_title"     =>DF_site_name
        ];
        $mail_tpl = F_getmail_tpl($path, $data);

        $data_insert = [
            'order_serial' => 0,
            'seller_id' => $item_info["m_id"],
            'buyer_id' => "",
            'kind' => DF_mail_seller_reg,
            'title' => Fcv(DF_site_name."に商品のご登録ありがとうございます。","en"),
            'maildata' => $mail_tpl
        ];
        
        // Emailの場合
		$to = $item_info["valeur_mail"];
        $subject = '【'. DF_site_name .'】登録した商品を御確認ください';
		$subject = mb_convert_encoding($subject, "SJIS", "auto");
		//メール本文
		$mail_body = mb_convert_encoding($mail_tpl, "SJIS", "auto");
		$from = array();
		$from['name'] = mb_convert_encoding('Ｍマート', 'SJIS', 'auto');
		$from['mail'] = DF_mail_to_mmart_info;
		$bcc_arr = [];
		// メール送信
		$c_mail->send_mail($from['name'], $from['mail'], $to, $subject, ($mail_body));

        // メール本文をＤＢに保存
        F_insert_seller_out_mail($data_insert);
    }
   
}
if($button_type == "delete-item"){
    $item_serial = $_REQUEST["f_serial"];
    $senmail_item = F_delete_item($item_serial);
    $path = "tpl/tpl_sendmail_delete_item.txt";
    // mailbox
    $data = [
        "valeur_coname" =>$senmail_item["valeur_coname"],
        "valeur_tantou" =>$senmail_item["valeur_tantou"],
        "item_name"     =>$senmail_item["m_item"],
        "message"       =>"",
        "sys_title"     =>DF_site_name
    ];
    $mail_tpl = F_getmail_tpl($path, $data);

    $data_insert = [
        'order_serial' => 0,
        'seller_id' => $senmail_item["m_id"],
        'buyer_id' => "",
        'kind' => DF_mail_seller_reg,
        'title' => Fcv("バルルに商品のご登録ありがとうございます。","en"),
        'maildata' => $mail_tpl
    ];
    // F_insert_seller_out_mail($data_insert);
    // email send
    // sendmail_review_valeur($senmail_item, $path);
}
if($button_type == "edit_btn"){
    // $item_serial = $_REQUEST["f_serial"];
    $data = [
        "tanka"         =>$_REQUEST["f_tanka"],
        "lot"           =>Fcv($_REQUEST["f_lot"],"en"),
        "lot_total"     =>$_REQUEST["f_lot_total"],
        "item_serial"   =>$_REQUEST["f_serial"]
    ];
    $resual = F_edit_item($data);
}

function F_get_item(){
	global $c_dbi;

    $c_dbi->DB_on('mmart_uriba');

	$sql=sprintf('SELECT
            t1.ai_serial,
            t1.m_serial,
            t7.valeur_coname,
            t1.m_item,
            t1.m_lot_small,
            t1.m_tanka_tani,
            t1.m_price_lot,
            t1.m_tanka,
            t1.shounin_time,
            t1.modified,
            t1.review_flg,
            t1.shounin_flg,
            t1.m_setsumei,
            t4.c_cate1,
            t3.c_serial1
			,t3.c_serial2
			,t3.c_serial3
			,t4.c_cate1
			,t5.c_cate2
			,t3.c_cate3
			,t6.c_cate4
        FROM
            `mmart_uriba`.`valeur_m_data_dat` AS t1
        LEFT JOIN mmart_uriba.valeur_seller_outlet AS t7 ON t1.m_id = t7.valeur_id
        LEFT JOIN dami2.m_cate3 AS t3 ON t1.m_cate_m = t3.c_search3
        LEFT JOIN dami2.m_cate1 AS t4 ON t3.c_serial1 = t4.c_serial1
        LEFT JOIN dami2.m_cate2 AS t5 ON t3.c_serial1 = t5.c_serial1 AND t3.c_serial2 = t5.c_serial2
        LEFT JOIN dami2.m_cate4 AS t6 ON t1.m_cate_m2 = t6.c_search4 AND t3.c_serial1 = t6.c_serial1 AND t3.c_serial2 = t6.c_serial2 AND t3.c_serial3 = t6.c_serial3
        WHERE t1.del_flg = 0');
        

    $res=$c_dbi->DB_exec($sql);

    $c_dbi->DB_off();

    $resual = [];

    while($row=mysqli_fetch_array($res,MYSQLI_ASSOC)){
        // 承認待ち
        if($row["shounin_flg"] == 0 && $row["review_flg"] == 1){
            $resual['wait'][$row["ai_serial"]] = $row;
        }
        // 確認待ち
        if($row["shounin_flg"] == 0 && $row["review_flg"] == 0){
            $resual['check'][$row["ai_serial"]] = $row;
        }
        // 承認済み
        if($row["shounin_flg"] == 1){
            $resual['complete'][$row["ai_serial"]] = $row;
        }
        // 却下
        if($row["shounin_flg"] == 2 || $row["review_flg"] == 2){
            $resual['delete'][$row["ai_serial"]] = $row;
        }
        $resual['all'][] = $row;

    }
    $resual = Fcv($resual);

    return $resual;
}
function F_henshin($message ,$item_serial){
	global $c_dbi;

    $c_dbi->DB_on('mmart_uriba');

	$sql=sprintf('UPDATE mmart_uriba.valeur_m_data_dat SET review_message = "%1$s", review_flg = 2, review_time = NOW() WHERE ai_serial = %2$s', $message , $item_serial);

    $c_dbi->DB_exec($sql);

    $sql=sprintf('SELECT
        t1.`ai_serial`,
        t1.`m_serial`,
        t1.`m_id`,
        t1.`m_item`,
        t1.review_message,
        t2.valeur_coname,
        t2.valeur_mail,
        t2.valeur_tantou
    FROM
        mmart_uriba.valeur_m_data_dat as t1
    LEFT JOIN mmart_uriba.valeur_seller_outlet as t2 on t2.valeur_id = t1.m_id
    WHERE
        ai_serial = %1$s', $item_serial);

    $res=$c_dbi->DB_exec($sql);
    
    $c_dbi->DB_off();

    $resual = [];
    
    while($row=mysqli_fetch_array($res,MYSQLI_ASSOC)){
        $resual[] = $row;
    }
    $resual = Fcv($resual[0]);

    return $resual;

}

function F_kakunin($item_serial){
	global $c_dbi;

    $c_dbi->DB_on('mmart_uriba');

	$sql=sprintf('UPDATE mmart_uriba.valeur_m_data_dat SET review_flg = 1, review_time = NOW() WHERE ai_serial = %1$s', $item_serial);

    $res=$c_dbi->DB_exec($sql);

    $c_dbi->DB_off();

}

function F_delete_item($item_serial){
	global $c_dbi;

    $c_dbi->DB_on('mmart_uriba');

	$sql=sprintf('UPDATE mmart_uriba.valeur_m_data_dat SET shounin_flg = 2, modified = NOW() WHERE ai_serial = %1$s', $item_serial);

    $res=$c_dbi->DB_exec($sql);

    $sql=sprintf('SELECT
        t1.`ai_serial`,
        t1.`m_serial`,
        t1.`m_id`,
        t1.`m_item`,
        t1.review_message,
        t2.valeur_coname,
        t2.valeur_mail,
        t2.valeur_tantou
    FROM
        mmart_uriba.valeur_m_data_dat as t1
    LEFT JOIN mmart_uriba.valeur_seller_outlet as t2 on t2.valeur_id = t1.m_id
    WHERE
        ai_serial = %1$s', $item_serial);

    $res=$c_dbi->DB_exec($sql);
    
    $c_dbi->DB_off();

    $resual = [];
    
    while($row=mysqli_fetch_array($res,MYSQLI_ASSOC)){
        $resual[] = $row;
    }
    $resual = Fcv($resual[0]);

    return $resual;
}
function F_edit_item($edit_data){
	global $c_dbi;

    $c_dbi->DB_on('mmart_uriba');

	$sql=sprintf('UPDATE mmart_uriba.valeur_m_data_dat
        SET
            m_tanka = %1$s,
            m_lot_small = "%2$s",
            m_price_lot = %3$s
        WHERE
            ai_serial = %4$s'
            , $edit_data["tanka"]
            , $edit_data["lot"]
            , $edit_data["lot_total"]
            , $edit_data["item_serial"]
        );
    $res=$c_dbi->DB_exec($sql);

    return $res;

}
function F_get_one_item($item_serial){
    global $c_dbi;

    $c_dbi->DB_on('mmart_uriba');

    $sql=sprintf('SELECT * FROM `mmart_uriba`.`valeur_m_data_dat` WHERE `ai_serial` = %1$s', $item_serial);

    $res=$c_dbi->DB_exec($sql);
    
    $c_dbi->DB_off();

    $resual = [];
    
    while($row=mysqli_fetch_array($res,MYSQLI_ASSOC)){
        $resual[] = $row;
    }
    $resual = Fcv($resual[0]);

    // echo json_encode($resual);
    return $resual;
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

function sendmail_review_valeur($sendmail_item, $path){
	global $DF_uriba;

	// メールテンプレートを準備する
	// 置換対象設定
	$replacements = [
		'{{seller_shop}}' => $sendmail_item["valeur_coname"],
		'{{seller_tantou}}' => $sendmail_item["valeur_tantou"],
		'{{item_name}}' => $sendmail_item["m_item"],
		'{{sys_title}}' => $DF_uriba,
		'{{message}}' => $sendmail_item["review_message"],
	];
	// メールテンプレートを取得
	$mail_tpl = null;
	$mail_tpl = file_get_contents($path, true);
	$mail_tpl = str_replace(array_keys($replacements), array_values($replacements), $mail_tpl);

	// メール用テーブルに登録する
	if (!empty($mail_tpl)) {
		// Emailの場合
		mb_language("Japanese");
		mb_internal_encoding("UTF-8");
		$to = $sendmail_item["valeur_mail"];
		$from = "株式会社Ｍマート<info@m-mart.co.jp>";
		$subject = '【'. $DF_uriba .'】登録した商品を御確認ください';
		$header = "From: {$from}\r\nReply-To: {$from}\r\nBcc: {$from}\n";
		$header .= "Content-type: text/plain; charset=UTF-8\n";
		$header .= "Content-Transfer-Encoding: 8bit\n";

		$subject = mb_convert_encoding($subject, "UTF-8", "auto");
		$mail_body = mb_convert_encoding($mail_tpl, "UTF-8", "auto");
		$from = mb_convert_encoding($from, "UTF-8", "auto");
		// メール送信
		mb_send_mail($to, $subject, $mail_body, $header, "-f {$from}");
	}
}

require_once('/var/www/html3/outlet/valeur/kanri/tpl/tpl_debut_list.php');
?>
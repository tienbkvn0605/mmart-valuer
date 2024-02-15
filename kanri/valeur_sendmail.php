<?php
/**
* 商品に関するクラス
* 2024-01-22   tien   【開1-23-0021】バルル委託販売機能作成
*/

require_once('/var/php_class/class_dbi.php');
//DBオブジェクト実体化
$c_dbi=new G_class_dbi;

require_once '/var/php_class/class_mail.php';//メールクラス
//MAILオブジェクト実体化
$c_mail=new G_class_mail;
$c_mail->send_switch('on');	//送信停止、許可

function F_insert_seller_out_mail ($f_set_values) {
    global $c_dbi;
    $ret_serial = 0;
    // メール格納テーブルのカラム
    $out_mail_column = array(
        'order_serial',
        'seller_id',
        'buyer_id',
        'kind',
        'title',
        'maildata',
        'created',
    );
    $set	= implode(',', $out_mail_column);

    $c_dbi->DB_on('mmart_uriba');

    $sql = sprintf(' INSERT INTO `mmart_uriba`.`out_mail` (
            %1$s
        ) values (
            %2$d,
            %3$s,
            %4$s,
            %5$d,
            %6$s,
            %7$s,
            NOW()
        )'
        , $set
        , $f_set_values['order_serial']
        , $c_dbi->DB_qq($f_set_values['seller_id'])
        , $c_dbi->DB_qq($f_set_values['buyer_id'])
        , $f_set_values['kind']
        , $c_dbi->DB_qq($f_set_values['title'])
        , $c_dbi->DB_qq($f_set_values['maildata'])
    );

    $res = $c_dbi->DB_exec($sql);
    $ret_serial = $c_dbi->insert_id();
    $c_dbi->DB_off();
    !$res && die('メールデータ 挿入エラー');

    return $ret_serial;
}

function sendmail_email_signup($data, $path){
    global $c_mail;
	// メールテンプレートを準備する
	// 置換対象設定
	$replacements = [
		'{{seller_id}}' => $data["valeur_id"],
		'{{seller_pass}}' => $data["valeur_pass"],
		'{{seller_shop}}' => $data["valeur_coname"],
		'{{seller_tantou}}' => $data["valeur_tantou"],
		'{{sys_title}}' => $data["sys_title"],
		'{{login_url}}' => $data["login_url"],
	];
	// メールテンプレートを取得
	$mail_tpl = null;
	$mail_tpl = file_get_contents($path, true);
	$mail_tpl = str_replace(array_keys($replacements), array_values($replacements), $mail_tpl);
    $mail_tpl = mb_convert_encoding($mail_tpl, "SJIS", "UTF-8");
	// メール用テーブルに登録する
	if (!empty($mail_tpl)) {
		// Emailの場合
		$to = $data["valeur_mail"];
		$subject = $data["subject"];
		$subject = mb_convert_encoding($subject, "SJIS", "auto");
		//メール本文
		$mail_body = mb_convert_encoding($mail_tpl, "SJIS", "auto");
		$from = array();
		$from['name'] = mb_convert_encoding('Ｍマート', 'SJIS', 'auto');
		$from['mail'] = DF_mail_to_mmart_info;
		$bcc_arr = ['a.watarai@m-mart.co.jp', 't.kutanida@m-mart.co.jp'];
		// メール送信
		$send_flg = $c_mail->send_mail($from['name'], $from['mail'], $to, $subject, ($mail_body), $bcc_arr);
				
	}
}

function sendmail_email_item($sendmail_item){
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
	$mail_tpl = file_get_contents('tpl/tpl_sendmail_review.txt', true);
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
function F_getmail_tpl($path, $data){

	$replacements = [
		'{{seller_shop}}' 	=> $data["valeur_coname"],
        '{{seller_tantou}}' => $data["valeur_tantou"],
        '{{item_name}}' 	=> $data["item_name"],
        '{{message}}' 		=> $data["message"],
        '{{sys_title}}' 	=> $data["sys_title"],
        '{{item_url}}' 	=> $data["item_url"]
    ];

	$mail_tpl = null;
    $mail_tpl = file_get_contents($path, true);
    $mail_tpl = str_replace(array_keys($replacements), array_values($replacements), $mail_tpl);
    $mail_tpl = Fcv($mail_tpl, "en");

	return $mail_tpl;
}

?>
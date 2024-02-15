<?php
/**
 * 勝手に売上創る商品登録
 * 2024/01/22   ティエン    【開1-23-0021】バルル委託販売機能作成（社長が出品社の申し込みを承認）
 */

require_once('/var/www/html3/outlet/valeur/kanri/valeur_sendmail.php');
require_once('/var/www/html3/outlet/valeur/lib/config.php');
require_once('/var/php_class/class_dbi.php');
$c_dbi=new G_class_dbi;

$c_seller = new Seller;
$FL_login = false;
$FL_shacho = false;
$FL_kanri = false;

// ログインチェック
if(isset($_SESSION['pay_kanri']) && $_SESSION['pay_kanri']=='kanri'){
	// $login_staff='管理者';
    $FL_login = true;
    $FL_shacho = true;
	$FL_kanri = true;
	$login_staff = Fcv($_SESSION['LOGIN_USER']);
}

if (!$FL_login && !$FL_kanri) {
	die(Fcv('<br>表示権限エラー<br><br>',"en"));
	$error_msg = '権限エラー';
}

$edit_type = "";
if(isset($_REQUEST['edit_type']) && $edit_type = $_REQUEST["edit_type"]);

$A_seller_shinsa = F_get_seller_shinsa();

// 承認
if($edit_type == "koukai"){
    $serial = $_REQUEST["f_serial"];
    $seller = F_koukai_seller($serial);
    $seller = Fcv($seller[0]);
    // メールテンプレートを準備する
    // 置換対象設定
    $replacements = [
        '{{seller_shop}}' => $seller["valeur_coname"],
        '{{seller_tantou}}' => $seller["valeur_tantou"],
        '{{sys_title}}' => DF_site_name,
        '{{login_url}}' => 'https://'.$_SERVER['HTTP_HOST'].'/outlet/valeur/admin/index.php',
    ];

    // メールテンプレートを取得
    $mail_tpl = null;
    $mail_tpl = file_get_contents('tpl/tpl_sendmail_resign_complete.txt', true);
    $mail_tpl = str_replace(array_keys($replacements), array_values($replacements), $mail_tpl);
    $mail_tpl = Fcv($mail_tpl, "en");

    $f_set_values = [
        'order_serial' => 0,
        'seller_id' => $seller["valeur_id"],
        'buyer_id' => "",
        'kind' => 40,
        'title' => Fcv("バルルにお申し込みありがとうございます。","en"),
        'maildata' => $mail_tpl
    ];
    
    F_insert_seller_out_mail($f_set_values);

    // email送信
    $path = 'tpl/tpl_sendmail_resign_complete.txt';
    $data = [
        "valeur_id" => $seller["valeur_id"],
        "valeur_pass" => $seller["valeur_pass"],
        "valeur_coname" => $seller["valeur_coname"],
        "valeur_tantou" => $seller["valeur_tantou"],
        "valeur_mail" => $seller["valeur_mail"],
        "sys_title" => DF_site_name,
        'login_url' => 'https://'.$_SERVER['HTTP_HOST'].'/outlet/valeur/admin/index.php',
        "subject" => "バルルにお申し込みありがとうございます。"
        ];
        
    sendmail_email_signup($data, $path);

}

// 却下
if($edit_type == "delete_shinsa"){
    $serial = $_REQUEST["d_serial"];

    $seller = F_delete_seller($serial);
    $seller = Fcv($seller[0]);

    // メールテンプレートを準備する
    // 置換対象設定
    $replacements = [
        '{{seller_shop}}' => $seller["valeur_coname"],
        '{{seller_tantou}}' => $seller["valeur_tantou"],
        '{{sys_title}}' => DF_site_name
    ];
    // メールテンプレートを取得
    $mail_tpl = null;
    $mail_tpl = file_get_contents('tpl/tpl_sendmail_resign_reject.txt', true);
    $mail_tpl = str_replace(array_keys($replacements), array_values($replacements), $mail_tpl);
    $mail_tpl = Fcv($mail_tpl, "en");

    $f_set_values = [
        'order_serial' => 0,
        'seller_id' => $seller["valeur_id"],
        'buyer_id' => "",
        'kind' => 40,
        'title' => Fcv("バルルにご登録ありがとうございます。","en"),
        'maildata' => $mail_tpl
    ];
    // F_insert_seller_out_mail($f_set_values);
    // email
    $path = "tpl/tpl_sendmail_resign_reject.txt";
    $data = [
        "valeur_coname" => $seller["valeur_coname"],
        "valeur_tantou" => $seller["valeur_tantou"],
        "valeur_mail" => $seller["valeur_mail"],
        "sys_title" => DF_site_name,
        "subject" => "バルルにご登録ありがとうございます。"
        ];
    // sendmail_email_signup($data, $path);

}

/**
 * 出品社情報取得
 *
 * @return void
 */
function F_get_seller_shinsa(){
    global $c_dbi;

	$c_dbi->DB_on("mmart_uriba");

    $sql = sprintf('SELECT
            t1.`serial`,
            t1.`day_debut`,
            t1.`site`,
            t1.`valeur_coname`,
            t1.`valeur_tantou`,
            t1.`valeur_item`,
            t1.`valeur_tel`,
            t1.`valeur_mail`,
            CONCAT(t1.`valeur_zip1`,"-",t1.`valeur_zip2`) AS valeur_zip,
            t1.`valeur_add1`,
            t1.`valeur_add2`,
            t1.`valeur_id`,
            t1.`valeur_mtantou`,
            t1.`valeur_kakunin_flg`,
            t1.`valeur_kakunin_date`,
            t1.`created`,
            t1.`valeur_listed`,
            t1.`valeur_capital`,
            t1.`valeur_annual_sales`
        FROM
            `mmart_uriba`.`valeur_seller_outlet` as t1
        WHERE
            t1.`del_flg` = 0
        ORDER BY  t1.`created` DESC;');
    $res = mysqli_query($c_dbi->G_DB,$sql);
    $c_dbi->DB_off();

	$arr = [];
	while ($row = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
        if($row["valeur_kakunin_flg"]==1){
            $arr["arr_koukai"][]=$row;
        }elseif($row["valeur_kakunin_flg"]==2){
            $arr["delete"][] = $row;
        }
        else{
            $arr["shinsa"][] = $row;
        }
	}
    $arr = Fcv($arr);

    return $arr;
}

/**
 * 承認済み出品社情報取得
 *
 * @param [type] $serial
 * @return void
 */
function F_koukai_seller($serial){
    global $c_dbi;

	$c_dbi->DB_on("mmart_uriba");

    $sql = sprintf('UPDATE `mmart_uriba`.`valeur_seller_outlet` SET `day_debut`= DATE_FORMAT(NOW(),"%%Y-%%m-%%d"), `valeur_kakunin_flg`=1, `valeur_kakunin_date`= NOW() WHERE `serial` = %1$s', $serial);
    $res = mysqli_query($c_dbi->G_DB,$sql);

    $sql = sprintf('SELECT 
        serial,
        day_debut,
        site,
        valeur_coname,
        valeur_tantou,
        valeur_item,
        valeur_tel,
        valeur_mail,
        CONCAT(valeur_zip1,"-",valeur_zip2) AS valeur_zip,
        valeur_add1,
        valeur_add2,
        valeur_id,
        valeur_pass,
        valeur_mtantou,
        valeur_kakunin_flg,
        valeur_kakunin_date,
        created,
        valeur_listed,
        valeur_capital,
        valeur_annual_sales 
        FROM `mmart_uriba`.`valeur_seller_outlet` 
        WHERE serial = %1$s', $serial);
    $res = mysqli_query($c_dbi->G_DB,$sql);

    $c_dbi->DB_off();

    $seller = [];
	while ($row = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
        $seller[] = $row;
    }

    return $seller;
}

function F_delete_seller($serial){
    global $c_dbi;

	$c_dbi->DB_on("mmart_uriba");

    $sql = sprintf('UPDATE `mmart_uriba`.`valeur_seller_outlet` SET `valeur_kakunin_flg`= 2, `valeur_kakunin_date`= NOW() WHERE `serial` = %1$s', $serial);
    $res = mysqli_query($c_dbi->G_DB,$sql);

    $sql = sprintf('SELECT valeur_id, valeur_coname, valeur_tantou, valeur_mail from `mmart_uriba`.`valeur_seller_outlet` WHERE serial = %1$s', $serial);
    $res = mysqli_query($c_dbi->G_DB,$sql);

    $c_dbi->DB_off();

    $seller = [];
	while ($row = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
        $seller[] = $row;
    }
    return $seller;
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
// template
require_once('/var/www/html3/outlet/valeur/kanri/tpl/tpl_seller_shinsa.php');

?>
<?php
/**
 * config
 * 2024-01-26   ナム    バルル商品登録機能
 */

// セッション開始
session_start();

// リクエストを取得
$input = $_REQUEST;

// 外部ファイル読込
include_once('/var/www/html3/outlet/valeur/lib/function.php');

$config = [];
$config['title'] = 'バルル商品登録申請'; // 商品タイトル
$config['moto_flg'] = 'out_katte';

define('DF_mail_mmart','info@m-mart.co.jp');   //Mマートメアド
define('DF_site_name', 'バルル委託出店社');
define('DF_session_key', 'valeur');
define('DF_m_data_dat_valeur_id', 'valeur');
define('DF_seller_admin_session', 'seller_admin');

//種別カテゴリ
$config['G_cate5_arr'] = array('和牛（経産）','和牛（未経産/メス・去勢）','交雑牛（経産）','交雑牛（未経産/メス・去勢）','ホルス（経産）','ホルス（未経産/メス・去勢）','該当なし');
//保存方法
$config['A_hozon'] =array('冷凍', '冷蔵', '常温');	//arr[]=array('title'=>保存方法,'value'=>保存方法);
$config['G_displimit_cate1_arr']=array('水産市場','農産市場','生鮮(チルド)市場');

// 画像関係
define('DF_mail_to_mmart_info','info@m-mart.co.jp');	//Mマート宛先
define('DF_system_cc_mail', 'customer1@m-mart.co.jp');	//メール送信の際、ccでシステムへ送る時のアドレス
define('DF_f_pic_fold','/valeur/ireg/tmp/');	//画像ファイル格納フォルダパス
define('DF_pic_upload','/var/www/html3/valeur/ireg/tmp/');	//画像ファイル格納フォルダパス
define('DF_f_picuplimit',4000000);		//アップ画像ファイル許可最大サイズ4Mb
define('DF_picsize_m',480);				//格納画像リサイズメイン
define('DF_picsize_s',200);				//格納画像リサイズサムネール
define('DF_resize_px',400);				//拡大リサイズ判定値
define('DF_sanchi_sep','-');			//産地加工地区切り

// メール設定番号
define('DF_mail_item_debut_shinsei',40);	//商品登録申請
define('DF_mail_item_price_edit',38);		//価格設定結果
define('DF_mail_item_henshin',39);			//商品登録返信
define('DF_mail_item_koukai',40);			//商品登録公開
define('DF_mail_item_kyakka',41);			//商品登録却下（社長）

define('DF_mail_seller_reg',40);			//即売メールボックス

//タグ変換キー（http～の文字列も一緒に処理します）
$config['A_tagkey'] = array(
	'item'			//商品名
	,'sanchi'		//産地
	,'kakouchi'		//加工地
	,'keitai'		//形態
	,'nisugata'		//荷姿
	,'size'			//サイズ
	,'jisseki'		//販売実績
	,'menu'			//メニュー
	,'bikou'		//備考
	,'zairyo'		//材料
	,'setsumei'		//商品説明
	,'eiyou'		//栄養成分表示
	,'pic4_catch_copy'	//画像4枚目のキャッチコピー
	,'pic5_catch_copy'	//画像5枚目のキャッチコピー
) ;
$config['soryo_size'] = array('60','80','100','120','140','160','170','180','200','220','240','250','260');
$config['soryo_weight'] = array('2','5','10','15','20','25','30','40','50');
$config['soryo_calendar_reg_count'] = 10; // 送料設定　と　休業日設定　最大件数
?>
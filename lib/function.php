<?php
/**
 * function
 * 2024-01-22   ナム    バルル商品登録機能
 */
 require_once('/var/define_files/define_web.php');
 include_once('/var/www/html3/outlet/valeur/lib/Item.php');
 include_once('/var/www/html3/outlet/valeur/lib/seller.php');
 include_once('/var/php_function/outlet_common.php');

 /**
 * HTML出力用エスケープ関数
 *
 * @param	string	$str
 * @return	string	$str
 */
function escape($str): string {
	// return htmlspecialchars($str, ENT_QUOTES, 'shift_jis');
	return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}


/*****************************
画像アップロード

アップロード画像をリネーム、サイズ調整しフォルダに格納する(メイン画像、サムネール画像)

引数	$f_id		=	出品社id
		$f_filearr	=	アップロードファイルarr
		$f_i	= 番号

戻り値　作業結果フラグ、登録メイン画像ファイルネーム
		$array('flg'=>作業結果フラグ,'tex'=>エラーテキストor登録メイン画像ファイルネーム);
		フラグ 1=登録成功,2=エラー
******************************/
function F_pic_upload($f_id,$f_filearr,$f_i){
	$ret_arr=array('flg'=>2,'tex'=>'画像ファイル処理エラー');

	$upfile = $f_filearr['tmp_name'];	//up時tempファイル名

	$img_size = $f_filearr['size'];	//up画像サイズ取得
	if($img_size>DF_f_picuplimit){	//upファイルサイズ確認
		unlink($upfile);
		$ret_arr['flg']=2;
		$ret_arr['tex']='<span style="color:#ff0000;">※ファイル選択エラー：<br>画像ファイルの大きさが制限を越えています、ファイルサイズを修正し再度選択してください</span><br>';
		return $ret_arr;
	}

	if(is_uploaded_file($upfile)){	//ファイルupload確認
		$image_dat = getimagesize($upfile); //画像情報を取得
		$pic_kind='';
		switch($image_dat[2]){
			case 1:
				$pic_kind='gif';
				$image = imagecreatefromgif($upfile);
				break;
			case 2:
				$pic_kind='jpg';
				$image = imagecreatefromjpeg($upfile);
				break;
			case 3:
				$pic_kind='png';
				$image = imagecreatefrompng($upfile);
				break;
			default:
				unlink($upfile);
				$ret_arr['flg']=2;
				$ret_arr['tex']='<span style="color:#ff0000;">拡張子エラー:選択画像ファイルの拡張子をご確認ください</span><br>';
				return $ret_arr;
		}
		// $up_name_m='shintouroku_'.$f_id.'_'.$f_i.(date('_YmdHis.').$pic_kind);	//実格納メイン画像ファイル名
		$up_name_m='shintouroku_'.$f_id.'_'.(date('YmdHis.').$pic_kind);	//実格納メイン画像ファイル名
		$up_name_s='sum_'.$up_name_m;					//実格納サムネール画像ファイル名

		//画像リサイズ
		list($width, $height) = getimagesize($upfile);
		// $get_size=($width>$height)?$width:$height;
		$get_size=($width<$height)?$width:$height;

		//縦または横400px以下の画像を400pxにリサイズする処理
		if($get_size < DF_resize_px){
			$percent = DF_resize_px/$get_size;	//拡大用縮尺比
			$m_width = $width * $percent;
			$m_height = $height * $percent;
	
			$image_p = imagecreatetruecolor($m_width, $m_height);
			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $m_width, $m_height, $width, $height);

			$sendpath = DF_pic_upload.$up_name_m;
			if($pic_kind=='gif'){
				$upload_flg=imagegif($image_p,$sendpath);
				$image = imagecreatefromgif($sendpath);
			}elseif($pic_kind=='jpg'){
				$upload_flg=imagejpeg($image_p,$sendpath);
				$image = imagecreatefromjpeg($sendpath);
			}elseif($pic_kind=='png'){
				$upload_flg=imagepng($image_p,$sendpath);
				$image = imagecreatefrompng($sendpath);
			}
			if(!$upload_flg){	//画像格納失敗
				unlink($upfile);
				$ret_arr['flg']=2;
				$ret_arr['tex']='<span style="color:#ff0000;">メイン画像格納エラー:もう一度画像を選択してください</span><br>';
				return $ret_arr;
			}

			list($width, $height) = getimagesize($sendpath);
			$get_size=($width>$height)?$width:$height;
		}else{
			list($width, $height) = getimagesize($upfile);
			$get_size=($width>$height)?$width:$height;
		}

		$percent_m = DF_picsize_m/$get_size;	//メイン画像用縮尺比
		$percent_s = DF_picsize_s/$get_size;	//サムネール画像用縮尺比

		//メイン画像新サイズ計算
		if($percent_m<1){
			$m_width = $width * $percent_m;
			$m_height = $height * $percent_m;
		}else{
			$m_width = $width;
			$m_height = $height;
		}
		//サムネール画像新サイズ計算
		if($percent_s<1){
			$s_width = $width * $percent_s;
			$s_height = $height * $percent_s;
		}else{
			$s_width = $width;
			$s_height = $height;
		}
		// 再サンプル、メイン画像格納
		$sendpath = DF_pic_upload.$up_name_m;
		$image_p = imagecreatetruecolor($m_width, $m_height);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $m_width, $m_height, $width, $height);
		$upload_flg=false;
		if($pic_kind=='gif'){
			$upload_flg=imagegif($image_p,$sendpath);
		}elseif($pic_kind=='jpg'){
			$upload_flg=imagejpeg($image_p,$sendpath);
		}elseif($pic_kind=='png'){
			$upload_flg=imagepng($image_p,$sendpath);
		}
		
		if($upload_flg){	//画像格納成功
			chmod($sendpath,0666);
		}else{	//画像格納失敗
			unlink($upfile);
			$ret_arr['flg']=2;
			$ret_arr['tex']='<span style="color:#ff0000;">メイン画像格納エラー:もう一度画像を選択してください</span><br>';
			return $ret_arr;
		}
		// 再サンプル、サムネール画像格納
		$sendpath = DF_pic_upload.$up_name_s;
		$image_p = imagecreatetruecolor($s_width, $s_height);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $s_width, $s_height, $width, $height);
		$upload_flg=false;
		if($pic_kind=='gif'){
			$upload_flg=imagegif($image_p,$sendpath);
		}elseif($pic_kind=='jpg'){
			$upload_flg=imagejpeg($image_p,$sendpath);
		}elseif($pic_kind=='png'){
			$upload_flg=imagepng($image_p,$sendpath);
		}
		if($upload_flg){	//画像格納成功
			chmod($sendpath,0666);
		}else{	//画像格納失敗
			unlink($upfile);
			$ret_arr['flg']=2;
			$ret_arr['tex']='<span style="color:#ff0000;">サムネール画像格納エラー:もう一度画像を選択してください</span><br>';
			return $ret_arr;
		}
	}else{	//uploadエラー時
		$ret_arr['flg']=2;
		$ret_arr['tex']='<span style="color:#ff0000;">画像アップロードエラー:Mマートまでご連絡ください tel:03-6811-0124</span><br>';
		return $ret_arr;
	}
	unlink($upfile);
	$ret_arr['flg']=1;
	$ret_arr['tex']=$up_name_m;
	return $ret_arr;
}

//---------------------------------------------------------------------バルル商品登録機能/

 /**
 * 売り手へメール送信する（商品公開）
 */
function send_mail_item_regist ( $c_mail, $data, $mail_body, $subject ) {
	$ret_str = 'OK';
	$insert_mail_serial = 0;

	//商品情報
	$item = '';
	$item .= '■'.$data['item'];

	//メール本文
	$maildata = sprintf($mail_body
	, ($data['valeur_coname'])  //1
	, ($data['valeur_tantou'])  //2
	, $item                  	//3
	);

	$from = array();
	$from['name'] = 'Ｍマート';
	$from['mail'] = DF_mail_to_mmart_info;
	$cc = array(DF_system_cc_mail);
	// メール送信
	$send_flg = $c_mail->send_mail($from['name'], $from['mail'], DF_system_cc_mail, $subject, ($maildata));
	if(!$send_flg) {
		$ret_str = 'NG';
		return;
	}
	

	return $ret_str;
}

//商品登録申請のメール内容
function item_debut_shinsei_mail_body($data){
	$mail_body =sprintf('
%1$s
%2$s　様

こちらは自動通知メールです。

バルルへの商品登録申請が完了しました。

申請中商品：%3$s

Mマートで価格審査が完了次第、審査結果をお知らせいたします。

このメールに心当たりがない場合や、ご不明な点が御座いましたら弊社までご連絡下さい。

以上、よろしくお願い申し上げます。
*************************
株式会社　Ｍマート
Mマート市場
〒163-1326
東京都新宿区西新宿6-5-1
新宿アイランドタワー26階
TEL 03-6811-0124
FAX 03-6811-0139
E-Mail info@m-mart.co.jp
URL https://www.m-mart.co.jp
*************************'
, mb_convert_encoding($data['valeur_coname'], 'UTF-8', 'auto')
, mb_convert_encoding($data['valeur_tantou'], 'UTF-8', 'auto')
, $data['item']
);
	return $mail_body;
} 


/************************************
休業日カレンダー作成

渡された年月のカレンダーを作成する
休日データに合致する日の背景を休日用にする

引数	$f_y	=	作成年yyyy
		$f_m	=	作成月m
		$f_r	=	休業日データarr arr[]=array(休業日d)

戻り値	カレンダーテキスト
************************************/
function F_make_rest($f_y,$f_m){
		$ret_tex='';
		//当月休日なしチェック
	
		$all_h='<td align="right"></td><td align="right">がお休み</td>';
		$check_date=$f_y.'/'.$f_m.'/0';

		// $all_h.='<td data-date="'.$check_date.'">-無休-</td></tr>';
		$all_h.='<td data-date="'.$check_date.'"></td></tr>';
		
		$ret_tex.='<table cellpadding="0" cellspacing="2" >
						<tr>
						<td><h5><b>'.$f_m.'月</b></h5></td>
						'.$all_h.'
					</table>
					<table class="table table-bordered">
						<tr bgcolor="#dcdcdc">';
	
		//曜日設定
		$weekday_arr=array('日','月','火','水','木','金','土');
		$weekday_count=0;
		foreach($weekday_arr as $weekday){
			$check_date=$f_y.'/'.$f_m.'/w'.$weekday_count;

		$ret_tex.='<td align="center" class="p-3" data-date="'.$check_date.'">'.$weekday.'</td>';
			$weekday_count++;
		}
	
		$ret_tex.='</tr>';
	
		$disp_day=1;	//書き込み日
		$youbi_count=0;
		$youbi=date("w", mktime(0, 0, 0, $f_m, 1, $f_y));	//1日曜日取得
		//第一週半端チェック作成
		$ret_tex.='<tr>';
		for($i=0;$i<$youbi;$i++){
			$ret_tex.='<td align="center" class="p-3 bg-body-secondary"></td>';
			$youbi_count++;
		}
		for($i=$youbi_count;$i<7;$i++){
			$check_date=$f_y.'/'.$f_m.'/'.$disp_day;
			$ret_tex.='<td align="center" class="p-3 select_date" data-date="'.$check_date.'">'.$disp_day.'</td>';
			$disp_day++;
		}
		$ret_tex.='</tr>';
		//第二週以降作成
		while(checkdate($f_m,$disp_day,$f_y)){
			$ret_tex.='<tr>';
			for($i=0;$i<7;$i++){
				$link_tex='';
				if(checkdate($f_m,$disp_day,$f_y)){
					$check_date=$f_y.'/'.$f_m.'/'.$disp_day;
					$link_tex='<span class="select_date" data-date="'.$check_date.'">'.$disp_day.'</span>';
				}
				
				if(!empty($link_tex)){
					$ret_tex.='<td align="center" class="p-3 select_date" data-date="'.$check_date.'">'.$disp_day.'</td>';
				}else{
					$ret_tex.='<td align="center" class="p-3 bg-body-secondary"></td>';
				}
				$disp_day++;
			}
			$ret_tex.='</tr>';
		}
		$ret_tex.='</table>';
	
		return $ret_tex;
	}
?>
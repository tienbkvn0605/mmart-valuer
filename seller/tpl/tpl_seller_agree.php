<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>出品について｜<?php echo DF_site_name;?>｜仕入れなら業務用食材卸売市場Mマート</title>

<meta name="description" content="">
<meta name="keywords" content="">

<link rel="stylesheet" type="text/css" media="all" href="/css/reset.css?<?php echo time()?>" />
<link rel="stylesheet" type="text/css" media="all" href="/css/footer.css?<?php echo time()?>" />
<link rel="stylesheet" type="text/css" media="all" href="/css/common.css?<?php echo time()?>" />
<link rel="stylesheet" type="text/css" media="all" href="/outlet/valeur/common/css/style.css?<?php echo time()?>" />
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


<script type="text/javascript">
$(function(){
	var e_style='display:inline-block;background:#cc0000;border-radius:5px;padding:10px;color:#fff;',
		d_style='display:inline-block;background:#b3a5a5;border-radius:5px;padding:10px;color:#fff;';
	$('#reg_btn').prop('disabled', true);
	$('#reg_btn').attr('style', d_style);
	$('#agree').click(function(){
		if($('#agree').prop('checked')){
			$('#reg_btn').prop('disabled', false);
			$('#reg_btn').attr('style', e_style);
		}else{
			$('#reg_btn').prop('disabled', true);
			$('#reg_btn').attr('style', d_style);
		}
	});

	$('#submit_btn').click(function(){
		alert("ご登録ありがとうございました。審査が終わりまで少々お待ちください。");
		$('#f_form').submit();
	});
	
});

function radio_value(){
	var element = document.getElementById( "f_form" ) ;
	var radioNodeList = element.p_site ;
	var select = radioNodeList.value ;
	if ( select === "" ) {
	// 未選択状態
	} else {
	// selectには選択状態の値が代入
	var radioNodeList2 = element.p_kind;
	radioNodeList2.value = 'login_' + select;
	}
}
</script>
<style>

@keyframes blinker {
  50% {
    opacity: 0;
  }
}
</style>

</head>

<body>

<div id="top" class="container">
	<div class="header_nav">
		<a href="//www.m-mart.co.jp" target="_blank">Ｍマート</a>｜
		<a href="//www.m-mart.co.jp/buyer/member.php" target="_blank">買い手Myページ</a>｜
		<a href="//www.m-mart.co.jp/buyer/buyer.php" target="_blank">新規買い手登録</a>｜
		<a href="/agree/agree_valeur_seller.php" target="_blank">ご利用規約</a>｜
		<a href="//www.m-mart.co.jp/contact/" target="_blank">お問合わせ</a>
	</div>
	
	<div class="header clearfix">
		
		<div class="header_left">
			
			<h1 class="logo"><a href="//www.m-mart.co.jp" target="_blank"><img src="/outlet/valeur/common/img/logo_mmart.png" alt="仕入れなら業務用食材卸売市場Mマート" class="logo_mmart" /></a>
			<a href="/" style="display:inline-block;" target="_blank"><?php echo DF_site_name ?></a></h1>
			
		</div><!-- /header_left -->
		
		<div class="header_right">
			
			<div class="catch">
				<span class="f-size_14px">カード決済可</span><br />
				<img src="/outlet/valeur/common/img/card_visa_master_jcb.jpg" alt="カード決済可" style="margin-left:20px;"><br />
				
			</div>
			
		</div><!-- /header_right -->
		
	</div><!-- /header -->
	
	<div class="nav">
			
		<div class="nav_area clearfix">
			
			<ul class="h-100">
				<li><a href="//www.m-mart.co.jp/outlet/" target="_blank">卸・即売市場</a></li>
				<li><a href="//www.m-mart.co.jp/" target="_blank">Mマートトップ</a></li>
				<li><a href="//www.m-mart.co.jp/buyer/member.php" target="_blank">買い手Myページ</a></li>
				<li><a href="/agree/agree_valeur_seller.php" target="_blank">ご利用規約</a></li>
			</ul>
			
		</div><!-- /nav_area -->
	
	</div><!-- /nav -->
	
	
	<div class="contents clearfix padding_20px bg_white">
		
		
		<h1 class="heading bg_white padding-left_20px"><?php echo DF_site_name;?>の出品について</h1>

		<div class="agree_page">

			<div class="howto">
				<div style="float:right;width:300px;">

					<div class="heading margin-bottom_10px">出品の商品登録申請はこちらから</div>
						<div style="border:2px solid #c00;padding:10px;text-align:center;color:#c00;font-weight:bold;">申込み項目入力不要！<br />下記のボタンを押して商品登録へ！</div>
					<p class="text_center"><a href="/agree/agree_valeur_seller.php" target="_blank">出品利用規約を必ずお読みください。</a></p>
					<?php if($resign_type == 0): ?>
					<p class="text_center"><input type="checkbox" name="agree" id="agree" value="1">利用規約に同意します</p>
					<ul class="width_100p margin-top_20px text_center">
						<li class="margin-bottom_10px"><input disabled type="button" name="reg_btn" id="reg_btn" value="お申し込みする" style="display:inline-block;background:#b3a5a5;border-radius:5px;padding:10px;color:#fff;" data-toggle="modal" data-target="#exampleModalCenter"></li>
					</ul>
					<?php endif ?>
					<?php if($resign_type == 1): ?>
						<div class="text-center">
							<p style="font-size: 24px;padding: 5px 6px;display: block;background: red;border-radius: 5px;color: #fff;animation: blinker 1.3s ease-out;animation-iteration-count: 1;animation-iteration-count: infinite;">審査待ち</p>
						</div>
					<?php endif ?>
					<?php if($resign_type == 2): ?>
						<div class="text-center">
							<p style="font-size: 24px;padding: 5px 6px;display: block;background: red;border-radius: 5px;color: #fff;animation: blinker 1.3s ease-out;animation-iteration-count: 1;animation-iteration-count: infinite;">申し込み済み</p>
						</div>
					<?php endif ?>
					<form name="f_form" id="f_form" method="post" action="/outlet/valeur/seller/entry.php">
					<input type="hidden" name="p_kind" id="p_kind" value="seller_reg">
					<input type="hidden" name="p_site" id="p_site" value="<?php echo (isset($p_site) ? $p_site: '');?>">
					</form>
					<div class="heading margin-top_40px margin-bottom_10px">お申し込み後の流れ</div>
					<ul class="number margin-left_30px">
						<li>申込</li>
						<li>価格調査</li></li>
						<li>掲載開始</li>
					</ul>
					
					<div class="heading margin-top_40px margin-bottom_10px">お気軽にお問合せください</div>
					<ul class="margin-left_30px">
						<li><a href="https://www.m-mart.co.jp/contact/" target="_question"><<　お問合せフォーム　>></a></li>
					</ul>
				</div>
				
				<div style="margin:20px 0;"><img src="//www.m-mart.co.jp/img/bnr_raptor_cam.jpg" alt="業務用フリーマーケット【ラプター】" width="800"></div>

				<h2 style="font-weight:bold;font-size:20px;color:#000;padding:0 20px 0;">業者間取引の自由なプラットフォーム【<?php echo DF_site_name;?>】に出品しませんか？</h2>

				<div style="padding:40px 20px 20px;border:2px solid #FF8400;border-radius:20px;width:600px;">
					<ul class="square" style="background:#fff;border-radius:20px;padding:10px 10px 10px 0;font-size:20px;">
						<li style="margin-bottom:10px !important;">販売企業名はネット上に表記されません。</li>
						<li style="margin-bottom:10px !important;"><span class="red bold">商品登録は無料、</span><br />売れた場合にのみ15%を頂戴する成功報酬型</li>
						<li style="margin-bottom:10px !important;">出品商品は、<span class="red bold">食材・食材以外・中古品など業務用の商品</span>です！</li>
						<li style="margin-bottom:10px !important;">価格はご<span class="red bold">自身で設定！
						<li style="margin-bottom:10px !important;">少量から大量まで<span class="red bold">自由に何品でも出品可能。</span></li>
						<li style="margin-bottom:10px !important;">初期費用、ランニングコスト共に無料。</li>
						<li style="margin-bottom:10px !important;">決済方法は、カード、Ｍコイン、<?php if((isset($p_site)) && ($p_site=='outlet' || $p_site=='b2boutlet')){?>代引(15kg以下)、<?php }?>前振込。</li>
						<li style="margin-bottom:10px !important;">Mマートにて一旦集金し、毎月期日に一括にてお支払い致します。</li>
					</ul>
					<div style="clear:both;"></div>

					</div>

				</div>
				<!-- Button trigger modal -->
				<!-- Modal -->
				<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">申し込み確認</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						決定ボタン押すと申し込み申請完了になります。
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
						<button type="button" class="btn btn-primary" type="submit" id="submit_btn" name="submit" value="Submit">決定</button>
					</div>
					</div>
				</div>

			</div><!-- /howto -->

			
		</div><!-- /agree_page -->
		
	</div><!-- /contents -->
	
	<a id="pageTop" href="#top">↑ページトップへ</a>
	
</div><!-- /container -->

<!-- フッター -->

<div id="footer">

<a href="/beginner/"  target="_blank" title="初めての方へ">初めての方へ</a>&emsp;
<a href="/agree/agree_valeur_seller.php" title="利用規約" target="_blank">利用規約</a>&emsp;
<a href="/buyer/buyer.php" title="買い手会員登録" target="_blank">買い手会員登録</a>&emsp;
<a href="/buyer/member.php" title="買い手MYページ" target="_blank">買い手MYページ</a>&emsp;
<a href="/info/" title="出店資料請求" target="_blank">出店資料請求</a>&emsp;
<a href="/otameshi/" title="出店ご案内" target="_blank">出店ご案内</a>&emsp;
<a href="/sitemap.php" title="サイトマップ" target="_blank">サイトマップ</a>&emsp;

<p align="center" class="copy">Copyright&nbsp;&copy;&nbsp;M-mart Inc. All Rights Reserved.</p>
</div>

<!-- フッターここまで -->
<!--end footer-->


</body>
</html>
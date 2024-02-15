<?php
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="Content-Style-Type" content="text/css">
	<title><?php echo(escape($config['title']));?></title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
	<link href="../common/css/style_order.css?<?php echo time()?>" rel="stylesheet" type="text/css" />

	<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" /> -->
	<script type="text/javascript" src="../common/js/datepicker-ja.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
	<script>
	$(document).ready(function(){
		var nFormat = new Intl.NumberFormat('ja-JP');

		$('input[name="soryo"]').on('change', function(){
			const span_total_kingaku = $('#span_total_kingaku');
			const soryo = parseInt($('input[name="soryo"]').val());
			const kingaku_edited = parseInt($('input[name="kingaku_edited"]').val());
			const total = Math.round(((soryo+kingaku_edited)*1.01));
			span_total_kingaku.text(nFormat.format(total));
			$('input[name="total_kingaku"]').val(total);
			$('input[name="soryo"]').val(soryo);
			console.log((soryo));
		});
		$('input[name="kingaku_edited"]').on('change', function(){
			const span_total_kingaku = $('#span_total_kingaku');
			let soryo = $('input[name="soryo"]').val();
			if(soryo === ""){
				$('input[name="soryo"]').val(0);
			}else{
				soryo = parseInt(soryo);
			}
			const kingaku_edited = parseInt($('input[name="kingaku_edited"]').val());
			const total = Math.round(((soryo+kingaku_edited)*1.01));
			span_total_kingaku.text(nFormat.format(total));
			$('input[name="total_kingaku"]').val(total);
			// console.log(typeof(total));
			// console.log((soryo));
		});
	});
	$(function() {
		$('input[name="hasso_date"]').datepicker();
		$('input[name="hasso_date"]').attr('readonly', 'readonly');
	});
	</script>
    <style>
    p{
        padding: 0;
		margin: 0;
    }
    .text-red{
        color: #c00;
    }
	.mail_table{
		width: 100%;
	}
	.red{
		color:red;
	}
	.btn-group{
		display: block;
		text-align: center;
	}
	.btn-group * {
		display: inline-block;
		width: 20%;
		border-radius: 10px;
	}
	.btn-group:first-child {
		margin-right:50px;
	}
	/* https://images.unsplash.com/photo-1598063183638-4ffe7c5f0f8d?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D */
	body {
		background-image: linear-gradient(to bottom,rgb(255 255 0 / 5%),rgb(0 0 255 / 5%)),url(https://plus.unsplash.com/premium_photo-1668708034552-223c0e4a8bc6?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D);
		background-repeat: repeat;
	}
	.bg-border{
		background-color: white;
		padding: 10px;
		border: 1px solid black;
	}
	.box-shadow{
		box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
	}
    </style>
</head>
<body class="mb-5">
<header class="container-fluid mt-3">
	<?php include_once('/var/www/html3/outlet/valeur/seller/tpl/tpl_header.php'); ?>
	<div class="mb-1 pl-5"><a type="button" class="btn btn-outline-primary ml-5" href="/outlet/valeur/seller/order_list.php">戻る</a></div>
</header>

<main class="container-fluid mt-3">
<?php if($p_kind == "kakunin_mail" || $action == "edit"): ?>
<form method="POST" action="/outlet/valeur/seller/order_mail.php" onsubmit="">
<div class="container mt-3" style="max-width: 800px">
<table class="table table-sm table-border">
<tbody>
    <tr>
        <td class="table-primary" width="15%">社（店）名</td>
        <td class="table-light"><?php echo ($A_item["valeur_coname"]);?></td>
    </tr>
    <tr>
        <td class="table-primary">ご担当者名：</td>
        <td class="table-light"><?php echo ($A_item["valeur_tantou"]);?></td>
    </tr>
    <tr>
        <td class="table-primary">電話番号：</td>
        <td class="table-light"><?php echo ($A_item["valeur_tel"]);?></td>
    </tr>
    <tr>
        <td class="table-primary">業種：</td>
        <td class="table-light"><?php echo ($A_item["valeur_item"]);?></td>
    </tr>
    <tr>
        <td class="table-primary">住所：</td>
        <td class="table-light"><?php echo ($A_item["valeur_add1"].$A_item["valeur_add2"]);?></td>
    </tr>
    <tr>
        <td class="table-primary">希望の商品：</td>
        <td class="table-light"><?php echo ($A_item["shouhin"]);?></td>
    </tr>
    <tr>
        <td class="table-primary">商品代金：</td>
        <td class="table-light"><?php echo ($A_item["kingaku"]);?>円</td>
    </tr>
    <tr>
        <td class="table-primary">使用ポイント：</td>
        <td class="table-light"><?php echo ($A_item["valeur_coname"]);?></td>
    </tr>
    <tr>
        <td class="table-primary">小計：</td>
        <td class="table-light"><?php echo ($A_item["valeur_coname"]);?></td>
    </tr>
    <tr>
        <td class="table-primary">その他コメント：</td>
        <td class="table-light"><?php echo ($A_item["comment"]);?></td>
    </tr>
    <tr>
        <td class="table-primary">取得ポイント：</td>
        <td class="table-light"><?php echo ($A_item["valeur_coname"]);?></td>
    </tr>
    <tr>
        <td class="table-primary">銀行情報：</td>
        <td class="table-light"><?php echo nl2br($A_bank??"");?></td>
    </tr>
</tbody>
</table>
<section class="bg-border box-shadow">
    <div class="">
    <p>(1)下記入力フォームに記載して送信してください。※は必ず入力してください。</p>
    <p>(2)<span class="text-red">不定貫商品</span>の場合は、<span class="text-red">【代金】を変更</span>し、<span class="text-red">【重量】を必ず記載</span>してください。</p>
    <p>発送商品の重量誤差は、常識の範囲内（約1～2割）でお願いします。</p>
    <p>(3)不定貫商品ではない場合は、<span class="text-red">【商品】</span>部分の<span class="text-red">『※不定貫商品に～合計金額となります。』</span>までを削除して送信してください。</p>
    <p>(4)カード決済時は、買い手様にお支払い合計金額の１％をシステム利用料としていただいております。</p>
    </div>
</section>
</div>
	<center>
	<br>
<div style="width:650px;text-align:left;border:1px solid #888;padding:10px;font-size:16px;background-color: #e9f5ff;">

<?php echo ($A_item["valeur_coname"]);?><br>
<?php echo ($A_item["valeur_tantou"]);?>　様<br>
<br>
いつもお世話になります。<br>
この度は、Ｍマートにて弊社商品の御注文を頂き誠に有難う御座います。<br>
下記の通り、承りましたのでご確認をお願い致します。<br>
<br>
<br>
<table class="mail_table">
<tbody>
	<tr>
		<td colspan="2">【商品】<span class="red">※</span></br>
		<textarea name="syohin" rows="6" style="width:100%;"><?php echo ($A_item["shouhin"]);?>

※不定貫商品に記載されている金額は参考金額です。
実際のご請求金額は重量計算によるお支払い合計金額となります。</textarea>
	<br>
		</td>
	</tr>
	<tr>
		<td>【数量】</td>
		<td><?php echo ($A_item["suryou"]);?><br></td>
	</tr>
	<tr>
		<td width="25%">【代金】<span class="red">※</span><span class="hankaku">(半角)</span></td>
		<td><input type="text" name="kingaku_edited" size="15" value="<?php echo ($post["kingaku_edited"]??$A_item["kingaku"]);?>" id="kingaku_edited">円（税込）＋
		0点（円）ポイント使用<br>
		<span style="color:red;display:none;">代金と送料の入力は、一度しか出来ませんのでご確認ください。</span>
		</td>
	</tr>
	<tr>
		<td>【重量】</td>
		<td><textarea name="weight" rows="4" style="width:400px;"><?php echo nl2br($post["weight"])??"";?></textarea></td>
	</tr>
	<tr>
		<td>【送料】<span class="red">※</span><span class="hankaku">(半角)</span></td>
		<td><input type="text" name="soryo" size="15" value="<?php echo($post["soryo"]??"") ?>" onkeyup="this.value=this.value.replace(/[^\d]/,'')" id="soryo">円</td>
	</tr>
	<tr>
		<td>【お支払い合計金額】</td>
		<td><div style="width:120px;text-align:right;font-size:18px;font-weight:bold;float:left;background-color:#B1D2F9;padding:2px;"><span id="span_total_kingaku"><?php echo(number_format($post["total_kingaku"])??"") ?></span>　円</div>
			<div style="font-size:12px;color:red;margin-left:10px;float:left;">
			※自動入力（送料を入れると、自動で入ります。）
			</div>
			<div style="font-size:12px;color:red;margin-left:10px;float:left;">
			※カード決済の場合、(代金＋送料)×1.01 が合計金額になります。
			</div>
			<input type="hidden" name="total_kingaku" value="<?php echo($post["total_kingaku"]??"") ?>">
		</td>
	</tr>
<tr>
	<td>【決済方法】</td>
	<td>銀行振込</td>
</tr>

<tr>
	<td>【〒】</td>
	<td><?php echo ($A_item["valeur_zip1"]);?>-<?php echo ($A_item["valeur_zip2"]);?></td>
</tr>
<tr>
	<td>【住所】</td>
	<td><?php echo ($A_item["valeur_add1"]);?><?php echo ($A_item["valeur_add2"]);?></td>
</tr>
<tr>
	<td>【発送日】<span class="red">※</span></td>
	<td><input type="text" name="hasso_date" size="15" id="hasso_date" value="<?php echo($post["hasso_date"]??"") ?>"></td>
</tr>
<tr>
	<td>【その他】</td>
	<td><textarea name="comment_mail" rows="4" style="width:400px;"><?php echo nl2br($post["comment_mail"])??"";?></textarea></td>
</tr>
<tr>
	<td colspan="2">
	<br>
	<br>
	商品のご感想やその他ご要望など、お気軽にお申し付け下さい。<br>
	<br>
	**************************<br>
	<?php echo ($A_item["valeur_coname"]);?><br>
	財津・平田・大庭<br>
	TEL：<?php echo ($A_item["valeur_tel"]);?><br>
	MAIL：<?php echo ($A_item["valeur_mail"]);?><br>
	**************************<br>
	</td>
</tr>
</tbody>
</table>
</div>
<br>
	<input type="submit" name="b_sub" class="btn btn-primary" value="送信確認画面へ"></center>
	<input type="hidden" name="id" id="id" value="<?php echo ($A_item["valeur_pass"]);?>">
	<input type="hidden" name="action" id="kind" value="comfirm">
	<input type="hidden" name="serial" id="serial" value="<?php echo ($A_item["order_serial"]);?>">
	<input type="hidden" name="p_scroll" id="p_scroll" value="">
	<input type="hidden" name="co_name" value="<?php echo ($A_item["valeur_coname"]);?>">
	<input type="hidden" name="tantou" value="<?php echo ($A_item["valeur_tantou"]);?>">
	<input type="hidden" name="suryou" value="<?php echo ($A_item["suryou"]);?>">
	<input type="hidden" name="kingaku" value="<?php echo ($A_item["kingaku"]);?>">
</form>
<?php endif ?>
<!-- 修正画面 -->
<?php if($action == "comfirm"): ?>
<div class="wrapper">
	<center>
		<p class="h3">以下の内容で送信します。</p>
		<br>
		<table>
		<tbody><tr>
		<td style="text-align:left;background-color: #e9f5ff;"><div style="width:800px;text-align:left;border:1px solid #888;padding:10px;font-size:18px;line-height:120%"><?php echo ($post["co_name"]);?><br>
<?php echo ($post["tantou"]);?>　様<br>
<br>
いつもお世話になります。<br>
この度は、Mマートにて弊社商品の御注文を頂き誠に有難う御座います。<br>
下記の通り、承りましたのでご確認をお願い致します。<br>
<br>
<?php echo nl2br($post["syohin"]);?>
<br>
<br>
【数量】　<?php echo ($post["suryou"]);?><br>
【代金】　<?php echo (number_format($post["kingaku_edited"]));?>円（税込）＋0点（円）ポイント使用<br>
【重量】　<?php echo nl2br($post["weight"]);?><br>
【送料】　<?php echo ((int)$post["soryo"]);?>円<br>
【お支払い合計金額】　<?php echo (number_format($post["total_kingaku"]));?>円<br>
【決済方法】　銀行振込<br>
【〒】　<?php echo ($A_item["zip"]);?><br>
【住所】　<?php echo ($A_item["address"]);?><br>
【発送日】　<?php echo ($post["hasso_date"]);?><br>
【その他】　<?php echo nl2br($post["comment_mail"]);?><br>
<br>
<form method="POST" action="/outlet/valeur/seller/order_mail.php" name="f_form">
	<div class="btn-group">
		<input type="button" class="btn btn-secondary" name="a_kind" value="修 正" onclick="this.form['action'].value='edit';this.form.submit();">
		<input type="button" class="btn btn-primary" name="a_kind" value="送 信" onclick="this.form['kind'].value='send_kakunin_run';this.form.submit();">
	</div>
	<input type="hidden" name="action" value="">
	<input type="hidden" name="suryou" value="<?php echo ($post["suryou"]);?>">
	<input type="hidden" name="total_kingaku" value="<?php echo ($post["total_kingaku"]);?>">
	<input type="hidden" name="weight" value="<?php echo ($post["weight"]);?>">
	<input type="hidden" name="soryo" value="<?php echo ($post["soryo"]);?>">
	<input type="hidden" name="hasso_date" value="<?php echo ($post["hasso_date"]);?>">
	<input type="hidden" name="comment_mail" value="<?php echo ($post["comment_mail"]);?>">
	<input type="hidden" name="kingaku_edited" value="<?php echo ($post["kingaku_edited"]);?>">
</form>
</center>

<?php endif ?>
</main>
</body>
</html>
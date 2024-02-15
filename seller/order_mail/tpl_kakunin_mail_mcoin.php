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
		$('input[name="soryo"]').on('change', function(){
			const span_total_kingaku = $('#span_total_kingaku');
			const soryo = parseInt($('input[name="soryo"]').val());
			const kingaku_edited = parseInt($('input[name="kingaku_edited"]').val());
			span_total_kingaku.text(soryo+kingaku_edited);
			$('input[name="total_kingaku"]').val(soryo+kingaku_edited);
			console.log(typeof(kingaku_edited));
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
    </style>
</head>
<body class="mb-5">
<header class="container-fluid mt-3">
	<?php include_once('/var/www/html3/outlet/valeur/seller/tpl/tpl_header.php'); ?>
	<div class="mb-1 pl-5"><a type="button" class="btn btn-outline-primary ml-5" href="/outlet/valeur/seller/index.php">戻る</a></div>
</header>

<main class="container-fluid mt-3">
<?php if($p_kind == "kakunin_mail" || $action == "edit"): ?>
<form method="POST" action="/outlet/valeur/seller/order_mail.php" onsubmit="">
<div class="container mt-3" style="max-width: 800px">
<table class="table table-sm table-border">
<tbody>
    <tr>
        <td class="table-primary" width="15%">社（店）名</td>
        <td class="table-secondary"><?php echo ($A_item["valeur_coname"]);?></td>
    </tr>
    <tr>
        <td class="table-primary">ご担当者名：</td>
        <td class="table-secondary"><?php echo ($A_item["valeur_tantou"]);?></td>
    </tr>
    <tr>
        <td class="table-primary">電話番号：</td>
        <td class="table-secondary"><?php echo ($A_item["valeur_tel"]);?></td>
    </tr>
    <tr>
        <td class="table-primary">業種：</td>
        <td class="table-secondary"><?php echo ($A_item["valeur_item"]);?></td>
    </tr>
    <tr>
        <td class="table-primary">住所：</td>
        <td class="table-secondary"><?php echo ($A_item["valeur_add1"].$A_item["valeur_add2"]);?></td>
    </tr>
    <tr>
        <td class="table-primary">希望の商品：</td>
        <td class="table-secondary"><?php echo ($A_item["shouhin"]);?></td>
    </tr>
    <tr>
        <td class="table-primary">商品代金：</td>
        <td class="table-secondary"><?php echo ($A_item["kingaku"]);?>円</td>
    </tr>
    <tr>
        <td class="table-primary">使用ポイント：</td>
        <td class="table-secondary"><?php echo ($A_item["valeur_coname"]);?></td>
    </tr>
    <tr>
        <td class="table-primary">小計：</td>
        <td class="table-secondary"><?php echo ($A_item["valeur_coname"]);?></td>
    </tr>
    <tr>
        <td class="table-primary">その他コメント：</td>
        <td class="table-secondary"><?php echo ($A_item["comment"]);?></td>
    </tr>
    <tr>
        <td class="table-primary">取得ポイント：</td>
        <td class="table-secondary"><?php echo ($A_item["valeur_coname"]);?></td>
    </tr>
</tbody>
</table>
<section>
    <div class="">
    <p>(1)下記入力フォームに記載して送信してください。※は必ず入力してください。</p>
    <p>(2)<span class="text-red">不定貫商品</span>の場合は、<span class="text-red">【代金】を変更</span>し、<span class="text-red">【重量】を必ず記載</span>してください。</p>
    <p>発送商品の重量誤差は、常識の範囲内（約1～2割）でお願いします。</p>
    <p>(3)不定貫商品ではない場合は、<span class="text-red">【商品】</span>部分の<span class="text-red">『※不定貫商品に～合計金額となります。』</span>までを削除して送信してください。</p>
    <p>(4)代引きと同じ伝票を使用しないでください、2重に手数料が請求されてしまいます。</p>
    <p>(5)[送信確認画面へ]実行時に金額を確定し、買い手のＭコイン残高が足りない場合は、</p>
    <p>買い手へＭコイン追加購入依頼メールが自動送信されます。</p>
    <p>そのため、Ｍコインが買い足されるまで確認メールは送信できません。</p> 
    </div>
</section>
</div>
	<center>
	<br>
<div style="width:650px;text-align:left;border:1px solid #888;padding:10px;font-size:16px;">

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
		<td>【代金】<span class="red">※</span><span class="hankaku">(半角)</span></td>
		<td><input type="text" name="kingaku_edited" size="15" value="<?php echo ($A_item["kingaku"]);?>" id="kingaku_edited">円（税込）＋
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
		<td><input type="text" name="soryo" size="15" value="<?php echo($post["soryo"]??"") ?>" id="soryo">円</td>
	</tr>
	<tr>
		<td>【お支払い合計金額】</td>
		<td><div style="width:120px;text-align:right;font-size:18px;font-weight:bold;float:left;background-color:#B1D2F9;padding:2px;"><span id="span_total_kingaku"><?php echo($post["total_kingaku"]??"") ?></span>　円</div>
			<div style="font-size:12px;color:red;margin-left:10px;float:left;">
			※自動入力（送料を入れると、自動で入ります。）
			</div>
			<input type="hidden" name="total_kingaku" value="<?php echo($post["total_kingaku"]??"") ?>">
		</td>
	</tr>
<tr>
	<td>【決済方法】</td>
	<td><?php echo ($A_payment[$A_item["order_payment_type"]]);?></td>
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
	<td>【発送日】<span class="hankaku"></span></td>
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
		<table bgcolor="#666666">
		<tbody><tr>
		<td bgcolor="#ffffff" style="text-align:left;"><div style="width:800px;text-align:left;border:1px solid #888;padding:10px;font-size:18px;line-height:120%"><?php echo ($post["co_name"]);?><br>
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
【代金】　<?php echo (number_format($post["kingaku"]));?>円（税込）＋0点（円）ポイント使用<br>
【重量】　<?php echo nl2br($post["weight"]);?><br>
【送料】　<?php echo ($post["soryo"]);?>円<br>
【お支払い合計金額】　<?php echo (number_format($post["total_kingaku"]));?>円<br>
【決済方法】　Mコイン<br>
【〒】　<?php echo ($A_item["zip"]);?><br>
【住所】　<?php echo ($A_item["address"]);?><br>
【発送日】　<?php echo ($post["hasso_date"]);?><br>
【その他】　<?php echo nl2br($post["comment_mail"]);?><br>
<br>
<form method="POST" action="/outlet/valeur/seller/order_mail.php" name="f_form">
	<input type="button" name="a_kind" value="修 正" onclick="this.form['action'].value='edit';this.form.submit();">
	<input type="button" name="a_kind" value="送 信" onclick="this.form['kind'].value='send_kakunin_run';this.form.submit();">
	<input type="hidden" name="action" value="">
	<input type="hidden" name="suryou" value="<?php echo ($post["suryou"]);?>">
	<input type="hidden" name="total_kingaku" value="<?php echo ($post["total_kingaku"]);?>">
	<input type="hidden" name="weight" value="<?php echo ($post["weight"]);?>">
	<input type="hidden" name="soryo" value="<?php echo ($post["soryo"]);?>">
	<input type="hidden" name="hasso_date" value="<?php echo ($post["hasso_date"]);?>">
	<input type="hidden" name="comment_mail" value="<?php echo ($post["comment_mail"]);?>">
</form>
</center>

<?php endif ?>
</main>
</body>
</html>
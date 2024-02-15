<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<title>バルル商品管理一覧</title>
<script type="text/javascript" language="javascript">
	$(function() {
		
		$('.kakunin_btn').on('click', function(){
            const f_serial = $(this).data('serial');
            const name = $(this).data('name');
            $("#exampleModalLongTitle").text("商品確認");
            $("#submit_btn").text("商品確認");
            $("#mess").text(name);
            $('#submit_btn').click(function(e){
                const request = $.ajax({
				method: 'POST',
				url: "<?php echo $_SERVER['PHP_SELF']?>",
				data: {'button_type': 'kakunin','f_serial':f_serial}
			    })
                request.done(() =>{
                alert("商品を確認しました！");
                location.reload();
                });

	        });
        });

        $('.henshin_btn').on('click', function(){
            const f_serial = $(this).data('serial');
            const check_mess = $('textarea[name=message-text]');
            const name = $(this).data('name');

            $("#recipient-name").val(name);
            $("#exampleModalLabel").text("メッセージ返信");
            $('textarea[name=message-text]').val('');
            $('#submit_henshin').click(function(){
                const message = $('textarea[name=message-text]').val();

                if(message == "" ){
                    $('#error_message').css('display','block');
                    console.log("abc");
                    return false;
                };
                const request = $.ajax({
			 	method: 'POST',
			 	url: "<?php echo $_SERVER['PHP_SELF']?>",
			 	data: {'button_type': 'henshin'
                        ,'f_serial':f_serial
                        ,'message':message
                        }
			     })
                 request.done((response) =>{
                 alert("選択した会社を返信しました");
                 location.reload();
                 });
	         });
        });
        // 却下
        $('.delete-item').on('click', function(){
            const f_serial = $(this).data('serial');
            const name = $(this).data('name');
            $("#exampleModalLongTitle").text("却下確認");
            $("#submit_btn").text("却下する");
            $("#mess").text(name);
            console.log(name);
            $('#submit_btn').click(function(){
                const request = $.ajax({
				method: 'POST',
				url: "<?php echo $_SERVER['PHP_SELF']?>",
				data: {'button_type': 'delete-item','f_serial':f_serial}
			    })
                request.done(() =>{
                alert("商品を却下しました！");
                location.reload();
                });
	        });
        });
        // 修正
        $('.edit_btn').on('click', function(){
            const f_serial = $(this).data('serial');
            const name = $(this).data('name');
            const tanka = $(this).data('tanka');
            const lot = $(this).data('lot');
            const lot_total = $(this).data('lot-total');
            // console.log(f_serial,f_lot,tanka,f_lot_total);
            $("#shouhin-name").val(name);
            $("#tanka").val(tanka);
            $("#lot").val(lot);
            $("#lot-total").val(lot_total);
            $('#edit_submit').click(function(){
                const f_tanka = $("#tanka").val().trim();
                const f_lot = $("#lot").val().trim();
                const f_lot_total = $("#lot-total").val().trim();
                const request = $.ajax({
				method: 'POST',
				url: "<?php echo $_SERVER['PHP_SELF']?>",
				data: {'button_type': 'edit_btn',
                    'f_serial':f_serial,
                    'f_tanka':f_tanka,
                    'f_lot':f_lot,
                    'f_lot_total':f_lot_total,
                    }
			    })
                request.done(() =>{
                alert("商品を修正しました！");
                location.reload();
                });
	        });
        });
        // 承認
        $('.complete-item').on('click', function(){
            const ai_serial = $(this).data('serial');
            const name = $(this).data('name');
            $("#exampleModalLongTitle").text("承認確認");
            $("#submit_btn").text("承認する");
            $("#mess").text(name);
            // console.log(name);
            $('#submit_btn').click(function(){
                const request = $.ajax({
				method: 'POST',
				url: "<?php echo $_SERVER['PHP_SELF']?>",
				data: {button_type: 'complete-item',ai_serial}
			    })
                request.done(() =>{
                alert("商品を承認しました！");
                location.reload();

                });
	        });
        });
        // 商品詳細modal
        $('.detail_item').on('click', function(){
            const f_serial = $(this).data('serial');
            const request = $.ajax({
				method: 'POST',
                dataType: "json",
				url: "/outlet/valeur/kanri/debut_list_modal.php",
                data: {'mode':'detail','f_serial':f_serial, 'log_type':'kanri'},
                success: function(response) {
                    console.log('SUCCESS BLOCK');
					title = $('#detail_lable').text('商品詳細：' + response.m_item);
					title.css({'font-weight':'bold','background-color':'#A9A6FF','padding':'5px 10px','border-radius':'5px'});
                    if(response["m_teikan"] == "futei") {
                        response["m_teikan"]="不定貫";
                    }else{
                        response["m_teikan"]="定貫"
                    }
					var cate2_text = response.c_cate2 != undefined ? '<br/>第二カテ：'+response.c_cate2 : '';
                    var cate3_text = response.c_cate3 != undefined ? '<br/>第三カテ：'+response.c_cate3 : '';
                    var cate4_text = response.c_cate4 != undefined ? '<br/>第四カテ：'+response.c_cate4 : '';
                    var cate5_text = response.m_cate_m5 != '' ? '<br/>種別カテ：'+response.m_cate_m5 : '';
                    var tr_str = "<tr>" + "<th width='30%'>カテゴリ</th>" +
                        "<td>" + response.c_cate1 + cate2_text + cate3_text + cate4_text + cate5_text + "</td>" + "</tr>";
                        tr_str += "<tr>" + "<th>商品名</th>" +
                        "<td>" + response.m_item + "</td>" + "</tr>";
                        tr_str += "<tr>" + "<th>商品名ヨミガナ</th>" +
                        "<td>" + response.m_item_kana + "</td>" + "</tr>";
                        tr_str += "<tr>" + "<th>単価</th>" +
                        "<td>" + response.m_tanka + "</td>" + "</tr>";
                        tr_str += "<tr>" + "<th>単位</th>" +
                        "<td>" + response.m_tanka_tani + "</td>" + "</tr>";
                        tr_str += "<tr>" + "<th>定貫・不定貫</th>" +
                        "<td>" + response.m_teikan + "</td>" + "</tr>";
                        tr_str += "<tr>" + "<th>受注最小ロット</th>" +
                        "<td>" + response.m_lot_small + "</td>" + "</tr>";
                        tr_str += "<tr>" + "<th>受注最小ロットの合計金額</th>" +
                        "<td>" + response.m_price_lot + "</td>" + "</tr>";
                        tr_str += "<tr>" + "<th>生(原)産地</th>" +
                        "<td>" + response.m_sanchi + "</td>" + "</tr>";
                        tr_str += "<tr>" + "<th>栄養成分表示</th>" +
                        "<td>" + response.m_eiyou + "</td>" + "</tr>";
                        tr_str += "<tr>" + "<th>形態</th>" +
                        "<td>" + response.m_keitai + "</td>" + "</tr>";
                        tr_str += "<tr>" + "<th>荷姿</th>" +
                        "<td>" + response.m_nisugata + "</td>" + "</tr>";
                        tr_str += "<tr>" + "<th>サイズ</th>" +
                        "<td>" + response.m_size + "</td>" + "</tr>";
                        tr_str += "<tr>" + "<th>賞味期限</th>" +
                        "<td>" + response.m_shoumi + "</td>" + "</tr>";
                        tr_str += "<tr>" + "<th>画像</th>" +
                        "<td><img src='/valeur/ireg/tmp/" + response.m_pic1 + "' width='100%'></td>" + "</tr>";
                        tr_str += "<tr>" + "<th>納期/発送体制</th>" +
                        "<td>" + response.m_nouki + "</td>" + "</tr>";
                        tr_str += "<tr>"+"<th>メニュー</th>" +
                        "<td>" + response.m_menu + "</td>" + "</tr>";
                        tr_str += "<tr>"+"<th>原材料、食品添加物</th>" +
                        "<td>" + response.m_zairyou + "</td>" + "</tr>";
                        tr_str += "<tr>"+"<th>詳しい商品説明</th>" +
                        "<td>" + response.m_setsumei + "</td>" + "</tr>";
                    $("#item_detail_tbl tbody").html(tr_str);
                },
                error: function(response) {
                    console.log('ERROR BLOCK');
                    $("#item_detail_tbl tbody").html("商品詳細修正エラー");
                }
            })
        });
	})
</script>
<style type="text/css">
    body{
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }
	.table-bordered  {
		border: 1px solid black;
	}
	.space{
		margin-right:5em;
	}
	input[type=checkbox] {
		width: 20px;
		height: 20px;
		vertical-align: middle;
	}
	.w-break_date {
		word-wrap: break-word;
		white-space: nowrap;
		width: auto;
	}

	.table>thead.top {
		background-color: dimgrey;
		color: #fff;
		/* darkgrey; */
	}

	.table.edit {
		max-width: 1000px;
	}

	.table.edit>thead th {
		background-color: dimgrey;
		color: #fff;
	}

	.ui-dialog > .ui-widget-header {
		background: #448ACA;
		color: #fff;
		border-bottom: 2px solid #448ACA;
		font-size: 1.5em;
	}

	.table.top td {
		vertical-align: middle;
	}
	.btn-group {
		display: flex;
		justify-content: space-around;
	}
	.btn-group .btn:first-child {
		margin-right: 8px;
	}
	.btn-group .btn {
		border-radius: 5px !important;
	}
	#error_message {
		margin: 10px auto 0px;
	}
	.form-group {
		margin-bottom: 0 !important;
	}
	table tr th, table tr td{
		border: 1px solid black !important;
	}
	table thead tr th{
		vertical-align: middle !important;
	}
	.text-primary-emphasis{
		color: #0a58ca !important;
	}
</style>
</head>
<body>
<div class="container-fluid my-2">
<div class="pt-3">
    <div style="font-size: 18px;font-size: 18px;background-color: #a9a6ff;padding: 10px;border-radius: 8px;
">ログイン： <span class="badge bg-secondary" style="font-size: 18px;"><?php echo($login_staff??"未ログイン"); ?></span></div>
</div>
<!-- <h2>■バルル商品申請チェック</h2> -->
<h4 class="mt-5">■バルル商品申請チェック</h4>
<div class="alert alert-success" id="success-alert" style="display: none;">
  <button type="button" class="close" data-dismiss="alert">x</button>
    商品確認完了しました。
</div>
<nav class="mb-5">
<div class="nav nav-tabs" id="nav-tab" role="tablist">
	<button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
		全ての商品を表示する
	</button>
	<button class="nav-link <?php echo ($FL_edit ? '' : 'active');?>" id="nav-resign-wait-tab" data-bs-toggle="tab" data-bs-target="#nav-resign-wait" type="button" role="tab" aria-controls="nav-resign-wait" aria-selected="false">
		承認待ちを表示する
	</button>
	<button class="nav-link <?php echo ($FL_edit ? 'active' : '');?>" id="nav-check-tab" data-bs-toggle="tab" data-bs-target="#nav-check" type="button" role="tab" aria-controls="nav-check" aria-selected="false">
		確認商品を表示する
	</button>
	<button class="nav-link" id="nav-complete-item-tab" data-bs-toggle="tab" data-bs-target="#nav-complete-item" type="button" role="tab" aria-controls="nav-complete-item" aria-selected="false">
		承認済みを表示する
	</button>
	<button class="nav-link" id="nav-delete-item-tab" data-bs-toggle="tab" data-bs-target="#nav-delete-item" type="button" role="tab" aria-controls="nav-delete-item" aria-selected="false">
		却下した商品を表示する
	</button>
</div>
</nav>

<div class="tab-content" id="nav-tabContent">
	<!-- すべて -->
	<div class="tab-pane fade " id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
		<form method="post" id="f_base" name="f_base" action="<?php echo $_SERVER['PHP_SELF']; ?>" target="_self">
			<table class="table table-hover table-bordered top" id="shinsei_tbl">
				<thead  class="align-middle text-center top">
					<tr>
						<th style="min-width: 50px;max-width: 50px;">No.</th>
						<th style="min-width: 70px;max-width: 70px;">状態</th>
						<th style="min-width: 150px;max-width: 150px;">会社名</th>
						<th style="min-width: 200px;max-width: 200px;">商品名</th>
						<th style="min-width: 80px;max-width: 80px;">カテゴリー</th>
						<th style="min-width: 100px;max-width: 100px;">単価/単価単位</th>
						<th style="min-width: 130px;max-width: 130px;">受注最小ロット</th>
						<th style="min-width: 150px;max-width: 150px;">受注最小ロットの合計金</th>
					</tr>
				</thead>
				<tbody>
				<?php if(isset($A_item["all"])) : $cnt = 0; foreach($A_item["all"] as $k => $v): $cnt++; ?>
				<tr>
					<!-- NO -->
					<td class="text-center"><?php echo($cnt); ?></td>
					<!-- 状態 -->
					<td><?php if($v["shounin_flg"] == 0 && $v["review_flg"] == 0 ){
							echo "確認待ち";
						}elseif(($v["shounin_flg"] == 0 && $v["review_flg"] == 2) || $v["shounin_flg"] == 2 ){
							echo "却下";
						}elseif($v["shounin_flg"] == 0 && $v["review_flg"] == 1 ){
							echo "承認待ち";
						}elseif($v["shounin_flg"] == 1){
							echo "承認済み";
						}
					?></td>
					<!-- 会社名 -->
					<td><?php echo($v["valeur_coname"]); ?></td>
					<!-- 商品名 -->
					<td class="text-truncate" style="max-width: 300px;"><div data-toggle="modal" data-target="#detail_item" style="cursor: pointer;text-decoration: underline;color: #1e87f0;"data-serial="<?php echo($v["ai_serial"]) ?>" class="detail_item"><?php echo nl2br($v["m_item"]); ?></div></td>
					<!-- カテゴリー -->
					<td><?php echo($v["c_cate1"]); ?></td>
					<!-- 単価/単価単位 -->
					<td><?php echo number_format($v['m_tanka']).'円／'.$v['m_tanka_tani'] ;?></td>
					<!-- 受注最小ロット -->
					<td class=""><?php echo($v["m_lot_small"]); ?></td>
					<!-- 受注最小ロットの合計金 -->
					<td class=""><?php echo(number_format(($v["m_price_lot"]), 0,'',',')); ?>円</td>
				</tr>
				<?php endforeach ?>
				<?php else: ?>
					<td colspan="8" class="text-center pt-4 pb-4"><h4>該当商品情報がありません。</h4></td>
				<?php endif ?>
				</tbody>
			</table>
		</form>
	</div>
	<!-- 承認待ち -->
	<div class="tab-pane fade <?php echo ($FL_edit ? '' : 'show active');?>" id="nav-resign-wait" role="tabpanel" aria-labelledby="nav-resign-wait-tab">
		<form method="post" id="f_base" name="f_base" action="<?php echo $_SERVER['PHP_SELF']; ?>" target="_self">
			<table class="table table-hover table-bordered top" id="wait_tbl">
				<thead  class="align-middle text-center top">
					<tr>
						<th style="min-width: 50px;max-width: 50px;">No.</th>
						<th style="min-width: 70px;max-width: 70px;">状態</th>
						<th style="min-width: 150px;max-width: 150px;">会社名</th>
						<th style="min-width: 200px;max-width: 200px;">商品名</th>
						<th style="min-width: 80px;max-width: 80px;">カテゴリー</th>
						<th style="min-width: 100px;max-width: 100px;">単価/単価単位</th>
						<th style="min-width: 130px;max-width: 130px;">受注最小ロット</th>
						<th style="min-width: 150px;max-width: 150px;">受注最小ロットの合計金</th>
						<?php if($FL_shacho): ?>
							<th style="min-width: 100px;max-width: 100px;">ボタン</th>
						<?php endif ?>
					</tr>
				</thead>
				<tbody>
				<?php if(isset($A_item["wait"])): $cnt = 0; foreach($A_item["wait"] as $k => $v): $cnt++; ?>
				<tr>
					<!-- NO -->
					<td class="text-center"><?php echo($cnt); ?></td>
					<!-- 状態 -->
					<td><?php echo($v["shounin_flg"])==0 ? "申請中" : "test"; ?></td>
					<!-- 会社名 -->
					<td><?php echo($v["valeur_coname"]); ?></td>
					<!-- 商品名 -->
					<td class="text-truncate" style="max-width: 300px;"><div data-toggle="modal" data-target="#detail_item" style="cursor: pointer;text-decoration: underline;color: #1e87f0;"data-serial="<?php echo($v["ai_serial"]) ?>" class="detail_item"><?php echo nl2br($v["m_item"]); ?></div></td>
					<!-- カテゴリー -->
					<td><?php echo($v["c_cate1"]); ?></td>
					<!-- 単価/単価単位 -->
					<td><?php echo number_format($v['m_tanka']).'円／'.$v['m_tanka_tani'] ;?></td>
					<!-- 受注最小ロット -->
					<td class=""><?php echo($v["m_lot_small"]); ?></td>
					<!-- 受注最小ロットの合計金 -->
					<td class=""><?php echo(number_format(($v["m_price_lot"]), 0,'',',')); ?>円</td>
					<!-- 承認権限 -->
					<?php if($FL_shacho): ?>
					<td>
						<div class="btn-group">
							<input class="btn btn-primary complete-item p-3 fw-bold" data-toggle="modal" data-target="#exampleModalCenter" type="button" data-serial="<?php echo($v["ai_serial"]) ?>" data-name="<?php echo ($v["m_item"]); ?>" value="承 認">
							<button type="button" style="max-height: 40px; margin-top: 10px;" class="btn btn-danger delete-item p-2" id="delete-item" data-toggle="modal" data-target="#exampleModalCenter" data-name="<?php echo ($v["m_item"]); ?>" data-serial="<?php echo($v["ai_serial"]) ?>">保留</button>
						</div>
					</td>
					<?php endif ?>
				</tr>
				<?php endforeach ?>
				<?php else: ?>
					<td colspan="<?php echo ($FL_shacho) ? '9' : '8'?>" class="text-center pt-4 pb-4"><h4>該当商品情報がありません。</h4></td>
				<?php endif ?>
				</tbody>
			</table>
		</form>
	</div>
	<!-- 確認待ち-->
	<div class="tab-pane fade <?php echo ($FL_edit ? 'show active' : '');?>" id="nav-check" role="tabpanel" aria-labelledby="nav-check-tab">
		<form method="post" id="f_base" name="f_base" action="<?php echo $_SERVER['PHP_SELF']; ?>" target="_self">
			<table class="table table-hover table-bordered top" id="check_tbl">
				<thead  class="align-middle text-center top">
					<tr>
						<th style="min-width: 50px;max-width: 50px;">No.</th>
						<th style="min-width: 70px;max-width: 70px;">状態</th>
						<th style="min-width: 150px;max-width: 150px;">会社名</th>
						<th style="min-width: 200px;max-width: 200px;">商品名</th>
						<th style="min-width: 80px;max-width: 80px;">カテゴリー</th>
						<th style="min-width: 100px;max-width: 100px;">単価/単価単位</th>
						<th style="min-width: 130px;max-width: 130px;">受注最小ロット</th>
						<th style="min-width: 150px;max-width: 150px;">受注最小ロットの合計金</th>
						<!-- <th width="10%">価格</th> -->
						<?php if($FL_edit): ?>
							<th style="min-width: 120px;max-width: 120px;">ボタン</th>
						<?php endif ?>
						<!-- <?php if($FL_shacho): ?>
							<th width="10%">ボタン</th>
						<?php endif ?> -->

						
					</tr>
				</thead>
				<tbody>
				<?php if(isset($A_item["check"])): $cnt = 0; foreach($A_item["check"] as $k => $v): $cnt++; ?>
				<tr id="<?php echo($v["ai_serial"]); ?>">
					<!-- NO -->
					<td class="text-center"><?php echo($cnt); ?></td>
					<!-- 状態 -->
					<td><?php echo($v["shounin_flg"])==0 ? "申請中" : ""; ?></td>
					<!-- 出品社名 -->
					<td><?php echo($v["valeur_coname"]); ?></td>
					<!-- 商品名 -->
					<td class="text-truncate" style="max-width: 300px;"><div data-toggle="modal" data-target="#detail_item" style="cursor: pointer;text-decoration: underline;color: #1e87f0;"data-serial="<?php echo($v["ai_serial"]) ?>" class="detail_item"><?php echo nl2br($v["m_item"]); ?></div></td>
					<!-- カテゴリー -->
					<td><?php echo($v["c_cate1"]); ?></td>
					<!-- 単価/単価単位 -->
					<td><?php echo number_format($v['m_tanka']).'円／'.$v['m_tanka_tani'] ;?></td>
					<!-- 受注最小ロット -->
					<td class=""><?php echo($v["m_lot_small"]); ?></td>
					<!-- 受注最小ロットの合計金 -->
					<td class=""><?php echo(number_format(($v["m_price_lot"]), 0,'',',')); ?>円</td>
					<?php if($FL_edit): ?>
						<!-- 2024/01/29 ナム -->
						<!-- <button type="button" class="btn btn-info edit_btn ml-3" data-toggle="modal" data-name="<?php echo ($v["m_item"]); ?>" data-serial="<?php echo($v["ai_serial"]) ?>" data-tanka="<?php echo($v["m_tanka"]) ?>" data-lot="<?php echo($v["m_lot_small"]) ?>" data-lot-total="<?php echo($v["m_price_lot"]) ?>" data-target="#edit" data-whatever="">修正</button> -->
					<?php endif ?>
					</td>
					<!-- 編集権限 -->
					<?php if($FL_edit): ?>
					<td>
						<div class="btn-group">
							<button type="button" class="btn btn-info henshin_btn" data-toggle="modal" data-name="<?php echo ($v["m_item"]); ?>" data-serial="<?php echo($v["ai_serial"]) ?>" data-target="#exampleModal" data-whatever="">返信</button>
							<input class="btn btn-primary kakunin_btn" data-toggle="modal" data-target="#exampleModalCenter" type="button" data-serial="<?php echo($v["ai_serial"]) ?>" data-name="<?php echo ($v["m_item"]); ?>" value="確認">
						</div>
					</td>
					<?php endif ?>
				</tr>
				<?php endforeach ?>
				<?php else: ?>
					<td colspan="<?php echo ($FL_edit) ? '9' : '8'?>" class="text-center pt-4 pb-4"><h4>該当商品情報がありません。</h4></td>
				<?php endif ?>
				</tbody>
			</table>
		</form>
	</div>
	<!-- 承認済み-->
	<div class="tab-pane fade" id="nav-complete-item" role="tabpanel" aria-labelledby="nav-complete-item-tab">
		<form method="post" id="f_base" name="f_base" action="<?php echo $_SERVER['PHP_SELF']; ?>" target="_self">
			<table class="table table-hover table-bordered top" id="shinsei_tbl">
				<thead  class="align-middle text-center top">
					<tr>

						<th style="min-width: 50px;max-width: 50px;">No.</th>
						<th style="min-width: 70px;max-width: 70px;">状態</th>
						<th style="min-width: 150px;max-width: 150px;">会社名</th>
						<th style="min-width: 200px;max-width: 200px;">商品名</th>
						<th style="min-width: 80px;max-width: 80px;">カテゴリー</th>
						<th style="min-width: 100px;max-width: 100px;">単価/単価単位</th>
						<th style="min-width: 130px;max-width: 130px;">受注最小ロット</th>
						<th style="min-width: 150px;max-width: 150px;">受注最小ロットの合計金</th>

					</tr>
				</thead>
				<tbody>
				<?php if(isset($A_item["complete"])): $cnt = 0; foreach($A_item["complete"] as $k => $v): $cnt++; ?>
				<tr>
					<!-- NO -->
					<td class="text-center"><?php echo($cnt); ?></td>
					<!-- 状態 -->
					<td>承認済み</td>
					<!-- 会社名 -->
					<td><?php echo($v["valeur_coname"]); ?></td>
					<!-- 商品名 -->
					<td class="text-truncate" style="max-width: 300px;"><div data-toggle="modal" data-target="#detail_item" style="cursor: pointer;text-decoration: underline;color: #1e87f0;"data-serial="<?php echo($v["ai_serial"]) ?>" class="detail_item"><?php echo nl2br($v["m_item"]); ?></div></td>
					<!-- カテゴリー -->
					<td><?php echo($v["c_cate1"]); ?></td>
					<!-- 単価/単価単位 -->
					<td><?php echo number_format($v['m_tanka']).'円／'.$v['m_tanka_tani'] ;?></td>
					<!-- 受注最小ロット -->
					<td class=""><?php echo($v["m_lot_small"]); ?></td>
					<!-- 受注最小ロットの合計金 -->
					<td class=""><?php echo(number_format(($v["m_price_lot"]), 0,'',',')); ?>円</td>
				</tr>
				<?php endforeach ?>
				<?php else: ?>
					<td colspan="8" class="text-center pt-4 pb-4"><h4>該当商品情報がありません。</h4></td>
				<?php endif ?>
				</tbody>
			</table>
		</form>
	</div>
	<!-- 却下表示する -->
	<div class="tab-pane fade" id="nav-delete-item" role="tabpanel" aria-labelledby="nav-delete-item-tab">
		<form method="post" id="f_base" name="f_base" action="<?php echo $_SERVER['PHP_SELF']; ?>" target="_self">
			<table class="table table-hover table-bordered top" id="shinsei_tbl">
				<thead  class="align-middle text-center top">
					<tr>
						<th style="min-width: 50px;max-width: 50px;">No.</th>
						<th style="min-width: 70px;max-width: 70px;">状態</th>
						<th style="min-width: 150px;max-width: 150px;">会社名</th>
						<th style="min-width: 200px;max-width: 200px;">商品名</th>
						<th style="min-width: 80px;max-width: 80px;">カテゴリー</th>
						<th style="min-width: 100px;max-width: 100px;">単価/単価単位</th>
						<th style="min-width: 130px;max-width: 130px;">受注最小ロット</th>
						<th style="min-width: 150px;max-width: 150px;">受注最小ロットの合計金</th>
					</tr>
				</thead>
				<tbody>
				<?php if(isset($A_item["delete"])): $cnt = 0; foreach($A_item["delete"] as $k => $v): $cnt++; ?>
				<tr>
					<!-- NO -->
					<td class="text-center"><?php echo($cnt); ?></td>
					<!-- 状態 -->
					<td><?php echo($v["review_flg"])==2 ? "返信" : "却下"; ?></td>
					<!-- 会社名 -->
					<td><?php echo($v["valeur_coname"]); ?></td>
					<!-- 商品名 -->
					<td class="text-truncate" style="max-width: 300px;"><div data-toggle="modal" data-target="#detail_item" style="cursor: pointer;text-decoration: underline;color: #1e87f0;"data-serial="<?php echo($v["ai_serial"]) ?>" class="detail_item"><?php echo nl2br($v["m_item"]); ?></div></td>
					<!-- カテゴリー -->
					<td><?php echo($v["c_cate1"]); ?></td>
					<!-- 単価/単価単位 -->
					<td><?php echo number_format($v['m_tanka']).'円／'.$v['m_tanka_tani'] ;?></td>
					<!-- 受注最小ロット -->
					<td class=""><?php echo($v["m_lot_small"]); ?></td>
					<!-- 受注最小ロットの合計金 -->
					<td class=""><?php echo(number_format(($v["m_price_lot"]), 0,'',',')); ?>円</td>
				</tr>
				<?php endforeach ?>
				<?php else: ?>
					<td colspan="8" class="text-center pt-4 pb-4"><h4>該当商品情報がありません。</h4></td>
				<?php endif ?>
				</tbody>
			</table>
		</form>
	</div>
</div>
</div>
<!-- kakunin dialog -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">確認商品</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body" id="mess">
			確認？
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
			<button type="button" class="btn btn-primary" data-dismiss="modal" type="submit" id="submit_btn" name="submit" value="Submit">決定</button>
		</div>
		</div>
	</div>
</div>
<!-- input dialog -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
	<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLabel">New message</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
		<form>
		<div class="form-group">
			<label for="recipient-name" class="col-form-label" >対象な商品:</label>
			<input readonly type="text" class="form-control" id="recipient-name">
		</div>
		<div class="form-group">
			<label for="message-text" class="col-form-label">メッセージ入力:</label>
			<textarea class="form-control" id="message-text" name="message-text" rows="8"></textarea>
			<div class="alert alert-danger" role="alert" style="display: none;" id="error_message">
				メッセージを入力してください！
			</div>
		</div>
		</form>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
		<button type="button" class="btn btn-primary" id="submit_henshin">送信</button>
	</div>
	</div>
</div>
</div>
<!-- edit  dialog -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
	<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title" id="editLabel">下記の商品修正中</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
		<form>
		<div class="form-group">
			<label for="shouhin-name" class="col-form-label" >商品名：</label>
			<input readonly type="text" class="form-control" id="shouhin-name">
			<label for="tanka" class="col-form-label" >単価/単価単位：</label>
			<input type="text" class="form-control" id="tanka" name="tanka" oninput="value=value.replace(/[^0-9.]+/i,'');">
				<span class="text-primary-emphasis" style="font-size: 13px;display: block;">半角数字以外は入力不可（卸サイトになりますので「卸価格」を表示）</span>
				<span class="text-primary-emphasis" style="font-size: 13px;display: block;">「税込価格」で入力してください</span>
			<label for="lot" class="col-form-label" >受注最小ロット：</label>
				<input type="text" class="form-control" id="lot" name="lot">
				<span class="text-primary-emphasis" style="font-size: 13px;display: block;">単位（kg等）まで明記して下さい</span>
				<span class="text-primary-emphasis" style="font-size: 13px;display: block;">半角スペースは全角スペースに置換されます</span>
			<label for="lot-total" class="col-form-label" >受注最小ロットの合計金：</label>
			<input type="text" class="form-control" id="lot-total" name="lot-total" oninput="value=value.replace(/[^0-9.]+/i,'');">
				<span class="text-primary-emphasis" style="font-size: 13px;display: block;">半角数字以外は入力不可</span>
		</div>
		</form>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
		<button type="button" class="btn btn-primary" id="edit_submit">修正</button>
	</div>
	</div>
</div>
</div>
<!-- item detail modal -->
<div class="modal fade bd-example-modal-lg" id="detail_item" tabindex="-1" role="dialog" aria-labelledby="detail_lable" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title" id="detail_lable"></h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
		<table class="table table-striped" id="item_detail_tbl">
			<thead>
			</thead>
			<tbody>
				
			</tbody>
		</table>
	</div>
	</div>
</div>
</div>
</body>
</html>
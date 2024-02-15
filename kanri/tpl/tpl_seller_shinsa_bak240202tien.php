<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script type="text/javascript" language="javascript">

	$(function() {
        $('.koukai_btn').on('click', function(){
            const f_serial = $(this).data('serial');
            const seller_shop = $(this).data('company');
            const seller_tantou = $(this).data('tantou');
            const seller_id = $(this).data('sellerid');
            $("#exampleModalLongTitle").text("承認確認");
            $("#mess").text(seller_shop + "を承認しますか？");
            $('#submit_btn').click(function(){
                const request = $.ajax({
				method: 'POST',
				url: "<?php echo $_SERVER['PHP_SELF']?>",
				data: {edit_type: 'koukai',
                    'f_serial':f_serial,
                    'seller_shop':seller_shop, 
                    'seller_tantou':seller_tantou}
			    })
                request.done((response) =>{
                alert("選択した会社を承認しました");
                location.reload();
                });
	        });
        });

        $('.delete_btn').on('click', function(){
            const d_serial = $(this).data('serial');
            const seller_shop = $(this).closest("tr").find('td[name="s_company"]').text();
            console.log(seller_shop);
            $("#exampleModalLongTitle").text("却下する確認");
            $("#mess").text(seller_shop + "を却下しますか？");
            $('#submit_btn').click(function(){
                const request = $.ajax({
				method: 'POST',
				url: "<?php echo $_SERVER['PHP_SELF']?>",
				data: {'edit_type': 'delete_shinsa','d_serial':d_serial}
			    })
                request.done(() =>{
                alert("選択した会社を却下しました");
                location.reload();
                });
	        });
        });
	})
</script>
<style type="text/css">
    .bg-overide{
        background-color : #1D2A4A!important;
    }
	.table-bordered  {
		border: 1px solid black;
	}
	.table>thead.top {
		background-color: dimgrey;
		color: #fff;
	}
	.table.top td {
		vertical-align: middle;
	}
    .btn-group {
        display: flex;
        justify-content: space-between;
    }
    .btn-group .btn:first-child {
        margin-right: 8px;
    }
    .btn-group .btn {
        border-radius: 5px !important;
    }
    </style>
    <title>バルル出店審査</title>
</head>
<body>
<div class="container-fluid my-3">
<!-- ログイン情報 -->
<div class="pt-3">
    <div style="font-size: 18px;font-size: 18px;background-color: #a9a6ff;padding: 10px;border-radius: 8px;">ログイン： 
        <span class="badge bg-secondary" style="font-size: 18px;"><?php echo($login_staff??"未ログイン"); ?></span>
    </div>
</div>
<!-- main -->
<h3 class="mb-3 mt-3">バルル出店審査一覧</h3>
<!-- テーブル start -->
<nav class="mb-5">
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">申請中</button>
        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">承認済み</button>
        <button class="nav-link" id="nav-delete-tab" data-bs-toggle="tab" data-bs-target="#nav-delete" type="button" role="tab" aria-controls="nav-delete" aria-selected="false">却下済み</button>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
<!-- 申請中 -->
<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
<form method="post" id="shinsa_table" name="shinsa_table" action="<?php echo $_SERVER['PHP_SELF']; ?>" target="_self">
<table class="table table-hover table-bordered top" id="shinsei_tbl">
    <thead  class="align-middle text-center top">
        <tr>
            <th style="min-width: 50px;max-width: 50px;">No</th>
            <th style="min-width: 150px;max-width: 150px;">店舗名</th>
            <th style="min-width: 100px;max-width: 100px;">担当者名</th>
            <th style="min-width: 150px;max-width: 150px;">M担当者名</th>
            <th style="min-width: 100px;max-width: 100px;">主商品</th>

            <th style="min-width: 120px;max-width: 120px;">電話番号</th>
            <th width="20%">所在</th>
            <th style="min-width: 200px;max-width: 200px;">メールアドレス</th>
            
            <th style="min-width: 70px;max-width: 70px;">上場</th>
            <th style="min-width: 110px;max-width: 110px;">資本金</th>
            <th style="min-width: 110px;max-width: 110px;">年商</th>
            <th style="min-width: 150px;max-width: 150px;">ボータン</th>


        </tr>
    </thead>
    <tbody>
    <?php if(isset($A_seller_shinsa["shinsa"]) && is_array($A_seller_shinsa["shinsa"])): $cnt = 0; foreach($A_seller_shinsa["shinsa"] as $k => $v): $cnt++; ?>
    <tr>
        <!-- NO -->
        <td class="text-center"><?php echo($cnt); ?></td>
        <!-- 店舗名 -->
        <td name="s_company"><?php echo($v["valeur_coname"]); ?></td>
        <!-- 担当者名 -->
        <td><?php echo($v["valeur_tantou"]); ?></td>
        <!-- Mマート担当者名 -->
        <td><?php echo($v["valeur_mtantou"]); ?></td>
        <!-- 主商品 -->
        <td align="center"><?php echo(isset($v["valeur_item"])?$v["valeur_item"]:"未登録"); ?></td>
        <!-- 電話番号 -->
        <td><?php echo(isset($v["valeur_tel"])?$v["valeur_tel"]:"未登録"); ?></td>
        <!-- 住所 -->
        <td>
            <?php 
                echo '〒'.$v["valeur_zip"].'　'.$v["valeur_add1"].(!empty($v["valeur_add2"]) ? '　'.$v["valeur_add2"] : '');
            ?>
        </td>
        <!-- メール -->
        <td><?php echo(isset($v["valeur_mail"]) ? $v['valeur_mail'] : "非上場") ?></td>
        <!-- 上場 -->
        <td align="center"><?php echo((isset($v["valeur_listed"]) && $v["valeur_listed"] == 1) ? "上場":"非上場") ?></td>
        <!-- 資本金 -->
        <td><?php echo((number_format($v["valeur_capital"], 0,'',','))??""); ?>円</td>
        <!-- 年商 -->
        <td><?php echo((number_format($v["valeur_annual_sales"], 0,'',','))??""); ?>円</td>
        <!-- ボータン -->
        <td>
            <div class="btn-group">
                <input class="btn btn-danger btn-sm delete_btn" data-toggle="modal" data-target="#exampleModalCenter" type="button" data-serial="<?php echo($v["serial"]) ?>" value="却下する">
                <!-- 承認ボタン -->
                <input class="btn btn-success btn-sm koukai_btn" data-toggle="modal" data-target="#exampleModalCenter" type="button" data-serial="<?php echo($v["serial"]) ?>" data-company="<?php echo($v["valeur_coname"]) ?>" data-tantou="<?php echo($v["valeur_tantou"]) ?>" value="承認">
            </div>
        </td>
    </tr>
    <?php endforeach ?>
    <?php endif ?>
    </tbody>
</table>
</form>
</div>
<!-- 承認済み -->
<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
<table class="table table-hover table-bordered top" id="shinsei_tbl">
    <thead  class="align-middle text-center top">
        <tr>
            <th>No.</th>
            <th>店舗名</th>
            <th>担当者名</th>
            <th>主商品</th>
            <th>電話番号</th>
            <th>郵便番号</th>
            <th>所在地</th>
            <th>メールアドレス</th>
            <th>承認日</th>
        </tr>
    </thead>
    <tbody>
    <?php if(isset($A_seller_shinsa["koukai"]) && is_array($A_seller_shinsa["koukai"]) ): $cnt = 0; foreach($A_seller_shinsa["koukai"] as $k => $v): $cnt++; ?>
    <tr>
        <!-- NO -->
        <td class="text-center"><?php echo($cnt); ?></td>
        <!-- 店舗名 -->
        <td><?php echo($v["valeur_coname"]); ?></td>
        <!-- 担当者名 -->
        <td><?php echo($v["valeur_tantou"]); ?></td>
        <!-- 主商品 -->
        <td><?php echo(($v["valeur_item"])?$v["valeur_item"]:"未登録"); ?></td>
        <!-- 電話番号 -->
        <td><?php echo nl2br($v["valeur_tel"]); ?></td>
        <!-- 郵便番号 -->
        <td><?php echo ($v["valeur_zip"]); ?></td>
        <!-- 所在地 -->
        <td><?php echo ($v["valeur_add1"].(!empty($v["valeur_add2"]) ? '　'.$v["valeur_add2"] : '')); ?></td>
        <!-- メールアドレス -->
        <td><?php echo nl2br($v["valeur_mail"]); ?></td>
        <!-- 承認日 -->
        <td class="text-center"><?php echo ($v["valeur_kakunin_date"]); ?></td>
    </tr>
    <?php endforeach ?>
    <?php endif ?>
    </tbody>
</table>
<?php if(empty($A_seller_shinsa["koukai"])): ?>
    <div class="text-center">
        <p>公開済み会社はありません。</p>
    </div>
    <?php endif ?>
</div>
<!-- 却下済み -->
<div class="tab-pane fade" id="nav-delete" role="tabpanel" aria-labelledby="nav-delete-tab">
<table class="table table-hover table-bordered top" id="shinsei_tbl">
    <thead  class="align-middle text-center top">
        <tr>
            <th>No.</th>
            <th>店舗名</th>
            <!-- <th>業種</th> -->
            <th>担当者名</th>
            <th>主商品</th>
            <th>電話番号</th>
           
            <th>郵便番号</th>
            <th>所在地</th>
            <th>メールアドレス</th>
            <th>却下日</th>
        </tr>
    </thead>
    <tbody>
    <?php if(isset($A_seller_shinsa["delete"]) && is_array($A_seller_shinsa["delete"])): $cnt = 0; foreach($A_seller_shinsa["delete"] as $k => $v): $cnt++; ?>
    <tr>
        <!-- NO -->
        <td class="text-center"><?php echo($cnt); ?></td>
        <!-- 店舗名 -->
        <td><?php echo($v["valeur_coname"]); ?></td>
        <!-- 担当者名 -->
        <td><?php echo($v["valeur_tantou"]); ?></td>
        <!-- 主商品 -->
        <td><?php echo(($v["valeur_item"])?$v["valeur_item"]:"未登録"); ?></td>
        <!-- 電話番号 -->
        <td><?php echo nl2br($v["valeur_tel"]); ?></td>
        <!-- 郵便番号 -->
        <td><?php echo $v["valeur_zip"]; ?></td>
        <!-- 所在地 -->
        <td><?php echo ($v["valeur_add1"].(!empty($v["valeur_add2"]) ? '　'.$v["valeur_add2"] : '')); ?></td>
        <!-- メールアドレス -->
        <td><?php echo nl2br($v["valeur_mail"]); ?></td>
        <!-- 却下日 -->
        <td class="text-center"><?php echo ($v["valeur_kakunin_date"]); ?></td>
    </tr>
    <?php endforeach ?>
    <?php endif ?>
    </tbody>
</table>
<!-- なし -->
<?php if(isset($A_seller_shinsa["delete"]) && empty($A_seller_shinsa["delete"])): ?>
    <div class="text-center">
        <p>却下済み会社はありません。</p>
    </div>
<?php endif ?>
</div><!-- end last table -->
</div><!-- end tab -->
<!-- テーブル end -->
</div><!-- wrapper div -->
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">却下する確認</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="mess">
            選択した会社を却下しますか？
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal" type="submit" id="submit_btn" name="submit" value="Submit">決定</button>
        </div>
        </div>
    </div>
</div>
</body>
</html>
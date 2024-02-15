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
	<script type="text/javascript" src="/jquery_ui/js/jquery.ui.datepicker-ja.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script> -->
    <title>メールボックス</title>
	<script>
	$(function() {
		
		$('.detail_mail').on('click', function(){
            const order_serial = $(this).closest("tr").find('input[name="order_serial"]').val();
            const kaite_mei = $(this).closest("tr").find('td[name="kaite_mei"]').text();
            const order_mail_serial = $(this).closest("tr").find('input[name="order_mail_serial"]').val();
            const read_flg = $(this).closest("tr").find('input[name="read_flg"]');
            $(this).closest("tr").find('div[class="unread-mask"]').remove();
			// console.log(unread_mask);
			$(this).closest("tr").find(".mail_desc").toggle();
			// $(this).closest("tr").find(".repply-btn").toggle();

			if(read_flg.val() == 0 || read_flg.val() === ""){
				const request = $.ajax({
					method: 'POST',
					url: "/outlet/valeur/seller/index.php",
					data: {'action': 'readed_mail',order_serial:order_serial, order_mail_serial:order_mail_serial}
				})
				request.done(() =>{
					read_flg.val('1');
				});
			}

			// 送信機能
			// $(this).closest("tr").find(".btn-success").on('click', function(){
			// 	$('#title-name').val('');
			// 	$('#message-text').val('');
			// 	$('#recipient-name').val(kaite_mei);
			// 	$('#send_btn').on('click', function(){
			// 		// $('#repply').modal('hide');
			// 		// if(!$('#title-name').val()){
			// 		// $('.alert').show();
			// 		const titleName = $('#title-name').val();
			// 		const messageText = $('#message-text').val();
			// 		const request = $.ajax({
			// 		method: 'POST',
			// 		url: "/outlet/valeur/seller/index.php",
			// 		data: {'button_type': 'sendmail',order_serial:order_serial, titleName:titleName, messageText:messageText}
			// 		})
			// 		request.done(() =>{
			// 		alert("メール送信しました！");
			// 		// location.reload();
			// 		});

			// 		// }
			// 	})
			// })
        });

		$('.btn-danger').on('click', function(){
            const order_serial = $(this).closest("tr").find('input[name="order_serial"]').val();
		})
		$('.delete_btn').on('click', function(){
            const detail_mail = $(this).closest("tr").find('div[class="detail_mail"]').text();
            const order_serial = $(this).closest("tr").find('input[name="order_serial"]').val();
            const order_mail_serial = $(this).closest("tr").find('input[name="order_mail_serial"]').val();
			$('.modal_mail_body').text(detail_mail);
			const form = $('#kakunin_form');

			form.attr('action', '/outlet/valeur/seller/index.php');
			form.attr('method', 'POST');
			$('<input>').attr({'type': 'hidden','name': 'action','value': 'delete_mail'}).appendTo(form);
			$('<input>').attr({'type': 'hidden','name': 'order_mail_serial','value': order_mail_serial}).appendTo(form);
			$(document.body).on('click', '.submit_btn', function(){
				// form.submit();
				const request = $.ajax({
					method: 'POST',
					url: "/outlet/valeur/seller/index.php",
					data: {'action': 'delete_mail',order_serial:order_serial, order_mail_serial:order_mail_serial}
				})
				request.done(() =>{
					$('input[name="action"]').remove();
					$('input[name="order_mail_serial"]').remove();
					location.reload();
				});
				$('#kakunin').modal('hide');
				// location.reload();
			})
			$(document.body).on('click', '.cancle_btn', function(){
				$('input[name="action"]').remove();
				$('input[name="order_mail_serial"]').remove();
			});
		})
	});
	</script>
    <style>
        h2.title-radius{
        background-color: #00abff78;
        display: inline-block;
        padding: 5px 20px;
        border-radius: 10px;
    }
	.bg-gradient{
		background-color: #D5ACD530;
	}
	thead th {
		background-color: #D2D0FF !important;
	}
	.fit-content{
		width: fit-content;
	}
	.border-top{
		border-top: 2px solid black !important;
		margin-top: 13px;
  		padding-top: 13px;
	}
	.f-center{
		vertical-align: top;
	}
	.detail_mail{
		cursor: pointer;
		position: relative;
		padding-left: 20px;
	}
	.detail_mail:hover{
		color: #3ae3e3;
	}
	.unread-mask{
		width: 15px;
		height: 15px;
		border-radius: 50%;
		text-align: center;
		font-size: 32px;
		background-color: #57e0f7;
		position: absolute;
		left: 0;
		top: 0;
		transform: translate(0,40%);
	}
    </style>
</head>
<body class="mb-5">
<header class="container-fluid mt-3">
    <?php include_once('/var/www/html3/outlet/valeur/seller/tpl/tpl_header.php'); ?>
    <div class="mb-1 pl-5"><a type="button" class="btn btn-outline-primary ml-5" href="/outlet/valeur/seller/index.php">戻る</a></div>
</header>
<main class="container-fluid mt-3">
    <section>
	<ul class="nav nav-pills mb-3 bg-gradient" id="pills-tab" role="tablist">
		<li class="nav-item" role="presentation">
			<button class="nav-link active" id="pills-unread-tab" data-bs-toggle="pill" data-bs-target="#pills-unread" type="button" role="tab" aria-controls="pills-unread" aria-selected="true">未読メール</button>
		</li>
		<li class="nav-item" role="presentation">
			<button class="nav-link" id="pills-readed-tab" data-bs-toggle="pill" data-bs-target="#pills-readed" type="button" role="tab" aria-controls="pills-readed" aria-selected="false">既読メール</button>
		</li>
		<li class="nav-item" role="presentation">
			<button class="nav-link" id="pills-deleted-tab" data-bs-toggle="pill" data-bs-target="#pills-deleted" type="button" role="tab" aria-controls="pills-deleted" aria-selected="false">削除メール</button>
		</li>
	</ul>
	<div class="tab-content px-5" id="pills-tabContent">
				<!-- <?php dump($A_mail) ?> -->
	<?php foreach($A_mail as $table => $list): ?>
		<div class="tab-pane fade <?php if($table == "unread"){echo ("show active");} ?>" id="pills-<?php echo ($table) ?>" role="tabpanel" aria-labelledby="pills-<?php echo ($table) ?>-tab">
		<table class="table table-striped border table-bordered border-secondary align-middle ">
			<thead class="text-center">
				<th width="11%">受信日時</th>
				<th width="13%">種別</th>
				<th width="13%">買い手</th>
				<th>件名</th>
				<?php if($table != "deleted"): ?>
				<th width="7%">削除</th>
				<?php endif ?>
			</thead>
			<tbody>
				<?php foreach($list as $k => $v): ?>
				<tr>
					<td class="text-center f-center"><?php echo($v["time"]) ?></td>
					<td class="text-center f-center"><?php echo(nl2br($v["subject"])) ?></td>
					<td class="text-center f-center" name="kaite_mei"><?php echo(nl2br($v["kaite_mei"])) ?></td>
					<td><div class="detail_mail"><?php if($table == "unread"): ?><div class="unread-mask"></div><?php endif ?><?php echo($v["subject"]) ?></div><p style="display:none;" class="mail_desc border-top"><?php echo(nl2br($v["honbun"])) ?></p></td>
					<!-- /outlet/valeur/seller/index.php?p_kind=mailbox&o=3267733 -->
					<?php if($table != "deleted"): ?>
					<td class="text-center f-center">
						<div>
							<button type="button" class="btn btn-danger fit-content delete_btn" data-toggle="modal" data-target="#kakunin">削除</button>
							<!-- <button type="button" class="btn btn-success fit-content repply-btn" data-bs-toggle="modal" data-bs-target="#repply" data-bs-whatever="@mdo" style="display:none;">返信</button> -->
						</div>
					</td>
					<?php endif ?>
					<input type="hidden" name="order_serial" value="<?php echo($v["order_serial"]) ?>">
					<input type="hidden" name="order_mail_serial" value="<?php echo($v["order_mail_serial"]) ?>">
					<input type="hidden" name="read_flg" value="<?php echo($v["read_flg"]) ?>">
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
		<!-- <?php dump($A_mail); ?> -->
		</div>
	<?php endforeach ?>
	</div>
    </section>
</main>
<!-- modal -->
<div class="modal fade" id="repply" tabindex="-1" aria-labelledby="repplyLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="repplyLabel">メール送信</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-1">
            <label for="recipient-name" class="col-form-label">送り先:</label>
            <input readonly type="text" class="form-control" id="recipient-name">
          </div>
          <div class="mb-1">
            <label for="title-name" class="col-form-label">タイトル:</label>
            <input type="text" class="form-control" id="title-name">
			<div class="alert alert-warning" style="display:none;margin:0;" role="alert">
				タイトルを入力してください！
			</div>
          </div>
          <div class="mb-1">
            <label for="message-text" class="col-form-label">メッセージ:</label>
            <textarea rows="7" class="form-control" id="message-text"></textarea>
			<div class="alert alert-warning" style="display:none;margin:0;" role="alert">
				メッセージを入力してください！
			</div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
        <button type="button" class="btn btn-primary" id="send_btn">メール送信する</button>
      </div>
    </div>
  </div>
</div>
<!-- 確認modal -->
<!-- Modal -->
<div class="modal fade" id="kakunin" tabindex="-1" role="dialog" aria-labelledby="kakuninTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">下記のメール削除しますか？</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  <form id="kakunin_form">

      <div class="modal-body modal_mail_body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary cancle_btn" data-dismiss="modal">キャンセル</button>
        <button type="button" class="btn btn-primary submit_btn" >実行</button>
      </div>
		</form>

    </div>
  </div>
</div>
</body>
</html>
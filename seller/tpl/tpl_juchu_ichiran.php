<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="Content-Style-Type" content="text/css">
	<title><?php echo(escape($config['title']));?></title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
	<link href="../common/css/style_order.css?<?php echo time()?>" rel="stylesheet" type="text/css" />

	<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
	<script type="text/javascript" src="/jquery_ui/js/jquery.ui.datepicker-ja.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>

	<script type="text/javascript" language="javascript" src='/outlet/valeur/common/js/order_list.js?<?php echo time()?>'></script>

	<script type="text/javascript" language="javascript">
		$(document).ready(function(){
			$('#seller_all_tbl').DataTable({
				ajax: {
					url: '/outlet/valeur/seller/api.php',
					data: {'p_kind': 'juchu'},
					dataSrc: function(data) {
						var length = data.length;
						var nFormat = new Intl.NumberFormat('ja-JP');
						// // console.log(data);
						for(var i = 0; i < length; i++) {
							// data.push(data[i]['serial']);
							data[i]['uriba'] = "バルル";
							// 支払方法
							if(data[i]['order_payment_type'] == 0){
								data[i]['order_payment_type'] = "代金引";
							}else if(data[i]['order_payment_type'] == 1){
								data[i]['order_payment_type'] = "カード";
							}else if(data[i]['order_payment_type'] == 2){
								data[i]['order_payment_type'] = "大量購入のその他"
							}else if(data[i]['order_payment_type'] == 3){
								data[i]['order_payment_type'] = "Mコイン";
							}else if(data[i]['order_payment_type'] == 4){
								data[i]['order_payment_type'] = "銀行振込";
							};
							data[i]['mailhassou'] = "未発送";
							data[i]['taiou'] = "";
							data[i]['tanka'] = data[i]['tanka']+"円";
							data[i]['mail_input'] = 'serial' + data[i]['order_serial'] + 'kingaku' + data[i]['kingaku'];
							data[i]['kingaku_str'] = nFormat.format(data[i]['kingaku'])+"円";
							data[i]['check'] = "";
							if(data[i]['hassouPromise']){
								data[i]['hassouPromise'] = '<p>未設定</p>">';
							}else{
								data[i]['hassouPromise'] = '<p>発送予定:</p><p>'+'----'+'年'+'--月--日'+'</p>';
								data[i]['hassouPromise'] += '<p>到着予定:</p><p>'+'----'+'年'+'--月--日'+'</p>';
							}
							data[i]['hassouInfor'] = "未設定";
							data[i]['data_hidden'] = '<input type="hidden" name="kingaku" value="'+data[i]['kingaku']+'">';
							data[i]['kaite_infor'] = '<p>'+data[i]['kaite_shamei']??""+'</p>'+'<p>'+data[i]['buyer_tantou']??""+'</p>'+'<p>'+data[i]['buyer_tel']??""+'</p>';
							if((data[i]['soryo'])){
								data[i]['soryo'] = data[i]['soryo'];
							}else{
								data[i]['soryo'] = "未設定";
							}
						}
						return data;
					}
				},
				columns: [
				{ data: "cnt" }, 
				{ data: "check" }, 
				{ data: "juchubi" },
				{ data: "kaite_infor" },
				{ data: "shouhin" }, 
				{ data: "suryou" }, 
				{ data: "kingaku_str" }, 
				{ data: "ken" },
				{ data: "soryo" },
				{ data: "kingaku_str" }, 
				{ data: "order_payment_type" }, 
				{ data: "comment" }, 
				{ data: "hassouPromise" }, 
				{ data: "hassouInfor" }, 
				
				{ data: "mail_input",  "mRender" : function(data, type, full){
					return '<div class="d-flex flex-column"><p class="text-center mb-0"></p><button type="button" id="'+full.serial+'" class="btn btn-primary input_mail ps-0 pe-0" >メール入力</button></div></div><input type="hidden" name="kingaku" value="'+full.kingaku+'"><input type="hidden" name="order_serial" value="'+full.order_serial+'">'
					}
				}, 
				{ data: "mail_kakunin", "mRender" : function(data, type, full){
						return renderButton(data, type, full);
					} 
				}, 
				{ data: "mailhassou", "mRender" : function(data, type, full){
					// console.log(data);
					return renderButton(data, type, full);
					}
				}, 
				// { data: "juchubi" },
				{ data: "taiou","mRender" : function(data, type, full){
					return renderTaiouBtn(data, type, full);
					}}
				],
				"orderClasses": false,
				"processing": true,
				"stateSave": false,
				"lengthChange": true,
				"searching": false,
				"ordering": false,
				"info": true,
				"paging": true,
				"displayLength": 25,
				"language": {
					"lengthMenu": '表示件数：<select>'+
					'<option value="10">10</option>'+
					'<option value="25">25</option>'+
					'<option value="50">50</option>'+
					'<option value="100">100</option>'+
					'<option value="-1">All</option>'+
					'</select>',
					"search": "検索： _INPUT_",
					"infoEmpty": "全 0 件の 0 ～ 0 件を表示",
					"info": "全 _TOTAL_ 件の _START_ ～ _END_ 件を表示",
					"paginate": {
						"previous": "前へ",
						"next": "次へ"
					},
					"emptyTable": "データがありません",
					"zeroRecords": "該当データがありません"
				}
			});
			function renderButton (data, type, full){
				// return '<div class="d-flex flex-column"><p class="text-center mb-0"></p><button type="button" data-id="'+full.order_serial+'" onclick="" class="btn btn-primary hassou-btn" >送信画面へ</button></div></div>'
				var element = "";
				element += '<form name="ex_form" id="ex_form" action="/outlet/valeur/seller/order_mail.php" method="post" target="">';
				element += '<div class="d-flex flex-column"><p class="text-center mb-0"></p><button data-id="'+full.order_serial+'" class="btn btn-primary hassou-btn" >送信画面へ</button></div>';
				element += '<input type="hidden" name="order_serial" value="'+full.order_serial+'">';
				element += '<input type="hidden" name="p_kind" value="kakunin_mail">';
				element += '</form>';
				return element;
			}
			function renderTaiouBtn (data, type, full){
				return '<div class="d-flex flex-column"><p class="text-center mb-0">'+data+'</p><button type="button" data-id="'+full.order_serial+'" onclick="" class="btn btn-warning" >キャンセル申請</button><button type="button" id="'+full+'" onclick="" class="btn btn-info" >対応済</button></div></div>'
			}
			//到着予定日
			function f_set_totyaku_date(type){
				var inter_val=0,
					hasso_date=$('#hasso_date').val(),
					totyaku_date='';
				
				if(hasso_date){
					if(type=='next_date'){
						inter_val=2;
					}
					if(type=='after_next_date'){
						inter_val=3;
					}
					
					var date = new Date(hasso_date);
					date.setDate(date.getDate() + inter_val);
					var new_date = date.toISOString().substr(0, 10);
						totyaku_date=new_date.replace('-','/').replace('-','/');
					
					$('#totyaku_date').val(totyaku_date);
				}else{
					alert('発送予定日確認の上設定ボタン押してしてください。');
				}	
				
			}
			// 確認メール入力Modal
			$(document).on('click', '.input_mail', function(){
				$("#input_window").dialog("open");
				// var f_listed = $(this).closest("tr").find('input[name="listed_' + f_serial + '"]').val();
				var order_serial=$(this).closest("tr").find('input[name="order_serial"]').val();
				kingaku = $(this).closest("tr").find('input[name="kingaku"]').val();
				kingaku_edited = $('#kingaku_edited');
				order_f = $('#order_serial');
				kingaku_edited.val(kingaku);
				order_f.val(order_serial);
				$('.ui-dialog-titlebar-close').text('X');
				$('.ui-dialog-titlebar-close').css({'display':'flex','justify-content':'center','align-items':'center'});

			});

			$("#input_window").dialog({
				autoOpen:false,
				position: { my: "center center", at: "center center", of: window},
				height: 650,
				width: 700,
				modal: true,
				open: function(){
					jQuery('.ui-widget-overlay').bind('click',function(){
						jQuery('#input_window').dialog('close');
					})
				},
				buttons: {
					"キャンセル":function(){
						$( this ).dialog( "close" );
					},
					"保存 ":function(){
						var kingaku_edited = $('#kingaku_edited').val();
						var soryo = $('#soryo').val();
						var hasso_date = $('#hasso_date').val();
						var totyaku_date = $('#totyaku_date').val();
						var takuhai_gyosya_name = $('#takuhai_gyosya_name').val();
						// var takuhai_gyosya_select = $('#takuhai_gyosya_select :selected').val();
						var denpyo_number = $('#denpyo_number').val();
						var bin_type = $('input[name="bin_type"]:checked').val();
						var takuhai_url = $('#takuhai_url').val();
						var comment_mail = $('#comment_mail').val();
						var order_serial = $('#order_serial').val();
						console.log(bin_type,takuhai_gyosya_name,bin_type);
						var all_input = $('#f_input').serialize();
						var request = $.ajax({
						cache: false,
						method: "POST",
						url: "<?php echo $_SERVER['PHP_SELF']?>",
						data: { action:'add_mail_info', kingaku_edited:kingaku_edited, soryo:soryo, hasso_date:hasso_date, totyaku_date:totyaku_date, takuhai_gyosya_name:takuhai_gyosya_name, denpyo_number:denpyo_number, bin_type:bin_type, takuhai_url:takuhai_url, comment_mail:comment_mail, order_serial:order_serial},
						});
					}
				}
			});
			// $(document).on('click', '.hassou-btn',function(){
			// 	const order_serial = $(this).data('id');
			// 	console.log(order_serial);
			// 	const result = $.ajax({
			// 		url: '/outlet/valeur/seller/order_list.php',
			// 		type:'POST',
			// 		data: { action: 'kakunin_detail' ,order_serial: order_serial },
			// 		// dataType: 'jsonp',
			// 		success: function (data) {
			// 			console.log("abc");
			// 		},
			// 		error: function () {
			// 			console.log('エラーが起きました');
			// 		},
			// 	});
			// })
		});

		// 発送日・到着予定日の入力をカレンダーにする
		$( function() {
			$('#hasso_date').datepicker();
			$('#totyaku_date').datepicker();
			$("#hasso_date").attr('readonly', 'readonly');
			$("#totyaku_date").attr('readonly', 'readonly');
		});

		function takuhai_change(obj){
		document.getElementsByName( "takuhai_gyosya_name" )[0].value = "";
		document.getElementsByName( "takuhai_url" )[0].value = "";
		document.getElementsByName( "takuhai_url" )[0].innerText = "";
		var idx = obj.selectedIndex;
		if( obj.options[idx].value == "その他" ){
			document.getElementsByName( "takuhai_gyosya_name" )[0].value = "";
			document.getElementsByName( "takuhai_gyosya_name" )[0].readOnly  = false ;
			document.getElementsByName( "takuhai_gyosya_name" )[0].style.backgroundColor = "#ffffff";
		}else if( obj.options[idx].value == "ヤマト運輸"  ){
			document.getElementsByName( "takuhai_gyosya_name" )[0].value = "ヤマト運輸" ;
			document.getElementsByName( "takuhai_gyosya_name" )[0].readOnly  = true ;
			document.getElementsByName( "takuhai_gyosya_name" )[0].style.backgroundColor = "#e9e9e9";
			document.getElementsByName( "takuhai_url" )[0].value = "http://toi.kuronekoyamato.co.jp/cgi-bin/tneko" ;
			document.getElementsByName( "takuhai_url" )[0].innerText  = "http://toi.kuronekoyamato.co.jp/cgi-bin/tneko" ;
		}else if( obj.options[idx].value == "佐川急便"  ){
			document.getElementsByName( "takuhai_gyosya_name" )[0].value = "佐川急便" ;
			document.getElementsByName( "takuhai_gyosya_name" )[0].readOnly  = true ;
			document.getElementsByName( "takuhai_gyosya_name" )[0].style.backgroundColor = "#e9e9e9";
			document.getElementsByName( "takuhai_url" )[0].value = "https://k2k.sagawa-exp.co.jp/p/sagawa/web/okurijoinput.jsp" ;
			document.getElementsByName( "takuhai_url" )[0].innerText  = "https://k2k.sagawa-exp.co.jp/p/sagawa/web/okurijoinput.jsp" ;
		}else if( obj.options[idx].value == "ゆうパック"  ){
			document.getElementsByName( "takuhai_gyosya_name" )[0].value = "ゆうパック" ;
			document.getElementsByName( "takuhai_gyosya_name" )[0].readOnly  = true ;
			document.getElementsByName( "takuhai_gyosya_name" )[0].style.backgroundColor = "#e9e9e9";
			document.getElementsByName( "takuhai_url" )[0].value = "https://trackings.post.japanpost.jp/services/srv/search/input" ;
			document.getElementsByName( "takuhai_url" )[0].innerText  = "https://trackings.post.japanpost.jp/services/srv/search/input" ;
		}else{
			document.getElementsByName( "takuhai_gyosya_name" )[0].value = "";
			document.getElementsByName( "takuhai_gyosya_name" )[0].readOnly  = true ;
			document.getElementsByName( "takuhai_gyosya_name" )[0].style.backgroundColor = "#e9e9e9";
			document.getElementsByName( "takuhai_url" )[0].value = "";
			document.getElementsByName( "takuhai_url" )[0].innerText = "";
		}
		
		function f_get_soryo_data(){
			window.name = 'parentWin';
			var subwin = window.open('/item/seller/soryo_valeur.php?soryo_flg=1&id=<?php echo $S_id;?>&ai_serial=1', 'about:blank', 'bill_general_input_subwin', 'resizable=yes,scrollbars=yes');
			subwin.moveTo(0,0);
			subwin.window.resizeTo(1000,900);
			subwin.onload = function(){ 
				this.onbeforeunload = function(){
					var soryo = subwin.document.getElementById('fee_selected').value;
					if(soryo){
						$('#soryo').val(soryo);
					}
					
				}
			}
		}
	}
	</script>
	<style>
	#seller_all_tbl thead{
		background-color: #D2D0FF;
	}
	#seller_all_tbl_filter{
		margin-bottom: 10px;
	}
	td{
		border-bottom: 1px solid #8a8989 !important;
	}
	h2.title-radius{
		background-color: #00abff78;
		display: inline-block;
		padding: 5px 20px;
		border-radius: 10px;
	}
	.explanation{
		font-size:80%;
		line-height:140%;
	}
	.coution {
		background:url(/item/img/icon_cyui.gif) left top no-repeat;
		color:#2959f4;
		font-size:80%;
		padding: 0 0 0 15px;
		margin:10px 0 10px 0;
	}
	.line {
		border:#009900 solid 1px;
		padding:0;
		margin:2px 0 10px 0;
	}
	.green-title {
		color:#009900;
		font-weight:bold;
	}
	.ex {
		color:#999;
		font-weight:bold;
		font-size:80%;
		line-height:140%;
		margin:0 0 10px 0;
	}
	.white {color: #ffffff;}
	.red {color: #ff0000;}
	.err_msg{
		width: 600px;
		padding: 10px;
		margin-top:10px;
		background-color: #FCEFEF;
		border: 1px solid #F00;
		font-size:14px;
		color: red;
		text-align: left;
		border-radius: 10px;        /* CSS3草案 */
		-webkit-border-radius: 10px;    /* Safari,Google Chrome用 */
		-moz-border-radius: 10px;   /* Firefox用 */
	}
	.mail_table td{
		vertical-align:top;
	}
	.hankaku{
		font-size:12px;
	}
	/* 点滅 */
	.blinking{
		-webkit-animation:blink 1.0s ease-in-out infinite alternate;
		-moz-animation:blink 1.0s ease-in-out infinite alternate;
		animation:blink 1.0s ease-in-out infinite alternate;
	}
	.button_input input{
		margin-bottom: 20px;
	}
	.button_input input:last-child{
		margin-bottom: 0px;
	}
	@-webkit-keyframes blink{
		0% {opacity:0;}
		100% {opacity:1;}
	}
	@-moz-keyframes blink{
		0% {opacity:0;}
		100% {opacity:1;}
	}
	@keyframes blink{
		0% {opacity:0;}
		100% {opacity:1;}
	}

	.cahcel_btn{
		background-color: #f1f90d;
		border-radius: 5px;
		font-size: 13px;
	}

	.daibiki_btn{
		background-color: #0df9d8;
		border-radius: 5px;
		font-size: 13px;
	}

	.taiou_btn{
		background-color: #00d9fd;
		border-radius: 5px;
		font-size: 13px;
	}
	.yoku_icon {
		background:url(/order_db/img/icon_yokuhatsu.png) left top no-repeat;
		display: block;
		width: 50px;
		height: 23px;
		margin-top: 10px;
	}
	.f-size_20px{
		font-size: 20px;
	}
	.width_50p {
		width: 50%;
	}
	.fs{
		font-size: 18px;
	}
	p{
		margin-bottom: 0;
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
		<div class="row">
			<div class="col-md-12 mb-3">
				<button class="btn btn-danger text-start" style="width:100%;" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2">ルール・ご注意事項など（ここをクリックしてください）</button>
			</div>
			<!-- 表示したい場合add class "show" -->
			<div class="col-md-6 col-sm-6 col-xs-12 collapse multi-collapse" id="multiCollapseExample1">
				<div class="" style="background:#ffffcc;padding:5px 20px;margin-bottom:10px;">
					<h3 class="fs">【ご注文対応のルール】</h3>
					<ul class="disc">
						<li>ご注文確認後は速やかに<span class="bold red underline">確認メール</span>を送信してください。</li>
						<li>発送の準備ができましたら<span class="bold red underline">発送メール</span>を送信して商品を発送してください。</li>
						<li>キャンセルは翌月2日の正午までです。それ以降のキャンセルはお受けできません。</li>
					</ul>
				</div>

				<div class="" style="background:#ccffcc;padding:5px 20px;margin-bottom:10px;">
				<h3 class="fs">【Ｍコイン注文、カード決済の場合】</h3>
					<ul class="disc">
						<li>代引き同様に速やかに<span class="bold red underline">確認メール</span>を送信してください。<br>
						<span class="bold red underline">確認メール送信時に支払い完了</span>しますので入力はお間違えのないようにお願いします。</li>
						<li>送料が未確定の場合、<span class="bold red underline">仮確認メール</span>を送信してから確定後に確認メールを送信します。</li>
						<li>発送の準備ができましたら<span class="bold red underline">発送メール</span>を送信して商品を発送してください。<br>
						<span class="underline">※確認メールを忘れると支払いが完了しませんのでご注意ください。</span></li>
					</ul>
				</div>

				<div class="" style="background:#ccffff;padding:5px 20px;">
					<h3 class="fs">【銀行振込注文の場合】</h3>
					<ul class="disc">
						<li>代引き同様に速やかに<span class="bold red underline">確認メール</span>を送信してください。<br>
						<span class="bold red underline">確認メールで送信した金額を振込みます</span>ので入力はお間違いのないようにお願いします。</li>
						<li>発送の準備ができましたら<span class="bold red underline">発送メール</span>を送信して商品を発送してください。</li>
					</ul>
				</div>
			</div>
			<!-- 表示したい場合add class "show" -->
			<div class="col-md-6 col-sm-6 col-xs-12 collapse multi-collapse" id="multiCollapseExample1">
				<div style="background:#ffffcc;padding:5px 20px;margin-bottom:10px;">
				<h3 class="fs">【各ボタン説明】</h3>
				<ul class="btn_info">
					<li>
						<div style="width : 140px" class="text_center">
							<button class="btn btn-primary" disabled>送信画面へ</button>
						</div>
						<div>
							メール送信画面にすすみます。<br>
							送信後は送信日時が表示されます。
						</div>
					</li>
					<li>
						<div style="width : 140px" class="text_center">
							<button class="btn btn-info ps-4 pe-4" disabled>対応済</button>
						</div>
						<div>
							電話対応などでメールの送信が必要ない場合や<br>
							既に対応済の注文に対して使用します。<br>
							代金引換は、発送メールを送らずに対応済にした場合は<br>
							買い手が<span class="bold red underline">インボイスを発行できません。</span><br>
						</div>
					</li>
					<li>
						<div style="width : 140px" class="text_center">
							<button class="btn btn-warning" disabled>キャンセル申請</button>
						</div>
						<div>
							キャンセルが発生した際に使用します。<br>
							ボタン押下後に理由を記入して申請してください。<br>
							買い手様にはメッセージは届きません。<br>
							キャンセルの場合でもマーケット利用料は発生します。

						</div>
					</li>
					
				</ul>
				</div>
				<div class="f-size_20px">
					<a href="/order_db/order_list_manual.pdf" target="_blank">※操作手順・マニュアルはこちら</a>
				</div>
			</div>
		</div>
	</section>
	<section class="mt-3">
		<div class="row">
			<div class="col-md-4">
				
				<div class="card mb-3 p-3" style="max-width: 440px;">
					<div class="row g-0">
						<div class="col-md-8">
							<div class="card-body p-0 mt-1">
								<h5 class="card-title mb-0">銀行振込用銀行口座情報：</h5>
							</div>
						</div>
						<div class="col-md-4">
							<!-- <button type="button" class="btn btn-danger show_bank_info" data-bs-toggle="modal" data-bs-target="#staticBackdrop">銀行口座登録</button> -->
							<button type="button" class="btn btn-<?php echo (!empty($bank['bank_info']) ? 'success' :'danger');?> show_bank_info" >
								<?php echo (!empty($bank['bank_info']) ? '銀行口座編集' :'銀行口座登録');?>
							</button>
						</div>
					</div>
				</div>
				
			</div>
			<div class="col-md-8"></div>
		</div>
	</section>
	<section class="mt-4">
		<table class="table table-hover table-bordered top" id="seller_all_tbl">
			<thead class="align-middle text-center top sticky-top">
				<tr>
					<th style="width: 40px" class="p-0 text-center">No</th>
					<th style="width: 60px" class="p-0 text-center">チェック</th>
					<th style="width: 100px" class="p-0 text-center">受注日時</th>
					<th style="width: 100px" class="p-0 text-center">買い手情報</th>
					<th style="width: 150px" class="p-0 text-center">商品名</th>
					<th style="width: 40px" class="p-0 text-center">数量</th>
					<th style="width: 80px" class="p-0 text-center">商品代金</th>
					<th style="width: 100px" class="p-0 text-center">都道府県</th>
					<th style="width: 60px" class="p-0 text-center">送料</th>
					<th style="width: 80px" class="p-0 text-center">合計金額</th>
					<th style="width: 100px" class="p-0 text-center">支払方法</th>
					<th style="width: 200px" class="p-0 text-center">コメント</th>
					<th style="width: 120px;" class="p-0 text-center">発送予定</th>
					<th style="width: 100px" class="p-0 text-center">配送情報</th>
					<th style="width: 100px" class="p-0 text-center">受注内容入力</th>
					<th style="width: 100px" class="p-0 text-center">確認メール</th>
					<th style="width: 100px" class="p-0 text-center">発送メール</th>
					<th style="width: 100px" class="p-0 text-center">イレギュラー</br>対応ボタン</th>
					<!-- <th>伝票番号</th> -->
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</section>
</main>
<?php 
?>
<!-- modal -->
<div id="input_window" title="メール内容入力" style="display:none;">
	<span class="red">※</span>は必要科目です。<br>
	<span id="order_info" style="background-color: #00dbff;"></span>
	<form id="f_input" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
	<table class="mail_table">
	<tr>
		<td>【代金】<span class="red">※</span><span class="hankaku">(半角)</span></td>
		<td><input type="text" name="kingaku_edited" size="15" value="" id="kingaku_edited">円（税込）</td>
	</tr>
	<tr>
		<td>【送料】<span class="red" id="f_soryo">※</span><span class="hankaku">(半角)</span></td>
		<td>
			<input type="text" name="soryo" size="15" value="" id="soryo">円
			<input type="button" value="送料表" onclick="f_get_soryo_data(this)">
			<a href="/item/seller/soryo_valeur.php?id=eiyo_food&ai_serial=1" target="_blank">送料表</a>
		</td>
	</tr>
	<tr>
		<td>【発送予定日】<span class="red">※</span><span class="hankaku"></span></td>
		<td><input type="text" name="hasso_date" size="15" id="hasso_date" value=""></td>
	</tr>
	<tr>
		<td>【到着予定日】<span class="red">※</span><span class="hankaku"></span></td>
		<td>
			<input type="text" name="totyaku_date" size="15" id="totyaku_date" value="">
			<input type="button" id="next_date" value="翌日">
			<input type="button" id="after_next_date" value="翌々日">
		</td>
	</tr>
	<tr>
		<td>【宅配業社名】</td>
		<td>
			<select name="takuhai_gyosya_select" id="takuhai_gyosya_select" onchange="takuhai_change(this);">
				<option value="----------">----------</option>
				<option value="ヤマト運輸">ヤマト運輸</option>
				<option value="佐川急便">佐川急便</option>
				<option value="ゆうパック">ゆうパック</option>
				<option value="その他">その他</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>【宅配業社名】(表示用)</td>
		<td><input type="text" name="takuhai_gyosya_name" id="takuhai_gyosya_name" size="30" value="" readonly style="background-color:#e9e9e9"></td>
	</tr>
	<tr>
		<td>【荷物伝票番号】<span class="hankaku">(半角)</span></td>
		<td><input type="text" name="denpyo_number" id="denpyo_number" size="30" value="" onblur="denpyo_change(this)"></td>
	</tr>
	<tr>
		<td>【保存方法】</td>
		<td>
			<label><input type="radio" name="bin_type" id="bin_type_0" value="常温">常温</label>
			<label><input type="radio" name="bin_type" id="bin_type_1" value="冷凍">冷凍</label>
			<label><input type="radio" name="bin_type" id="bin_type_2" value="冷蔵">冷蔵</label>
		</td>
	</tr>
	<tr>
		<td>【お問合せURL】<span class="hankaku">(半角)</span></td>
		<td><input type="text" name="takuhai_url" id="takuhai_url" size="45" value="" onblur="url_change(this)"></td>
	</tr>
	<tr>
		<td>【その他】</td>
		<td><textarea name="comment_mail" id="comment_mail" cols="40" rows="3"></textarea></td>
	</tr>
	<input type="hidden" name="kind" id="kind" value="add_mail_info">
	<input type="hidden" name="order_serial" id="order_serial" value="">
	<input type="hidden" name="payment_type" id="payment_type" value="">
	<input type="hidden" name="fun_name" id="fun_name" value="">
	<input type="hidden" name="mail_kakunin" id="mail_kakunin" value="">
	<input type="hidden" name="mail_hassou" id="mail_hassou" value="">
	</table>
	</form>
	<p style="color:blue;">
		※カード決済とMコインの場合は確認メール送信時に上記金額を決済します。<br>
		※発送メール配信の場合「宅配業社名と荷物伝票番号」が必要です。
	</p>
</div>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="" method="POST" id="base_modal">
		<div class="modal-content">
		<div class="modal-header">
			<h1 class="modal-title fs-5" id="modalTitle">タイトル</h1>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
			<div class="text-center p-4" id="modal_loading" style="display: none">
				<div class="spinner-border text-primary" role="status">
					<span class="visually-hidden">Loading...</span>
				</div>
			</div>
		</div>
		
		<div class="modal-footer">
			<button type="button" class="btn btn-primary ps-5 pe-5" id="modal_btn_reg" data-seller_id="<?php echo $S_id;?>">登録</button>
			<button type="button" class="btn btn-secondary ps-5 pe-5" data-bs-dismiss="modal">Close</button>
		</div>
		</div>
		<input type="hidden" name="kind" id="kind" value="" />
	</form>
  </div>
</div>

</body>
</html>
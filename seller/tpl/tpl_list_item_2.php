<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <title><?php echo(escape($config['title']));?></title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"> -->
       
    <script type="text/javascript" language="javascript" src='/outlet/valeur/common/js/list_itemreg.js?<?php echo time()?>'></script>
    
    <script type="text/javascript">
        $(function () {
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
        jQuery( function() {
    

            $('.detail_item').on('click', function(){
                const f_serial = $(this).data('serial');
                const request = $.ajax({
                    method: 'POST',
                    dataType: "json",
                    url: "/outlet/valeur/kanri/debut_list_modal.php",
                    data: {'mode':'detail','f_serial':f_serial},
                    success: function(response) {
                        console.log('SUCCESS BLOCK');
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
                            "<td>" + '第一カテ：'+response.c_cate1 + cate2_text + cate3_text + cate4_text + cate5_text + " </td>" + "</tr>";
                            tr_str += "<tr>" + "<th>商品名</th>" +
                            "<td>" + response.m_item + "</td>" + "</tr>";
                            tr_str += "<tr>" + "<th>商品名ヨミガナ</th>" +
                            "<td>" + response.m_item_kana + "円</td>" + "</tr>";
                            tr_str += "<tr>" + "<th>単価</th>" +
                            "<td>" + response.m_tanka + "</td>" + "</tr>";
                            tr_str += "<tr>" + "<th>単位</th>" +
                            "<td>" + response.m_tanka_tani + "</td>" + "</tr>";
                            tr_str += "<tr>" + "<th>定貫・不定貫</th>" +
                            "<td>" + response.m_teikan + "</td>" + "</tr>";
                            tr_str += "<tr>" + "<th>受注最小ロット</th>" +
                            "<td>" + response.m_lot_small + "</td>" + "</tr>";
                            tr_str += "<tr>" + "<th>受注最小ロットの合計金額</th>" +
                            "<td>" + response.m_price_lot + "円</td>" + "</tr>";
                            tr_str += "<tr>" + "<th>生(原)産地</th>" +
                            "<td>" + response.m_sanchi + "</td>" + "</tr>";
                            // tr_str += "<tr>" + "<th>加工地 abc</th>" +
                            // "<td>" + response.m_bikou + "</td>" + "</tr>";
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
			$('.zaiko_settei').on('click', function(){
				// $('#zaiko').modal('show');
				// $('.close').on('click', function(){
				// 	$('#zaiko').modal('hide');
				// });
           		var zaikou = $(this).closest("tr").find('p[name="td_zaikou"]');
				const ai_serial = $(this).closest("tr").find('p[name="td_zaikou"]').data('serial');
				const in_ryou = $('input[name="in_ryou"]').val(zaikou.text());
				const in_lot = $('input[name="in_lot"]').val(zaikou.text());
				$('input[name="in_zaiko"]').val(zaikou.text());
				// console.log(ai_serial);
				$('.henkou_btn').on('click', function(){
					
				const in_zaiko = $('input[name="in_zaiko"]').val();
				console.log(ai_serial);

				// $.ajax({
				// 	url: '/outlet/valeur/seller/list_item_2.php',
				// 	type:'POST',
				// 	data: {p_kind:'zaikou_settei', ai_serial:ai_serial, in_zaiko:in_zaiko},
				// 	success: function (res) {
				// 		// zaikou.text(in_zaiko);
				// 		$('#zaiko').modal('hide');
				// 	},
				// 	error: function (res) {
				// 		alert('エラーが起きました');
				// 	},
				// });
				})
			});

        });
    
    </script>

    <style>
        /* .custom-tooltip{
            --bs-tooltip-bg: #dc3545 !important;
            --bs-tooltip-color: var(--bs-white);
        } */
		.fz-13{
			font-size: 13px;
		}
		p {
			margin: 0;
		}
    </style>
    
</head>


    <body>
        <section class="container-fluid mt-3"> 
        <?php include_once('/var/www/html3/outlet/valeur/seller/tpl/tpl_header.php')?>

        <div class="alert alert-success" id="success-alert" style="display: none;">
            <button type="button" class="close" data-dismiss="alert">x</button>
            商品確認完了しました。
        </div>

        <div class="mb-3"><a type="button" class="btn btn-outline-primary" href="/outlet/valeur/seller/itemreg.php">新しい商品登録申請</a></div>
        <nav class="mb-5">
            <div class="nav nav-tabs " id="nav-tab" role="tablist">
                <button  class="nav-link ps-4 pe-4 active" id="tab_all" data-bs-toggle="tab" data-bs-target="#nav_tab_all" type="button" role="tab" aria-controls="nav_tab_all" aria-selected="true">
                    全ての商品
                </button>
                <button class="nav-link ps-4 pe-4" id="tab_wait" data-bs-toggle="tab" data-bs-target="#nav_tab_wait" type="button" role="tab" aria-controls="nav_tab_wait" aria-selected="false">
                    申請中
                </button>
                <button class="nav-link  ps-4 pe-4" id="tab_done" data-bs-toggle="tab" data-bs-target="#nav_tab_done" type="button" role="tab" aria-controls="nav_tab_done" aria-selected="false">
                    公開済み
                </button>
                <button class="nav-link  ps-4 pe-4" id="tab_henshin" data-bs-toggle="tab" data-bs-target="#nav_tab_henshin" type="button" role="tab" aria-controls="nav_tab_henshin" aria-selected="false">
                    返信
                </button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
             <!-- 全ての商品 -->
             <?php if(!empty($A_items)):?>
                <?php foreach ($A_items as $key => $items) { 
                    $f_tab_id = 'nav_tab_'.$key;
                    $f_button_tab = 'tab_'.$key;
                    $show = $key == 'all' ? 'show active' : '';
                    ?>
                    <div class="tab-pane fade <?php echo $show;?>" id="<?php echo $f_tab_id;?>" role="tabpanel" aria-labelledby="#<?php echo $f_button_tab;?>">
                        <form method="post" id="f_base_<?php echo $key; ?>" name="f_base_<?php echo $key; ?>" action="<?php echo $_SERVER['PHP_SELF']; ?>" target="_self">
                            <table class="table table-hover table-bordered top" id="shinsei_tbl">
                                <thead  class="align-middle text-center top">
                                    <tr>
                                        <th style="width: 40px">No.</th>
                                        <th style="width: 100px">状態</th>
                                        <th style="width: 200px">商品名</th>
                                        <th style="width: 100px">編集</th>
                                        <th style="width: 100px">画像</th>
                                        <th style="width: 100px">在庫</th>
                                        <th style="width: 120px">カテゴリー</th>
                                        <th style="width: 120px">単価/単価単位</th>
                                        <th style="width: 150px">受注最小ロット</th>
                                        <th style="width: 100px">合計金額</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($items)):?>
                                        <?php foreach ($items as $key_item => $item) { 
                                            //返信理由
                                            $f_kyakka_mes = '';
                                            if($item['review_flg'] == 2 && !empty($item['review_time'])){
                                                if($item['review_message']){
                                                    $f_kyakka_mes = 'data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="'.$item['review_message'].'"';
                                                }
                                            }

                                            // 状態
                                            $f_status = '申請中';
                                            if($item['shounin_flg'] == 1 && $item['review_flg'] == 1){
                                                $f_status = '公開中';
                                            }else if(($item['shounin_flg'] == 2 && $item['review_flg'] == 1) 
                                            || ($item['shounin_flg'] == 0 && $item['review_flg'] == 2)){
                                                $f_status = '返信';
                                            }

                                            // 返信場合　価格再設定
                                            $btn_re_set_price = '';
                                            
                                            if($item['shounin_flg'] == 0 && $item['review_flg'] == 2 && !empty($item['review_message'])){
                                                $btn_re_set_price = '<button 
                                                    type="button"
                                                    class="btn btn-outline-danger pt-0 pb-0 re_set_price_html" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#detail_item"
                                                    data-item="'.$item['m_item'].'"
                                                    data-item_tanka="'.$item['m_tanka'].'"
                                                    data-item_tani="'.$item['m_tanka_tani'].'"
                                                    data-item_price_lot="'.$item['m_price_lot'].'"
                                                    data-item_ai_serial="'.$item['ai_serial'].'"
                                                >価格再設定</button>';
                                            }else{
                                                $btn_re_set_price = '';
                                            }


                                            ?>
                                            <tr <?php echo $f_kyakka_mes;?> >
                                                <!-- No -->
                                                <td valign="middle" class="text-center"><?php echo $key_item +1 ;?></td>
                                                <!-- 状態 -->
                                                <td valign="middle"><?php echo $f_status;?></td>
                                                <!-- 商品名 -->
                                                <td valign="middle" class="text-center">
                                                    <div data-toggle="modal" data-target="#detail_item" style="cursor: pointer;text-decoration: underline;color: #1e87f0;" data-serial="<?php echo $item['ai_serial'];?>" class="detail_item"><?php echo $item['m_item'] ;?></div>
                                                </td>
                                                <!-- 編集ボタン -->
                                                <td valign="middle" class="text-center" id="lotkingaku_<?php echo $item['ai_serial'];?>">
                                                    <a href="/outlet/valeur/seller/itemreg.php?p_kind=item_edit&ai_serial=<?php echo $item['ai_serial'];?>" class="btn btn-outline-primary pt-0 pb-0 mb-1">編集</a>
                                                    <button class="btn btn-outline-success pt-0 pb-0 mb-1">コピー</button>
                                                    <button class="btn btn-outline-danger pt-0 pb-0">削除</button>
                                                </td>
                                                <!-- 画像 -->
                                                <td valign="middle" class="text-center">
                                                    <img src="<?php echo DF_f_pic_fold.$item['m_pic1'] ?>" width="80">
                                                </td>
                                                <!-- 在庫 -->
                                                <td valign="middle" class="text-center">
                                                    <p name="td_zaikou" data-serial="<?php echo $item["ai_serial"] ;?>"><?php echo $item["m_zaiko"] ;?></p>
                                                    <div>
                                                        <!-- <button type="button" class="btn btn-primary zaiko_settei">設定</button> -->
														<button type="button" class="btn btn-primary zaiko_settei" data-toggle="modal" data-target="#zaiko">
														設定
														</button>
                                                        <button type="button" class="btn btn-danger zaiko_urikire">売切れ</button>
                                                    </div>
                                                </td>
                                                <!-- カテゴリー -->
                                                <td valign="middle" class="text-center">
                                                    <?php echo '第一カテ：'.$item['c_cate1']; ?>
                                                    <?php 
                                                    // echo isset($item['c_cate2']) ? '第二カテゴリー：'.$item['c_cate2'] : ''; 
                                                    // echo isset($item['c_cate3']) ? '第三カテゴリー：'.$item['c_cate3'] : ''; 
                                                    // echo isset($item['c_cate4']) ? '第四カテゴリー：'.$item['c_cate4'] : ''; 
                                                    // echo isset($item['m_cate_m5']) ? '種別カテゴリ：'.$item['m_cate_m5'] : '';
                                                     ?>
                                                </td>
                                                <!-- 単価／単位 -->
                                                <td valign="middle" class="text-center">
                                                    <span id="tanka_<?php echo $item['ai_serial'];?>"><?php echo number_format($item['m_tanka'])?></span><?php echo '円／'.$item['m_tanka_tani'] ;?>
                                                    <br/><?php echo $btn_re_set_price;?>
                                                    
                                                </td>
                                                <!-- 受注最小ロット -->
                                                <td valign="middle" class="text-center"><?php echo ($item['m_lot_small']) ;?></td>
                                                <!-- 合計金額 -->
                                                <td valign="middle" class="text-center" id="lotkingaku_<?php echo $item['ai_serial'];?>"><?php echo number_format($item['m_price_lot']) ;?>円</td>
                                                
                                            </tr>
                                        <?php } ?>
                                    <?php ?>
                                    <?php else:?>
                                        <td colspan="8" class="text-center pt-4 pb-4"><h4>該当商品情報がありません。</h4></td>
                                    <?php endif;?>
                                </tbody>
                            </table>
                            
                        </form>
                    </div>
                   
               <?php } ?> 
             <?php endif;?>
        </div>
           
        </section>
        <!-- item detail modal -->
        <div class="modal fade bd-example-modal-lg" id="detail_item" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLabel">商品詳細：</h5>
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
        <!-- zaiko modal -->
		<div class="modal fade" id="zaiko" tabindex="-1" role="dialog" aria-labelledby="zaikoLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="zaikoLabel">在庫の変更</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form>
				<table class="table table-bordered">
					<tbody>
						<tr>
							<th scope="row" width="25%">在庫設定</th>
							<td>
								<label>
									<input name="zaiko_disp_flg" id="zaiko_disp_flg" type="checkbox" checked="" data-ai_serial="">在庫を表示する
								</label>
								<p class="fz-13">
								設定しない場合は何も入力しないで下さい
								</p>
								<p class="fz-13">
								半角数字以外は入力不可
								</p>
								<p class="fz-13">
								在庫数が0になると「品切れ中」になります。
								</p>
								<p class="fz-13">
								再度、在庫数を設定する場合、「品切れ中」を解除して在庫数を設定してください。
								</p>
								<p class="fz-13">
								※在庫更新の場合、「通常在庫と連動する」設定してる市場の在庫自動で更新する可能性があります。
								</p>
							</td>
						</tr>
						<tr>
							<th scope="row">総重量（kg）</th>
							<td><input type="text" name="in_ryou" value=""></td>
						</tr>
						<tr>
							<th scope="row">1ロットあたりの数量（kg）</th>
							<td><input type="text" name="in_lot" value=""></td>
						</tr>
						<tr>
							<th scope="row">在庫数</th>
							<td><input type="text" name="in_zaiko" value=""></td>
						
						</tr>
					</tbody>
				</table>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary close" data-dismiss="modal">キャンセル</button>
				<button type="button" class="btn btn-primary henkou_btn">変更</button>
			</div>
			</div>
		</div>
		</div>
    </body>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script> -->
</html>

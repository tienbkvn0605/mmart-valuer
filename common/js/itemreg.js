
var $G_picuplimit = 4000000;		//アップ画像ファイル許可最大サイズ4Mb
var $G_picUpWidthLimit =  2000;		//PDF画像ファイル許可最大サイズ300KB
var BASE_AJAX_URL = '/outlet/valeur/seller/itemreg.php';


jQuery(function(){
	
	// 第一カテゴリー　選択
	$('#cate1no').change(function(){
		var cate1_serial = $(this).val();

		if(parseInt(cate1_serial) == 9){
			$('#eiyou_input').show();
		}else{
			$('#eiyou_input').hide();
		}

		// 掲載期限
		if(parseInt(cate1_serial)==2 || parseInt(cate1_serial)==3 || parseInt(cate1_serial)==4){
			$('#displimit').show();
		}else{
			$('#displimit').hide();
		}

		if(parseInt(cate1_serial) != 0){
			var request = $.ajax({
				type : 'POST',
				url : BASE_AJAX_URL,
				data : {
					p_kind : 'get_category_2',
					cate1_serial
				}
			})
			// $('#cate1_serial').val(cate1_serial);
			request.done(function (res) {
				if(res === 'error'){
					
				}else{
					var res_split = res.split(':r:');
					if(res_split[1] == 'OK'){
						var A_cate2 = JSON.parse(res_split[2]);
						var select_html = '<option value="0">‐選択‐</option>';

						// 商品編集か　商品情報確認画面から戻るか
						var cate2_serial_ajax = '';
						if($('cate2_serial_ajax') != undefined){
							cate2_serial_ajax = $('#cate2_serial_ajax').val();
						};
						$('#cate2no').html('');
						var selected = '';
						$.each(A_cate2, function (cate_serial, cate_text) {
							if(cate2_serial_ajax && cate2_serial_ajax == cate_serial){
								selected = 'selected';
							}else{
								selected = '';
							}
							select_html += '<option '+selected+' value="'+cate_serial+'">'+cate_text+'</option>';
						})
						$('#cate2no').html(select_html);
						$('#cate2_box').show();

						$('#cate3no').html('');
						$('#cate3_box').hide();
						
						$('#cate4no').html('');
						$('#cate4_box').hide();

						$('#cate5no').html('');
						$('#cate5_box').hide();
					}
				}
				
			})
		}else{
			$('#cate2no').html('');
			$('#cate2_box').hide();

			$('#cate3no').html('');
			$('#cate3_box').hide();
			
			$('#cate4no').html('');
			$('#cate4_box').hide();

			$('#cate5no').html('');
			$('#cate5_box').hide();
		}
		
	})
	// 第二カテゴリー　選択
	$('#cate2no').change(function(){
		var cate1_serial = $('#cate1no').val();
		var cate2_serial = $(this).val();
		if(!cate2_serial && parseInt($('#cate2_serial_ajax').val()) > 0){
			cate2_serial = $('#cate2_serial_ajax').val();
		}
		if(parseInt(cate2_serial) != 0){
			var request = $.ajax({
				type : 'POST',
				url : BASE_AJAX_URL,
				data : {
					p_kind : 'get_category_3',
					cate1_serial,
					cate2_serial,
				}
			})
			
			// $('#cate2_serial').val(cate2_serial);
			request.done(function (res) {
				if(res === 'error'){
	
				}else{
					var res_split = res.split(':r:');
					if(res_split[1] == 'OK'){
						var A_cate3 = JSON.parse(res_split[2]);
						var select_html = '<option value="0">‐選択‐</option>';
						
						// 商品編集か　商品情報確認画面から戻るか
						var cate3_serial_ajax = '';
						if($('cate3_serial_ajax') != undefined){
							cate3_serial_ajax = $('#cate3_serial_ajax').val();
						};
						
						var selected = '';
						$('#cate3no').html('');
						$.each(A_cate3, function (cate_serial, cate_text) {
							if(cate3_serial_ajax && cate3_serial_ajax == cate_serial){
								selected = 'selected';
							}else{
								selected = '';
							}
							select_html += '<option '+selected+' value="'+cate_serial+'">'+cate_text+'</option>';
						})
						$('#cate3no').html(select_html);
						$('#cate3_box').show();
						
						$('#cate4no').html('');
						$('#cate4_box').hide();

						$('#cate5no').html('');
						$('#cate5_box').hide();
					}
	
				}
				
			})
		}else{
			$('#cate3no').html('');
			$('#cate3_box').hide();

			$('#cate4no').html('');
			$('#cate4_box').hide();

			$('#cate5no').html('');
			$('#cate5_box').hide();
		}
		
	})
	// 第三カテゴリー　選択
	$('#cate3no').change(function(){
		var cate1_serial = $('#cate1no').val();
		var cate2_serial = $('#cate2no').val();
		var cate3_serial = $(this).val();
		if(!cate2_serial && parseInt($('#cate2_serial_ajax').val()) > 0){
			cate2_serial = $('#cate2_serial_ajax').val();
		}
		if(!cate3_serial && parseInt($('#cate3_serial_ajax').val()) > 0){
			cate3_serial = $('#cate3_serial_ajax').val();
		}
		if(parseInt(cate3_serial) != 0){
			var request = $.ajax({
				type : 'POST',
				url : BASE_AJAX_URL,
				data : {
					p_kind : 'get_category_4',
					cate1_serial,
					cate2_serial,
					cate3_serial
				}
			})
			// $('#cate3_serial').val(cate3_serial);
			request.done(function (res) {
				if(res === 'error'){
	
				}else{
					var res_split = res.split(':r:');
					if(res_split[1] == 'OK'){
						var A_cate4 = JSON.parse(res_split[2]);
						var select_html = '<option value="0">‐選択‐</option>';
						
						// 商品編集か　商品情報確認画面から戻るか
						var cate4_serial_ajax = '';
						if($('cate4_serial_ajax') != undefined){
							cate4_serial_ajax = $('#cate4_serial_ajax').val();
						};
						var selected = '';
						
						$('#cate4no').html('');
						$.each(A_cate4['cate4'], function (cate_serial, cate_text) {
							if(cate4_serial_ajax && cate4_serial_ajax == cate_serial){
								selected = 'selected';
							}else{
								selected = '';
							}
							select_html += '<option '+selected+' value="'+cate_serial+'">'+cate_text+'</option>';
						})
						$('#cate4no').html(select_html);
						$('#cate4_box').show();
	
						if(A_cate4['shubetsu'] != undefined){
							var shubetsu_html = '<option value="0">‐選択‐</option>';
							$('#cate5no').html('');
							// 商品編集か　商品情報確認画面から戻るか
							var cate5_serial_ajax = '';
							if($('cate5_serial_ajax') != undefined){
								cate5_serial_ajax = $('#cate5_serial_ajax').val();
							};
							var selected = '';
							
							$.each(A_cate4['shubetsu'], function (cate_serial, cate_text) {
								if(cate5_serial_ajax && cate5_serial_ajax == cate_text){
									selected = 'selected';
								}else{
									selected = '';
								}
								shubetsu_html += '<option '+selected+' value="'+cate_text+'">'+cate_text+'</option>';
							})
							$('#cate5no').html(shubetsu_html);
							$('#cate5_box').show();
						}else{
							$('#cate5no').html('');
							$('#cate5_box').hide();
						}
					}
				}
			})
		}else{
			$('#cate4no').html('');
			$('#cate4_box').hide();

			$('#cate5no').html('');
			$('#cate5_box').hide();
		}
	})

	// 在庫設定
	$(document.body).on('click', '.stock_display' ,function(){
		var ai_serial=$(this).data('ai_serial');
		
		if($(this).prop('checked')==true){
			$('.stock_input_'+ai_serial).show();
		}else{
			$('.stock_input_'+ai_serial).hide();
		}
		
	});

	// 画像サイズチェック
	$(document.body).on('change', '.image_onChange_size', function(){
		var image_name = $(this).data('image_name');
		var title = '';
		switch (image_name) {
			case 'new_pic':
				title = '商品画像';
				break;
			case 'new_pic2':
				title = '商品画像2';
				break;
			case 'new_pic3':
				title = '商品画像3';
				break;
			case 'new_pic4':
				title = '商品画像4';
				break;
			case 'new_pic5':
				title = '商品画像5';
				break;
			case 'new_pic6':
				title = '商品画像6';
				break;
			case 'new_pic7':
				title = '栄養成分画像';
				break;
		}
		var image_file = $(this).prop('files')[0];
		var ele = $(this).val();
		var $img_check = ['jpeg', 'JPEG', '.jpg', '.JPG', '.gif', '.GIF'];
		if(image_file){
			var file_pic = image_file.size;
			var $t_pic=ele;
	
			if(file_pic>$G_picuplimit){	//upファイルサイズ確認
				alert("ファイル選択エラー\n\n画像ファイルの大きさが制限を越えています、ファイルサイズを修正し再度選択してください。");
				ele = '';
				ele.focus();
				return false;
			}
			$f_kaku=$t_pic.substring($t_pic.length-4,$t_pic.length);
			$is_check = $.inArray($f_kaku, $img_check);
			if($is_check<0){
				alert(title+'のファイルは拡張子が「.jpg」「.jpeg」「.gif」のファイルを選択してください');
				ele = '';
				ele.focus();
				return false;
			}
		}

		handleFileSelect($(this)[0], title);
	})

	function handleFileSelect(evt, title) {
		
		var id_name = '';
		if(title == '商品画像'){
			id_name = 'list';
		}else if(title == '商品画像2'){
			id_name = 'list_2';
		}else if(title == '商品画像3'){
			id_name = 'list_3';
		}else if(title == '商品画像4'){
			id_name = 'list_4';
		}else if(title == '商品画像5'){
			id_name = 'list_5';
		}else if(title == '商品画像6'){
			id_name = 'list_6';
		}else if(title == '栄養成分画像'){
			id_name = 'list_7';
		}

		let files = evt.files;
		
		for (let i = 0, f; f = files[i]; i++) {
			let reader = new FileReader();
			reader.onload = (function(theFile) {
				return function(e) {
					resizeImage(e.target.result, function(imgUrl) {
						let dest = document.getElementById(id_name);
						let fig = document.createElement("figure");
						fig.style = "float: left;";
						let image = document.createElement("img");
						image.src = imgUrl;
						image.style = "max-width:600px";
						let caption = document.createElement("figcaption")
						caption.innerHTML = theFile.name + " resized.";
						let resizeImg = document.createElement("input");
						resizeImg.type = "hidden"
						resizeImg.name = evt.id+"_resize"
						resizeImg.value = imgUrl;
						dest.innerHTML= '';
						dest.appendChild(image);
						dest.appendChild(resizeImg);
					});
				}
			})(f);
			reader.readAsDataURL(f);
		}
	}

	//画像リサイズ
	function resizeImage(base64image, callback) {
		const MAX_SIZE = 600;
		let canvas = document.createElement("canvas");
		let ctx = canvas.getContext("2d");
		let image = new Image();
		image.crossOrigin = "Anonymous";
		image.onload = function(evt) {
			let dstWidth, dstHeight;
			if (this.width > this.height) {
				dstWidth = MAX_SIZE;
				dstHeight = this.height * MAX_SIZE / this.width;
			} else {
				dstHeight = MAX_SIZE;
				dstWidth = this.width * MAX_SIZE / this.height;
			}
			canvas.width = dstWidth;
			canvas.height = dstHeight;
			ctx.drawImage(this, 0, 0, this.width, this.height, 0, 0, dstWidth, dstHeight);
			callback(canvas.toDataURL("image/jpeg"));
		};
		image.src = base64image;
	}

	//商品登録・編集・コピーの時、1ロットあたりの数量（kg）を表示するため
	$(document.body).on('blur', '#m_lot_weight', function(){
		var total_weight= $('#total_weight').val(),
			lot_weight=$(this).val(),
			zaiko= $('#zaiko').val();
		$('#lot_weight_hidden').val(lot_weight);
		
		if(typeof total_weight !== 'undefined' && typeof lot_weight !== 'undefined'	&& !isNaN(total_weight)){
			zaiko = Math.floor(total_weight / lot_weight);
			$('#zaiko').val(zaiko);
		}
	});

	//在庫数の変更総重量更新
	$(document.body).on('blur', '#zaiko', function(){
		var total_weight= $('#total_weight').val(),
			lot_weight_hidden=$('#lot_weight_hidden').val(),
			lot_weight	= $('#lot_weight').val(),
			zaiko= $('#zaiko').val();
		
		if(typeof(lot_weight)=='undefined' && typeof(lot_weight_hidden)!='undefined'){
			lot_weight=lot_weight_hidden;
		}
		
		if(typeof lot_weight !== 'undefined' && typeof zaiko !== 'undefined'
			&& !isNaN(lot_weight) && !isNaN(zaiko)
			&& lot_weight!=0 && zaiko!=0
		){
			total_weight = Math.floor(lot_weight * zaiko);
			$('#total_weight').val(total_weight);
		}
	});
	
	//総重量の変更在庫数更新
	$(document.body).on('blur', '#total_weight', function(){
		var total_weight= $('#total_weight').val(),
			lot_weight_hidden=$('#lot_weight_hidden').val(),
			lot_weight	= $('#lot_weight').val(),
			zaiko= $('#zaiko').val();
		
		if(typeof(lot_weight)=='undefined' && typeof(lot_weight_hidden)!='undefined'){
			lot_weight=lot_weight_hidden;
		}
		
		if(typeof total_weight !== 'undefined' && typeof lot_weight !== 'undefined'
			&& !isNaN(total_weight) && !isNaN(lot_weight)
			&& total_weight!=0 && lot_weight!=0
		){
			zaiko = Math.floor(total_weight / lot_weight);
			$('#zaiko').val(zaiko);
		}
	});
});



//-----------------------------------------------
//商品名禁止ワード
//-----------------------------------------------
var $G_item_word=new Array(
	'格安','処分','激安','送料無料',
	'アウトレット',
	'ｱｳﾄﾚｯﾄ',
	'オープン特価',
	'ｵｰﾌﾟﾝ特価',
	'%off',
	'%OFF',
	'%オフ',
	'％off',
	'％OFF',
	'％オフ',
	'、'
);
var $G_picuplimit = 4000000;		//アップ画像ファイル許可最大サイズ4Mb
//-----------------------------------------------
//少数桁チェック
//-----------------------------------------------
function F_check_keta($f_num, $f_point){
	if($f_num == ""){return false;}
	if($f_num.match(/[^0-9.]/) != null){return false;}
	if($f_num.match(/[.]/) == null){return false;}
	var $t_com = $f_num.indexOf(".",0);
	var $t_com = parseInt($t_com,10) + 1 + parseInt($f_point,10);
	return ($f_num.length != $t_com)? false:true;
}

//-----------------------------------------------
//整数チェック
//-----------------------------------------------
function F_check_seisu($f_num){
	if($f_num.match(/[^0-9]/g) || parseInt($f_num, 10) + "" != $f_num){
		return false;
	}else{
		return true;
	}
}

//-----------------------------------------------
//文字置換
//-----------------------------------------------
function F_chikan($f_tex,$f_moto,$f_chikan){
	while(true){
		dummy = $f_tex;
		$f_tex = dummy.replace($f_moto, $f_chikan);
		if(dummy == $f_tex)
			break;
	}
	return $f_tex;
}

//符号なし小数
function isDecimal(numVal){
	var pattern = /^[-]?([1-9]\d*|0)(\.\d+)?$/;
	return pattern.test(numVal);
}

//-----------------------------------------------
//文字列のバイト数取得
//-----------------------------------------------
function getByteCount(value) {
	var count = 0;
	for ( var i = 0; i < value.length; ++i ) {
		var sub = value.substring(i, i + 1);
		//全角の場合２バイト追加。
		if( checkIsZenkaku(sub) ){
			count += 2;
		} else {
			count += 1;
		}
	}
	return count;
}
//-----------------------------------------------
//全角チェック
//-----------------------------------------------
function checkIsZenkaku(value) {
	for (var i = 0; i < value.length; ++i) {
		var c = value.charCodeAt(i);
		//  半角カタカナは不許可
		if (c < 256 || (c >= 0xff61 && c <= 0xff9f)) {
			return false;
		}
	}
	return true;
}

//商品画像
function image_size_check($f_form, ele, title, required){
	
	var $img_check = ['jpeg', 'JPEG', '.jpg', '.JPG', '.gif', '.GIF'];
	if(ele.files[0]){
		var file_pic = ele.files[0].size;
		var $t_pic=ele.value;

		if(file_pic>$G_picuplimit){	//upファイルサイズ確認
			alert("ファイル選択エラー\n\n画像ファイルの大きさが制限を越えています、ファイルサイズを修正し再度選択してください。");
			ele.value = '';
			ele.focus();
			return false;
		}
		$f_kaku=$t_pic.substring($t_pic.length-4,$t_pic.length);
		$is_check = $.inArray($f_kaku, $img_check);
		if($is_check<0){
			alert(title+'のファイルは拡張子が「.jpg」「.jpeg」「.gif」のファイルを選択してください');
			ele.value = '';
			ele.focus();
			return false;
		}
	}

	handleFileSelect(ele, title);

}
//-----------------------------------------------
//新規商品登録入力項目チェック
//-----------------------------------------------
function F_check_item($f_form,$f_setkind){
	
	var cate = $f_form['cate1no'];

	if(parseInt(cate.value)<=0){
		alert("第一カテゴリを選択してください。");
		cate.focus();
		return false;
	}

	if($f_form['cate2no']){
		var cate2 = $f_form['cate2no'];
		if(cate2){
			if(parseInt(cate2.value)<=0){
				alert("第二カテゴリを選択してください。");
				cate2.focus();
				return false;
			}
			if($f_form['cate3no']){
				var cate3 = $f_form['cate3no'];
		
				// 第三カテゴリ確認
				if(cate3){
					if (parseInt(cate3.value)<=0) {
						alert("第三カテゴリを選択してください。");
						cate3.focus();
						return false;
					}else{
						// 第四カテゴリ確認

						if($f_form['cate4no']){
							var cate4 = $f_form['cate4no'];
							if(cate4){
								if (parseInt(cate4.value)<=0) {
									alert("第四カテゴリを選択してください。");
									cate4.focus();
									return false;
								}
							}
						}
						
						if(parseInt(cate3.value) == 3 && parseInt(cate2.value) == 1 && parseInt(cate.value) == 1){
							if($f_form['cate5no']){
								var shubetu = $f_form['cate5no'];
								if(parseInt(shubetu.value) ==0){
									alert("種別カテゴリを選択してください。");
									shubetu.focus();
									return false;
								}
							}
							
						}
					}
				}
			}
			
			
		}
	}
	

	// var f_item = $f_form['item'].value = F_chikan(F_chikan(GF_chara_kana($f_form['item'].value),'×','x'), ' ', '　');;
	var f_item = $f_form['item'].value = F_chikan(F_chikan(($f_form['item'].value),'×','x'), ' ', '　');;
	if(!f_item){
		alert("商品名を入力してください。");
		$f_form['item'].focus();
		return false;
	}else if(getByteCount(f_item)>60){
		alert("商品名は30文字以内で入力してください。");
		$f_form['item'].focus();
		return false;
	}
	for ($i = 0; $i < $G_item_word.length; $i++) {
		if(f_item.indexOf($G_item_word[$i])>-1){
			alert("商品名に「"+$G_item_word[$i]+"」は使えません");
			if($G_item_word[$i] == '送料無料'){
				alert("送料込み、又は送料含むに修正してください");
			}
			$f_form['item'].focus();
			return false;
		}
	}

	// var f_kana = $f_form['kana'].value = GF_chara_kana($f_form['kana'].value);
	var f_kana = $f_form['kana'].value;
	if(!f_kana){
		alert("商品名のヨミガナを入力してください");
		$f_form['kana'].focus();
		return false;
	}else if(getByteCount(f_kana)>200){
		alert("商品名のヨミガナは100文字以内で入力してください");
		$f_form['kana'].focus();
		return false;
	}

	// var f_price	=$f_form['tanka'].value=GF_chara_kana(GF_chara_fasci($f_form['tanka'].value));
	var f_price	=$f_form['tanka'].value;
	if(!f_price){
		alert("卸価格（単価）を入力してください");
		$f_form['tanka'].focus();
		return false;
	}else if(isNaN(f_price) || f_price.indexOf('.')>-1){
		alert("卸価格（単価）は数字のみ入力してください");
		$f_form['tanka'].focus();
		return false;
	}else if(f_price < 1){
		alert("卸価格（単価）は1以上の数字のみ入力してください");
		$f_form['tanka'].focus();
		return false;
	}

	var f_unit =$f_form['tani1'].value,
		// f_unit2	=$f_form['tani2'].value=GF_chara_kana($f_form['tani2'].value),
		// f_unit3	=$f_form['tani3'].value=GF_chara_kana($f_form['tani3'].value);
		f_unit2	=$f_form['tani2'].value,
		f_unit3	=$f_form['tani3'].value;

	if(!f_unit){
		alert("卸価格（単価）に対する単位を選択してください");
		$f_form['tani1'].focus();
		return false;
	}else{
		if(f_unit2.length>10){
			alert("単位の数値は10文字以内で入力してください");
			$f_form['tani2'].focus();
			return false;
		}
		if(f_unit3.length>10){
			alert("単位の形態は10文字以内で入力してください");
			$f_form['tani3'].focus();
			return false;
		}
	}

	var f_teikan=false;
		//f_teikan_point='';
	for(i=0;i<$f_form['teikan'].length;i++){
		if($f_form['teikan'][i].checked){
			//f_teikan_point=$f_form['teikan'][i].value;
			f_teikan=true;
			break;
		}
	}
	if(!f_teikan){
		alert("定貫を選択してください");
		$('#teikan').focus();
		return false;
	};

	// var f_lot = $f_form['lot'].value=F_chikan(GF_chara_kana($f_form['lot'].value),' ','　');
	var f_lot = $f_form['lot'].value=F_chikan(($f_form['lot'].value),' ','　');
	if(!f_lot){
			alert("受注最小ロットを入力してください");
			$f_form['lot'].focus();
			return false;
	};

	// var f_lotkingaku=$f_form['lotkingaku'].value=GF_chara_kana(GF_chara_fasci($f_form['lotkingaku'].value));
	var f_lotkingaku=$f_form['lotkingaku'].value;
	if(!f_lotkingaku){
		alert("受注最小ロットの合計金額を入力してください");
		$f_form['lotkingaku'].focus();
		return false;
	}else if(isNaN(f_lotkingaku) || f_lotkingaku.indexOf('.')>-1){
		alert("受注最小ロットの合計金額は数字のみ入力してください");
		$f_form['lotkingaku'].focus();
		return false;
	}else if (f_lotkingaku < 1) {
		alert("受注最小ロットの合計金額は1以上の数字のみ入力してください");
		$f_form['lotkingaku'].focus();
		return false;
	}

	// var f_area=$f_form['sanchi'].value=GF_chara_kana($f_form['sanchi'].value),
	// 	f_area2=$f_form['kakouchi'].value=GF_chara_kana($f_form['kakouchi'].value);
	var f_area=$f_form['sanchi'].value,
		f_area2=$f_form['kakouchi'].value;
	if(!f_area){
		alert("生(原)産地を入力してください");
		$f_form['sanchi'].focus();
		return false;
	}else if(!f_area2){
		alert("加工地を入力してください");
		$f_form['kakouchi'].focus();
		return false;
	};

	// var f_formtex=$f_form['keitai'].value=GF_chara_kana($f_form['keitai'].value);
	var f_formtex=$f_form['keitai'].value;
	if(!f_formtex){
		alert("形態を入力してください");
		$f_form['keitai'].focus();
		return false;
	};

	//栄養成分表示
	if(cate.value == 9){
		$err_mess='';

		$c_energy=$f_form['c_energy'].value;
		$c_suibun=$f_form['c_suibun'].value;
		$c_tanpaku=$f_form['c_tanpaku'].value;
		$c_shishitsu=$f_form['c_shishitsu'].value;
		$c_tansui=$f_form['c_tansui'].value;
		$c_kaibun=$f_form['c_kaibun'].value;

		$c_na=$f_form['c_na'].value;
		$c_k=$f_form['c_k'].value;
		$c_ca=$f_form['c_ca'].value;
		$c_mg=$f_form['c_mg'].value;
		$c_p=$f_form['c_p'].value;
		$c_fe=$f_form['c_fe'].value;
		$c_zn=$f_form['c_zn'].value;

		$c_lechi=$f_form['c_lechi'].value;
		$c_kalo=$f_form['c_kalo'].value;
		$c_b1=$f_form['c_b1'].value;
		$c_b2=$f_form['c_b2'].value;
		$c_c=$f_form['c_c'].value;

		$c_seni=$f_form['c_seni'].value;
		$c_shokuen=$f_form['c_shokuen'].value;
		// $c_energy=$f_form['c_energy'].value=GF_chara_fasci($f_form['c_energy'].value);
		// $c_suibun=$f_form['c_suibun'].value=GF_chara_fasci($f_form['c_suibun'].value);
		// $c_tanpaku=$f_form['c_tanpaku'].value=GF_chara_fasci($f_form['c_tanpaku'].value);
		// $c_shishitsu=$f_form['c_shishitsu'].value=GF_chara_fasci($f_form['c_shishitsu'].value);
		// $c_tansui=$f_form['c_tansui'].value=GF_chara_fasci($f_form['c_tansui'].value);
		// $c_kaibun=$f_form['c_kaibun'].value=GF_chara_fasci($f_form['c_kaibun'].value);

		// $c_na=$f_form['c_na'].value=GF_chara_fasci($f_form['c_na'].value);
		// $c_k=$f_form['c_k'].value=GF_chara_fasci($f_form['c_k'].value);
		// $c_ca=$f_form['c_ca'].value=GF_chara_fasci($f_form['c_ca'].value);
		// $c_mg=$f_form['c_mg'].value=GF_chara_fasci($f_form['c_mg'].value);
		// $c_p=$f_form['c_p'].value=GF_chara_fasci($f_form['c_p'].value);
		// $c_fe=$f_form['c_fe'].value=GF_chara_fasci($f_form['c_fe'].value);
		// $c_zn=$f_form['c_zn'].value=GF_chara_fasci($f_form['c_zn'].value);

		// $c_lechi=$f_form['c_lechi'].value=GF_chara_fasci($f_form['c_lechi'].value);
		// $c_kalo=$f_form['c_kalo'].value=GF_chara_fasci($f_form['c_kalo'].value);
		// $c_b1=$f_form['c_b1'].value=GF_chara_fasci($f_form['c_b1'].value);
		// $c_b2=$f_form['c_b2'].value=GF_chara_fasci($f_form['c_b2'].value);
		// $c_c=$f_form['c_c'].value=GF_chara_fasci($f_form['c_c'].value);

		// $c_seni=$f_form['c_seni'].value=GF_chara_fasci($f_form['c_seni'].value);
		// $c_shokuen=$f_form['c_shokuen'].value=GF_chara_fasci($f_form['c_shokuen'].value);

		if($c_energy == '' || $c_tanpaku == '' || $c_shishitsu == '' || $c_tansui == ''){
			$err_mess+="栄養成分の必須項目を入力してください\r\n";
		}else{
			if(!F_check_seisu($c_energy)){$err_mess="エネルギーは整数で入力してください\r\n";}
			if($c_na != '' && !F_check_seisu($c_na)){$err_mess+="Naは整数で入力してください\r\n";}
			if($c_k != '' && !F_check_seisu($c_k)){$err_mess+="Kは整数で入力してください\r\n";}
			if($c_ca != '' && !F_check_seisu($c_ca)){$err_mess+="Caは整数で入力してください\r\n";}
			if($c_mg != '' && !F_check_seisu($c_mg)){$err_mess+="Mgは整数で入力してください\r\n";}
			if($c_p != '' && !F_check_seisu($c_p)){$err_mess+="Pは整数で入力してください\r\n";}
			if($c_lechi != '' && !F_check_seisu($c_lechi)){$err_mess+="レチノールは整数で入力してください\r\n";}
			if($c_kalo != '' && !F_check_seisu($c_kalo)){$err_mess+="カロテンは整数で入力してください\r\n";}
			if($c_c != '' && !F_check_seisu($c_c)){$err_mess+="Cは整数で入力してください\r\n";}

			if($c_suibun != '' && !F_check_keta($c_suibun, 1)){$err_mess+="水分は小数点第1位迄入力してください\r\n";}
			if($c_tanpaku != '' && !F_check_keta($c_tanpaku, 1)){$err_mess+="蛋質白は小数点第1位迄入力してください\r\n";}
			if($c_shishitsu != '' && !F_check_keta($c_shishitsu, 1)){$err_mess+="脂質は小数点第1位迄入力してください\r\n";}
			if($c_tansui != '' && !F_check_keta($c_tansui, 1)){$err_mess+="炭水化物は小数点第1位迄入力してください\r\n";}
			if($c_kaibun != '' && !F_check_keta($c_kaibun, 1)){$err_mess+="灰分は小数点第1位迄入力してください\r\n";}
			if($c_fe != '' && !F_check_keta($c_fe, 1)){$err_mess+="Feは小数点第1位迄入力してください\r\n";}
			if($c_zn != '' && !F_check_keta($c_zn, 1)){$err_mess+="Znは小数点第1位迄入力してください\r\n";}
			if($c_seni != '' && !F_check_keta($c_seni, 1)){$err_mess+="食物繊維は小数点第1位迄入力してください\r\n";}
			if($c_shokuen != '' && !F_check_keta($c_shokuen, 1)){$err_mess+="食塩相当量は小数点第1位迄入力してください\r\n";}
			
			if($c_b1 != '' && !F_check_keta($c_b1, 2)){$err_mess+="B1は小数点第2位迄入力してください\r\n";}
			if($c_b2 != '' && !F_check_keta($c_b2, 2)){$err_mess+="B2は小数点第2位迄入力してください\r\n";}
		}

		if($err_mess){
			alert($err_mess);
			return false;
		}
	}




	// var f_pack=$f_form['nisugata'].value=GF_chara_kana($f_form['nisugata'].value);
	var f_pack=$f_form['nisugata'].value;
	if(!f_pack){
		alert("荷姿を入力してください");
		$f_form['nisugata'].focus();
		return false;
	};

	// var f_lot_weight=$f_form['m_lot_weight'].value=GF_chara_kana($f_form['m_lot_weight'].value),
	var f_lot_weight=$f_form['m_lot_weight'].value,
		// f_size=$f_form['size'].value=GF_chara_kana($f_form['size'].value);
		f_size=$f_form['size'].value;
	if(!f_lot_weight || f_lot_weight==0){
		alert("サイズの「約***kg」を入力確認してください");
		$f_form['m_lot_weight'].focus();
		return false;
	};
	if(!isDecimal(f_lot_weight)){
		alert("サイズの「約***kg」を半角数字で入力してください。");
		$f_form['m_lot_weight'].focus();
		return false;
	}
	if(!f_size){
		alert("サイズを入力してください");
		$f_form['size'].focus();
		return false;
	};

	

	var f_hozon=$f_form['hozon'].value,
		f_safe=$f_form['kigen'].value,
		f_kaitou=$f_form['kaitou'].value;
		
	
	if(!f_hozon){
		alert("保存方法を選択してください");
		$f_form['hozon'].focus();
		return false;
	}else if(f_hozon=='冷凍' && f_kaitou==''){
		alert("解凍方法を入力してください");
		$f_form['kaitou'].focus();
		return false;
	}
	
	if(!f_safe){
		alert("賞味期限を入力してください");
		$f_form['kigen'].focus();
		return false;
	}else{
		f_safe=F_chikan(f_safe,' ','');
		f_safe=F_chikan(f_safe,'　','');
		if(f_safe.length<3){
			alert("賞味期限は3文字以上入力してください");
			$f_form['kigen'].focus();
			return false;
		}
	}

	// var f_limit=$f_form['nouki'].value=GF_chara_kana($f_form['nouki'].value);
	var f_limit=$f_form['nouki'].value;
	if(!f_limit){
		alert("納期を入力してください");
		$f_form['nouki'].focus();
		return false;
	};

	// var f_send=$f_form['souryou'].value=GF_chara_kana($f_form['souryou'].value),
		// f_result=$f_form['jisseki'].value=GF_chara_kana($f_form['jisseki'].value);

	// var f_menu=$f_form['menu'].value=GF_chara_kana($f_form['menu'].value);
	var f_menu=$f_form['menu'].value;
	if(!f_menu){
		alert("メニューを入力してください");
		$f_form['menu'].focus();
		return false;
	};

	// var f_note=$f_form['bikou'].value=GF_chara_kana($f_form['bikou'].value);

	// var f_genzai=$f_form['zairyo'].value=GF_chara_kana($f_form['zairyo'].value);
	var f_genzai=$f_form['zairyo'].value;
	if(!f_genzai){
		alert("原材料、食品添加物を入力してください");
		$f_form['zairyo'].focus();
		return false;
	};

	// var f_exex=$f_form['setsumei'].value=GF_chara_kana($f_form['setsumei'].value);
	var f_exex=$f_form['setsumei'].value;
	if(!f_exex){
		alert("詳しい商品説明を入力してください");
		$f_form['setsumei'].focus();
		return false;
	};

	// var f_catch=$f_form['pic4_catch_copy'].value = GF_chara_kana($f_form['pic4_catch_copy'].value);
	var f_catch=$f_form['pic4_catch_copy'].value;
	if(getByteCount(f_catch)>46){
		alert("キャッチコピーは23文字以内で入力してください。");
		$f_form['pic4_catch_copy'].focus();
		return false;
	}

	// var f_catch2=$f_form['pic5_catch_copy'].value = GF_chara_kana($f_form['pic5_catch_copy'].value);
	var f_catch2=$f_form['pic5_catch_copy'].value;
	if(getByteCount(f_catch2)>46){
		alert("キャッチコピーは23文字以内で入力してください。");
		$f_form['pic5_catch_copy'].focus();
		return false;
	}



	//'水産市場','農産市場','生鮮(チルド)市場'だけ実行する
	if(cate.value == "2" || cate.value == "3" || cate.value == "4"){    
		var m_disp_limit_y	=$f_form['m_disp_limit_y'].value=($f_form['m_disp_limit_y'].value),
			m_disp_limit_m	=$f_form['m_disp_limit_m'].value=($f_form['m_disp_limit_m'].value),
			m_disp_limit_d	=$f_form['m_disp_limit_d'].value=($f_form['m_disp_limit_d'].value),
			m_disp_limit_h	=$f_form['m_disp_limit_h'].value=($f_form['m_disp_limit_h'].value);
		// var m_disp_limit_y	=$f_form['m_disp_limit_y'].value=GF_chara_fasci($f_form['m_disp_limit_y'].value),
		// 	m_disp_limit_m	=$f_form['m_disp_limit_m'].value=GF_chara_fasci($f_form['m_disp_limit_m'].value),
		// 	m_disp_limit_d	=$f_form['m_disp_limit_d'].value=GF_chara_fasci($f_form['m_disp_limit_d'].value),
		// 	m_disp_limit_h	=$f_form['m_disp_limit_h'].value=GF_chara_fasci($f_form['m_disp_limit_h'].value);
			
		if(m_disp_limit_y || m_disp_limit_m || m_disp_limit_d || m_disp_limit_h){
			err_tx = '';
			if(!m_disp_limit_y){err_tx="掲載期限(年)を入力してください\r\n"}
			else if(!m_disp_limit_m){err_tx="掲載期限(月)を入力してください\r\n"}
			else if(!m_disp_limit_d){err_tx="掲載期限(日)を入力してください\r\n"}
			else if(!m_disp_limit_h){err_tx="掲載期限(時)を入力してください\r\n"};
			if(err_tx !=''){
				alert(err_tx);
				return false;
			}
		}
	}
	// 在庫設定
	var zaiko_disp_flg = $f_form['zaiko_disp_flg'].checked,
		total_weight = $f_form['total_weight'].value,
		lot_weight_hidden = $f_form['lot_weight_hidden'].value;
		zaiko = $f_form['zaiko'].value;

	if(zaiko_disp_flg == true){
		$f_form['m_zaiko_disp_flg'].value = 1;
		if(!total_weight){
			alert("総重量を入力してください");
			$f_form['total_weight'].focus();
			return false;
		}
		if(!lot_weight_hidden){
			alert("サイズの数量を入力してください");
			$f_form['m_lot_weight'].focus();
			return false;
		}
		if(!zaiko){
			alert("在庫数を入力してください");
			$f_form['zaiko'].focus();
			return false;
		}
	}else{
		$f_form['m_zaiko_disp_flg'].value = 0;
	}

	// 送料設定
	var select_soryo_table = $f_form['select_soryo_table'].value;
	if(!select_soryo_table){
		alert('送料を設定してください');
		$('#select_soryo_table').focus();
		return false;
	}
	
	// 休業日 ヴァリデーション
	var select_holiday_table = $f_form['select_holiday_table'].value;
	if(!select_holiday_table){
		alert('休業日を設定してください');
		$('#select_holiday_table').focus();
		return false;
	}
	// end 休業日 ヴァリデーション

	$t_pic=$f_form['new_pic'].value;
	if($('#new_pic').attr('value') != '' && $t_pic == ""){
		$t_pic = $('#new_pic').attr('value');
	}
	if($t_pic==''){
		$f_form['new_pic'].focus();
		alert('画像ファイルを選択してください');
		return true;
	}else{
		var p_type = $f_form['p_type'].value;

		var request = $.ajax({
			method : "POST", 
			url : BASE_AJAX_URL,
			data : {p_kind : 'item_register_check', item : f_item, p_type},
		});
		request.done(function(response) {
			if(response == "NAME_ERROR"){
				alert('既に同名のカテゴリが登録されています。');
				$f_form['item'].focus();
				return false;
			}else if(response == "REGISTER_OK"){
				$f_form['p_kind'].value=$f_setkind;		
				$f_form.submit();
				return false;
			}
		})
	}
}

	
	
function F_check_next(f_form) {
	let order_quantity = f_form['order_quantity'].value.trim();		// 入力数
	let stock = f_form['stock'].value.trim();		// 在庫数
	let err_tex	= '';

	// 入力チェック
	if(!order_quantity.match(/.*[^0-9０-９].*/)){
		order_quantity = order_quantity.replace(/[０-９]/g,
			function( match_num ) {
				return String.fromCharCode( match_num.charCodeAt(0) - 0xFEE0 );
			}
		);
		f_form['order_quantity'].value = order_quantity
	}

	if (order_quantity == '' || order_quantity <= 0 || order_quantity == "０") {
		err_tex = "ご注文数量は1以上で入力してください\n";
	}else if (order_quantity.match(/[^0-9]/g) || parseInt(order_quantity, 10) + "" != order_quantity){
		err_tex += "ご注文数量は半角数字で入力してください\n";
	}else if(parseInt(order_quantity) > parseInt(stock)){
		err_tex += "ご注文数量は"+stock+"ロットまでに入力してください\n";
	}

	if(typeof f_form['color'] !== 'undefined'){
		console.log("ok", typeof f_form['color']);
		let color_select = f_form['color'].value;
		if(!color_select){
			err_tex += "カラー表を選択してください。\n";
		}
	}

	if(typeof f_form['hyou'] !== 'undefined'){
		let size_select = f_form['hyou'].value;
		if(!size_select){
			err_tex += "サイズ表を選択してください。";
		}
	}

	if (err_tex) {
		alert(err_tex);
	} else {
		f_form.submit();
	}
}
function message(pas) {
	var url = 'https://www.bnet.gr.jp/kitchen/'+pas+'/data.dat'
	url = url.replace('../kitchen','https://www.bnet.gr.jp/kitchen')
	url = url.replace('..','https://www.bnet.gr.jp/kitchen')
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		url: "/rep/item/seller_info",
		type: "POST",
		data: { param : url  },
		success: function(data) {
			$( "#message" ).html(data);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
		}
	})
}

// $('input[name=order_quantity]').keyup(function() {
//     $("input[name=order_quantity]").val(this.value.match(/[0-9]*/));
// });

$(function(){
	$(document).on('click',".featherlight-close", function(){
		location.reload();
	});

	// カラー対応
	$("input[name='color_radio']").change(function(){
		let val = $(this).val();
		$("select[name='color']").val(val);
		$("#hidden_color").val(val);
	})

	$("select[name='color']").change(function(){
		let val = $(this).val();
		$('input:radio[name="color_radio"][value="' + val+ '"]').prop('checked', true);
		$("#hidden_color").val(val);
	});

	// サイズ対応
	$("input[name='size']").change(function(){
		let val = $(this).val();
		$("select[name='hyou']").val(val);
		$("#hidden_hyou").val(val);
	})

	$("select[name='hyou']").change(function(){
		let val = $(this).val();
		$('input:radio[name="size"][value="' + val+ '"]').prop('checked', true);
		$("#hidden_hyou").val(val);
	});
})

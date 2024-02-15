
var $G_picuplimit = 4000000;		//アップ画像ファイル許可最大サイズ4Mb
var $G_picUpWidthLimit =  2000;		//PDF画像ファイル許可最大サイズ300KB
var $G_err_txt = new Array(
	'送料無料',
	'大口',
)
$(function(){
	$('#flesh').click(function(){
		if($(this).prop('checked') === true){
			// $('.kigen_disp').prop('disabled', true)

			$('#shoumi_kigen').val('20/00/00');
			$('#shoumi_kigen').prop('disabled', true)
		}else{
			// $('.kigen_disp').prop('disabled', false)

			$('#shoumi_kigen').val('');
			$('#shoumi_kigen').prop('disabled', false)
		}
	})
});

//　カテゴリー選択確認
function f_check_out_cate($f_form){

	
	$cate = $f_form['r_cate1'];
	if (parseInt($cate.value)<=0) {
		alert("第一カテゴリを選択してください。");
		$cate.focus();
		return false;
	}

	$f_form['r_cate1_text'].value = $('#r_cate1 :selected').text();

	// 第二カテゴリ確認
	if ($f_form['r_cate2_'+$cate.value]) {
		$cate2 = $f_form['r_cate2_'+$cate.value];
		if (!$cate2.value || parseInt($cate2.value)<=0) {
			alert("第二カテゴリを選択してください。");
			$cate2.focus();
			return false;
		}
		$f_form['r_cate2'].value=$cate2.value;

		$f_form['r_cate2_text'].value = $(`#r_cate2_${$cate.value} :selected`).text();

		// 第三カテゴリ確認
		if($f_form['r_cate3_'+$cate2.value+'_'+$cate.value]){
			$cate3 = $f_form['r_cate3_'+$cate2.value+'_'+$cate.value];
			if ( !$cate3.value || parseInt($cate3.value)<=0) {
				alert("第三カテゴリを選択してください。");
				$cate3.focus();
				return false;
			}else{
				$f_form['r_cate3'].value=$cate3.value;

				$f_form['r_cate3_text'].value = $(`#r_cate3_${$cate2.value}_${$cate.value} :selected`).text();
				
				// 第四カテゴリ確認
				if($f_form['r_cate4_'+$cate3.value+'_'+$cate2.value+'_'+$cate.value]){
					$cate4 = $f_form['r_cate4_'+$cate3.value+'_'+$cate2.value+'_'+$cate.value];
					if (!$cate4.value || parseInt($cate4.value)<=0) {
						alert("第四カテゴリを選択してください。");
						$cate4.focus();
						return false;
					}else{
						$f_form['r_cate4'].value=$cate4.value;

						$f_form['r_cate4_text'].value = $(`#r_cate4_${$cate3.value}_${$cate2.value}_${$cate.value} :selected`).text();

					}
				}
			}
		}
	}
}


//-----------------------------------------------
//第一カテゴリ選択値に紐付く第二カテゴリを表示
//-----------------------------------------------
function r_ddl_disp($f_form,$f_serial){
	$('#cate2_span').hide();
	$('#cate3_span').hide();
	$('#cate4_span').hide();
	if(parseInt($f_serial)>0 && typeof($('#r_cate2_'+$f_serial).html())!='undefined'){
		$('#cate2_span').show();
		$('.r_cate2_ddl').hide();
		// $('#r_cate2_'+$f_serial).val(<?php echo $r_cate2;?>);
		$('#r_cate2_'+$f_serial).show();
	}
	f_displimit($f_form, $f_serial);
}

//第二カテゴリ選択値に紐付く第三カテゴリを表示
//-----------------------------------------------
function r_ddl_disp2($f_form ,$f_serial2, $f_serial1, $f_ctype){

	$('#cate3_span').hide();
	$('#cate4_span').hide();
	if(parseInt($f_serial2)>0 && typeof($('#r_cate3_'+$f_serial2+'_'+$f_serial1).html())!='undefined'){
		$('#cate3_span').show();
		$('.r_cate3_ddl').hide();
		// $('#r_cate3_'+$f_serial2+'_'+$f_serial1).val(<?php echo $r_cate3;?>);
		$('#r_cate3_'+$f_serial2+'_'+$f_serial1).show();
	}
	f_displimit($f_form, $f_serial1, $f_serial2);
}

//第三カテゴリ選択値に紐付く第四カテゴリを表示
//-----------------------------------------------
function r_ddl_disp3($f_form ,$f_serial3 ,$f_serial2 ,$f_serial1, $f_ctype){
	
	$('#cate4_span').hide();
	if(parseInt($f_serial3)>0 && typeof($('#r_cate4_'+$f_serial3+'_'+$f_serial2+'_'+$f_serial1).html())!='undefined'){
		$('#cate4_span').show();
		$('.r_cate4_ddl').hide();
		// $('#r_cate4_'+$f_serial3+'_'+$f_serial2+'_'+$f_serial1).val(<?php echo $r_cate4;?>);
		$('#r_cate4_'+$f_serial3+'_'+$f_serial2+'_'+$f_serial1).show();
	}
	f_displimit($f_form, $f_serial1, $f_serial2, $f_serial3);
}
/**
 * エラー表示
 * @returns 
 */
function show_err($txt, $name) {
	alert($txt);
	$('#'+$name).focus();
}

/**
 * ラプターカテゴリ選択時に掲載期限表示制御
 *
 * @return void
 */
function f_displimit(f_form, f_cate1, f_cate2, f_cate3){
	disp_flg=false;
	if( f_cate1 == 4 && f_cate2 == 2 ){
		disp_flg=true;
	}
	if( f_cate1 == 1 && f_cate2 == 4 ){
		disp_flg=true;
	}
	if( f_cate1 == 2 && f_cate2 == 1 ){
		disp_flg=true;
	}
	if( f_cate1 == 2 && f_cate2 == 1 ){
		disp_flg=true;
	}
	if( f_cate1 == 4 && f_cate2 == 1 && f_cate3 == 1 ){
		disp_flg=true;
	}
	if( f_cate1 == 4 && f_cate2 == 3 && (
			f_cate3 == 3 || f_cate3 == 4 || f_cate3 == 5 || f_cate3 == 6 || f_cate3 == 7 ||
			f_cate3 == 16 || f_cate3 == 17 || f_cate3 == 18 || f_cate3 == 19
		)
	){
		disp_flg=true;
	}
	if(disp_flg){
		$('#seisenhin').show();
		// f_form['seisenhin'].checked=false;
	}else{
		$('#seisenhin').hide();
	}
}
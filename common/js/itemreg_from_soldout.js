
var $G_picuplimit = 4000000;		//�A�b�v�摜�t�@�C�����ő�T�C�Y4Mb
var $G_picUpWidthLimit =  2000;		//PDF�摜�t�@�C�����ő�T�C�Y300KB
var $G_err_txt = new Array(
	'��������',
	'���',
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

//�@�J�e�S���[�I���m�F
function f_check_out_cate($f_form){

	
	$cate = $f_form['r_cate1'];
	if (parseInt($cate.value)<=0) {
		alert("���J�e�S����I�����Ă��������B");
		$cate.focus();
		return false;
	}

	$f_form['r_cate1_text'].value = $('#r_cate1 :selected').text();

	// ���J�e�S���m�F
	if ($f_form['r_cate2_'+$cate.value]) {
		$cate2 = $f_form['r_cate2_'+$cate.value];
		if (!$cate2.value || parseInt($cate2.value)<=0) {
			alert("���J�e�S����I�����Ă��������B");
			$cate2.focus();
			return false;
		}
		$f_form['r_cate2'].value=$cate2.value;

		$f_form['r_cate2_text'].value = $(`#r_cate2_${$cate.value} :selected`).text();

		// ��O�J�e�S���m�F
		if($f_form['r_cate3_'+$cate2.value+'_'+$cate.value]){
			$cate3 = $f_form['r_cate3_'+$cate2.value+'_'+$cate.value];
			if ( !$cate3.value || parseInt($cate3.value)<=0) {
				alert("��O�J�e�S����I�����Ă��������B");
				$cate3.focus();
				return false;
			}else{
				$f_form['r_cate3'].value=$cate3.value;

				$f_form['r_cate3_text'].value = $(`#r_cate3_${$cate2.value}_${$cate.value} :selected`).text();
				
				// ��l�J�e�S���m�F
				if($f_form['r_cate4_'+$cate3.value+'_'+$cate2.value+'_'+$cate.value]){
					$cate4 = $f_form['r_cate4_'+$cate3.value+'_'+$cate2.value+'_'+$cate.value];
					if (!$cate4.value || parseInt($cate4.value)<=0) {
						alert("��l�J�e�S����I�����Ă��������B");
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
//���J�e�S���I��l�ɕR�t�����J�e�S����\��
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

//���J�e�S���I��l�ɕR�t����O�J�e�S����\��
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

//��O�J�e�S���I��l�ɕR�t����l�J�e�S����\��
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
 * �G���[�\��
 * @returns 
 */
function show_err($txt, $name) {
	alert($txt);
	$('#'+$name).focus();
}

/**
 * ���v�^�[�J�e�S���I�����Ɍf�ڊ����\������
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
function check_input(){
	f_form=document.input_table;
	
	f_coname=f_form.corp.value=GF_chara_kana(f_form.corp.value);
	f_gyoushu=f_form.biz.value=GF_chara_kana(f_form.biz.value);
	f_name=f_form.name.value=GF_chara_kana(f_form.name.value);
	f_shouhin=f_form.item.value=GF_chara_kana(f_form.item.value);
	f_tel=f_form.tel.value=GF_chara_fasci(GF_chara_kana(f_form.tel.value));
	f_fax=f_form.fax.value=GF_chara_fasci(GF_chara_kana(f_form.fax.value));
	f_postal1=f_form.an1.value=GF_chara_fasci(GF_chara_kana(f_form.an1.value));
	f_postal2=f_form.an2.value=GF_chara_fasci(GF_chara_kana(f_form.an2.value));
	f_postal_all='〒'+f_postal1+'-'+f_postal2;
	f_address=f_form.address.value=GF_chara_kana(f_form.address.value);
	f_mail=f_form.mail.value=GF_chara_fasci(f_form.mail.value);
	f_yotei_shouhin=f_form.ritem.value=GF_chara_kana(f_form.ritem.value);
	f_yotei_day=f_form.regday.value=GF_chara_kana(f_form.regday.value);

	err_tx='';
	if(!f_coname)err_tx+="御社名を入力してください\r\n";
	if(!f_gyoushu)err_tx+="業種を入力してください\r\n";
	if(!f_name)err_tx+="ご担当者名を入力してください\r\n";
	if(!f_shouhin)err_tx+="主商品を入力してください\r\n";
	if(!f_tel)err_tx+="電話番号を入力してください\r\n";
	if(!f_fax)err_tx+="FAX番号を入力してください\r\n";
	if(!f_postal1 || !f_postal2)err_tx+="郵便番号を入力してください\r\n";
	if(!f_address)err_tx+="住所を入力してください\r\n";
	if(!f_mail){
		err_tx+="メールアドレスを入力してください\r\n";
	}else if(!GF_mail_check(f_mail)){
		err_tx+="メールアドレスの構成が正しくありません\r\n";
	}
	if(f_know=='na')err_tx+="Mマートをお知りになった媒体を選択してください\r\n";
	if(!f_yotei_shouhin)err_tx+="初期出品予定商品を入力してください\r\n";
	if(!f_yotei_day)err_tx+="初期出品予定日を入力してください\r\n";
	
	if(err_tx){
		alert(err_tx);
	}else{
		f_form.an.value=f_postal_all;
		f_form.submit();
	}
}

function check_input2(){
	f_form=document.input_table;
	
	f_coname=f_form.corp.value=GF_chara_kana(f_form.corp.value);
	f_name=f_form.name.value=GF_chara_kana(f_form.name.value);
	f_shouhin=f_form.item.value=GF_chara_kana(f_form.item.value);
	f_tel=f_form.tel.value=GF_chara_fasci(GF_chara_kana(f_form.tel.value));
	f_postal1=f_form.zip1.value=GF_chara_fasci(GF_chara_kana(f_form.zip1.value));
	f_postal2=f_form.zip2.value=GF_chara_fasci(GF_chara_kana(f_form.zip2.value));
	f_postal_all='〒'+f_postal1+'-'+f_postal2;
	f_address=f_form.address.value=GF_chara_kana(f_form.address.value);
	f_mail=f_form.mail.value=GF_chara_fasci(f_form.mail.value);
	f_listed=f_form.listed.value;
	f_capital=f_form.capital.value;
	f_annual_sales=f_form.annual_sales.value;

	err_tx='';
	if(!f_coname)err_tx+="御社名を入力してください\r\n";
	if(!f_name)err_tx+="ご担当者名を入力してください\r\n";
	if(!f_shouhin)err_tx+="主商品を入力してください\r\n";
	if(!f_tel)err_tx+="電話番号を入力してください\r\n";
	if(!f_postal1 || !f_postal2)err_tx+="郵便番号を入力してください\r\n";
	if(!f_address)err_tx+="住所を入力してください\r\n";
	if(!f_listed)err_tx+="上場を選択てください\r\n";
	if(!f_capital)err_tx+="資本金を入力してください\r\n";
	if(!f_annual_sales)err_tx+="年商を入力してください\r\n";
	if(!f_mail){
		err_tx+="メールアドレスを入力してください\r\n";
	}else if(!GF_mail_check(f_mail)){
		err_tx+="メールアドレスの構成が正しくありません\r\n";
	}
	
	if(err_tx){
		alert(err_tx);
		// f_form.submit();
	}
	else{
		f_form.submit();
	}
}

function chara_kana(check_tex){
	var str = check_tex;
		//検索文字列を変換するための変換文字列配列
	var Kana1 = new Array("㈱","㈲","ｶﾞ","ｷﾞ","ｸﾞ","ｹﾞ","ｺﾞ","ｻﾞ","ｼﾞ","ｽﾞ","ｾﾞ","ｿﾞ","ﾀﾞ","ﾁﾞ",
		"ﾂﾞ","ﾃﾞ","ﾄﾞ","ﾊﾞ","ﾋﾞ","ﾌﾞ","ﾍﾞ","ﾎﾞ","ﾊﾟ","ﾋﾟ","ﾌﾟ","ﾍﾟ","ﾎﾟ","ｦ","ｧ",
		"ｨ","ｩ","ｪ","ｫ","ｬ","ｭ","ｮ","ｯ","ｰ","ｱ","ｲ","ｳ","ｴ","ｵ","ｶ","ｷ","ｸ","ｹ",
		"ｺ","ｻ","ｼ","ｽ","ｾ","ｿ","ﾀ","ﾁ","ﾂ","ﾃ","ﾄ","ﾅ","ﾆ","ﾇ","ﾈ","ﾉ","ﾊ","ﾋ",
		"ﾌ","ﾍ","ﾎ","ﾏ","ﾐ","ﾑ","ﾒ","ﾓ","ﾔ","ﾕ","ﾖ","ﾗ","ﾘ","ﾙ","ﾚ","ﾛ","ﾜ","ﾝ");
	var Kana2 = new Array("(株)","(有)","ガ","ギ","グ","ゲ","ゴ","ザ","ジ","ズ","ゼ","ゾ","ダ","ヂ",
		"ヅ","デ","ド","バ","ビ","ブ","ベ","ボ","パ","ピ","プ","ペ","ポ","ヲ","ァ",
		"ィ","ゥ","ェ","ォ","ャ","ュ","ョ","ッ","ー","ア","イ","ウ","エ","オ","カ",
		"キ","ク","ケ","コ","サ","シ","ス","セ","ソ","タ","チ","ツ","テ","ト","ナ",
		"ニ","ヌ","ネ","ノ","ハ","ヒ","フ","ヘ","ホ","マ","ミ","ム","メ","モ","ヤ",
		"ユ","ヨ","ラ","リ","ル","レ","ロ","ワ","ン");
	while(str.match(/[ｦ-ﾝ㈱㈲]/)){
		for(var i = 0; i < Kana1.length; i++){
			str = str.replace(Kana1[i], Kana2[i]);  //文字列置換
		}
	}
	return str;
}

var fascii2ascii = (function(){	//英数半角化
  var cclass
   = '['+String.fromCharCode(0xff01)+'-'+String.fromCharCode(0xff5e)+']';
  var re_fullwidth = new RegExp(cclass, 'g');
  var substitution = function(m){
    return String.fromCharCode(m.charCodeAt(0) - 0xfee0); // 0xff00 - 0x20
  };
  return function(s){ return s.replace(re_fullwidth, substitution) };
})();
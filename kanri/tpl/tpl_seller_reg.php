<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/outlet/valeur/common/include/6_check.js" type="text/javascript"></script>
    <script src="../common/include/gf_chara_henkan.js" type="text/javascript"></script>
    <script type="text/javascript" src="../common/include/rollover.js?type=_on" charset="utf-8"></script>
    <script type="text/javascript" src="../common/include/ajaxzip3.js?<?php echo date('YmdHis')?>"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>バルル委託出店社申込</title>
<script type="text/javascript" language="javascript">
    $(document).ready(function(){
        $('#make_pass').on('click', function(){
            const pass_res = $('input[name="resign_pass"]');
            console.log(pass_res);
            const request = $.ajax({
            method: 'POST',
            url: "/outlet/valeur/kanri/function.php",
            data: {action_type: 'make_pass'},
            success: function(data){
                const pass = data.replace(/[_\W]+/g, "");
                pass_res.val(pass);
                return false;
            },
            error: function () {
                alert('エラーが起きました');
                return false;
            }
            })
        });

        // ID重複チェック
        $(document.body).on('blur', '#resign_id', function(){
          var id = $(this).val();
          if(id != ''){
            if( ( id.match(/^[\u30a0-\u30ff\u3040-\u309f\u3005-\u3006\u30e0-\u9fcf]+$/)) ){
                alert('・使用可能文字：半角英字（小文字）、半角数字、「_（半角アンダーバー）」#１');
                $('#resign_id').val('');
                return false;
            }
            if(id.match(/^[^\x01-\x7E\uFF61-\uFF9F]+$/)){
                alert('・使用可能文字：半角英字（小文字）、半角数字、「_（半角アンダーバー）」#２');
                $('#resign_id').val('');
                return false;
            }


            if (id.length > 20) {
                return false;
            }

            
            var firstChar = id.charAt(0);
            if (!/^[a-zA-Zａ-ｚＡ-Ｚ]$/.test(firstChar)) {
                return false;
            }

            
            for (var i = 1; i < id.length; i++) {
                var currentChar = id.charAt(i);
                
                if (!/^[a-z0-9_ａ-ｚ０-９＿]$/.test(currentChar)) {
                    alert('・使用可能文字：半角英字（小文字）、半角数字、「_（半角アンダーバー）」#３');
                    $('#resign_id').val('');
                    break;
                }
                if(currentChar.match(/^[\u30a0-\u30ff\u3040-\u309f\u3005-\u3006\u30e0-\u9fcf]+$/)){
                    alert('・使用可能文字：半角英字（小文字）、半角数字、「_（半角アンダーバー）」#４');
                    $('#resign_id').val('');
                    break;
                }

                if(currentChar.match(/^[^\x01-\x7E\uFF61-\uFF9F]+$/)){
                    alert('・使用可能文字：半角英字（小文字）、半角数字、「_（半角アンダーバー）」#５');
                    $('#resign_id').val('');
                    break;
                }
            }

          
            var lastChar = id.charAt(id.length - 1);
            if (lastChar === "_") {
                return false;
            }







            var request = $.ajax({
                type : 'POST',
                url: '/outlet/valeur/kanri/seller_reg.php',
                data: {p_kind: "id_reg_check", id}
            });
            request.done(function(res){
                var res_split = res.split(':r:');
                if(res_split[1] == 'OK'){
                
                }else if(res_split[1] == 'ERROR'){
                alert('この「ID」が登録出来ません。\n他に登録してください。');
                $('#resign_id').val('');
                $('#resign_id').focus();
                return false;
                }
            })
          }
         
        })
    });
    
</script>
<style type="text/css">

/*ここから追記 20140806saijo*/
.kyotu_tbl { border-collapse:collapse;}
.kyotu_tbl th , .kyotu_tbl td {
  border: 1px solid #ccc;
  padding: 6px 10px;
  font-size:14px;
}
.kyotu_tbl th {
  background-color: #f8f5ed;
  font-weight: normal;
  text-align: right;
  vertical-align: top;
  width: 180px;
}
.kyotu_tbl td {
  width:300px;
}
.entry {
  font-size:20px;
  font-weight:bold;
  margin:10px 0 0 0;
  padding: 0 0 0 8px;
  height:20px;
  line-height:20px;
  border-left: solid 5px #00F;
}
.btn_wrap {
  width:530px;
  text-align:center;
  padding:15px;
}
.btn_entry {
  padding:5px 7px;
}
.hissu {
  color:#f00;
}
.exp1 {
  font-size: 12px;
}
.wapper{
    padding: 10px;
    max-width: 1000px;
    margin: 0 auto;
}
.header{
    font-size: 18px;
    background-color: #a9a6ff;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 20px;
}
#input_table{
    background-color: #eef;
    padding: 10px;
    border-radius: 10px;
}
.row {
    margin-bottom: 5px !important;
}
.hilight{
    font-size: 13px;
    color: #ff7421;
}
</style>
</head>
<body>
<div class="wapper">
<header class="header">
    <h1>バルル委託出店社申込</h1>
</header>
<main>
<form name="input_table" id="input_table" method="POST" action="function.php">
    <input type="hidden" name="action_type" id="action_type" value="confirm">
    <div class="form-group row">
        <label for="resign_id" class="col-sm-3 col-form-label"><span class="hissu">*</span>ログインID：</label>
        <div class="col-sm-7">
        <input  type="text" class="form-control" maxlength="20" name="resign_id" id="resign_id" placeholder="ID" value="<?php echo($resign_id) ?>">
        <div class="hilight">・使用可能文字：半角英字（小文字）、半角数字、「_（半角アンダーバー）」</div>
        <div class="hilight">・書式：半角英字（小文字）で始まり、「_（半角アンダーバー）」以外で終わる</div>
        <div class="hilight">・文字数：20文字以下</div>
        </div>
    </div>
    <div class="form-group row">
        <label for="resign_pass" class="col-sm-3 col-form-label"><span class="hissu">*</span>パスワード：</label>
        <div class="col-sm-5">
        <input readonly type="text" class="form-control" name="resign_pass" id="resign_pass" value="<?php echo($resign_pass) ?>">
        <button type="button" class="btn btn-outline-success mt-1" id="make_pass">パスワード作成</button>
        
        </div>
    </div>
    <div class="form-group row">
        <label for="input_corp" class="col-sm-3 col-form-label"><span class="hissu">*</span>御社（店舗）名：</label>
        <div class="col-sm-5">
        <input required type="text" class="form-control" name="corp" id="input_corp" value="<?php echo($corp) ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="input_name" class="col-sm-3 col-form-label"><span class="hissu">*</span>ご担当者名：</label>
        <div class="col-sm-5">
        <input required class="form-control" id="input_name" name="name" value="<?php echo($name) ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="input_zip1" class="col-sm-3 col-form-label"><span class="hissu">*</span>郵便番号：</label>
        <div class="col-sm-5">
            <b>〒</b><input required type="text" name="zip1" size="6" id="input_zip1" maxlength="4" value="<?php echo($zip1) ?>">―<input required type="text" name="zip2" size="6" maxlength="4" onKeyUp="AjaxZip3.zip2addr('zip1','zip2','address','address');" value="<?php echo($zip2) ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="input_addr1" class="col-sm-3 col-form-label"><span class="hissu">*</span>所在地：</label>
        <div class="col-sm-5">
        <input required readonly class="form-control" name="address" id="input_addr1" value="<?php echo($address) ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="input_addr2" class="col-sm-3 col-form-label"><span class="hissu">*</span>所在地（番地　建物名）：</label>
        <div class="col-sm-5">
        <input required class="form-control" name="address_2" id="input_addr2" value="<?php echo($address_2) ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="input_tel" class="col-sm-3 col-form-label"><span class="hissu">*</span>電話番号：</label>
        <div class="col-sm-5">
        <input required class="form-control" name="tel" id="input_tel" maxlength="15" value="<?php echo($tel) ?>" oninput="value=value.replace(/[^0-9.]+/i,'');">
        </div>
    </div>
    <div class="form-group row">
        <label for="input_mail" class="col-sm-3 col-form-label"><span class="hissu">*</span>メールアドレス：</label>
        <div class="col-sm-5">
        <input required class="form-control" name="mail" id="input_mail" value="<?php echo($mail) ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="input_item" class="col-sm-3 col-form-label"><span class="hissu">*</span>主商品：</label>
        <div class="col-sm-5">
        <input required class="form-control" name="item" id="input_item" value="<?php echo($item) ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="input_listed" class="col-sm-3 col-form-label"><span class="hissu">*</span>上場：</label>
        <div class="col-sm-5">
            
            <label><input type="radio" id="input_listed" name="listed" <?php echo(($listed == 1)?"checked":"") ?> value="1">上場</label>
            <label><input type="radio" name="listed" value="0" <?php echo(($listed == 0)?"checked":"") ?>>非上場</label>
        </div>
    </div>
    <div class="form-group row">
        <label for="input_capital" class="col-sm-3 col-form-label"><span class="hissu">*</span>資本金：</label>
        <div class="col-sm-5">
        <div class="input-group">
        <input required class="form-control" maxlength="30" name="capital" id="input_capital" value="<?php echo($capital) ?>" oninput="value=value.replace(/[^0-9.]+/i,'');">
            <div class="input-group-append">
                <span class="input-group-text">円</span>
            </div>
        </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="input_annual_sales" class="col-sm-3 col-form-label"><span class="hissu">*</span>年商：</label>
        <div class="col-sm-5">
        <div class="input-group">
            <input required class="form-control" maxlength="30" name="annual_sales" id="input_annual_sales" value="<?php echo($annual_sales) ?>" oninput="value=value.replace(/[^0-9.]+/i,'');">
            <div class="input-group-append">
                <span class="input-group-text">円</span>
            </div>
        </div>
        </div>
    </div>
    <div style="text-align: center;">
    <input class="btn btn-primary" type="button" name="button" value="確認画面へ" onClick="check_input2();" />
    </div>
</form>

</main>
</div>
</body>
</html>
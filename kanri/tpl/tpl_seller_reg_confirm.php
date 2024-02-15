<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../common/include/6_check.js" type="text/javascript"></script>
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

    <title>出品社申込</title>
<script type="text/javascript" language="javascript">
    $(document).ready(function(){
        $('#make_pass').on('click', function(){
            const pass_res = $('input[name="resign_pass"]');
            // console.log(pass_res);
            const request = $.ajax({
            method: 'POST',
            url: "/outlet/valeur/kanri/function.php",
            data: {'action_type': 'make_pass'},
            success: function(data){
                const pass = data.replace(/[_\W]+/g, "");
                pass_res.val(pass);
            },
            error: function () {
                alert('エラーが起きました');
            }
            })

        });
        $('#submit_btn').on('click', function(){
            $('#input_table').attr('action', '/outlet/valeur/kanri/function.php');
            $('#input_table').submit();
        });
        $('#edit_btn').on('click', function(){
            $('#input_table').attr('action', '/outlet/valeur/kanri/seller_reg.php');
            $('#input_table').submit();
        });
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
</style>
</head>
<body>
<div class="wapper">
<header class="header">
    <h1>バルル出店者申込</h1>
</header>
<main>
<form action="" method="POST" id="input_table">
<input type="hidden" type="text" name="action_type" id="action_type" value="submit">
    <div class="form-group row">
        <label for="resign_id" class="col-sm-3 col-form-label">ログインID：</label>
        <div class="col-sm-5">
        <!-- <?php echo($data["resign_id"]??""); ?> -->
        <input readonly required type="text" class="form-control" maxlength="20" name="resign_id" id="resign_id" placeholder="ID" value="<?php echo($data["resign_id"]??""); ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="resign_pass" class="col-sm-3 col-form-label">パスワード：</label>
        <div class="col-sm-5">
        <input readonly type="text" class="form-control" name="resign_pass" id="resign_pass" placeholder="" value="<?php echo($data["resign_pass"]??""); ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="input_corp" class="col-sm-3 col-form-label">御社（店舗）名：</label>
        <div class="col-sm-5">
        <input readonly required type="text" class="form-control" name="corp" id="input_corp" placeholder="" value="<?php echo($data["corp"]??""); ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="input_name" class="col-sm-3 col-form-label">ご担当者名：</label>
        <div class="col-sm-5">
        <input readonly required class="form-control" id="input_name" name="name" placeholder="" value="<?php echo($data["name"]??""); ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="input_zip1" class="col-sm-3 col-form-label">郵便番号：</label>
        <div class="col-sm-5">
            <b>〒</b><input readonly required type="text" name="zip1" size="6" id="input_zip1" maxlength="4" value="<?php echo($data["zip1"]??""); ?>">―<input readonly required type="text" name="zip2" size="6" maxlength="4" onKeyUp="AjaxZip3.zip2addr('zip1','zip2','address','address');" value="<?php echo($data["zip2"]??""); ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="input_addr1" class="col-sm-3 col-form-label">所在地：</label>
        <div class="col-sm-5">
        <input required readonly class="form-control" name="address" id="input_addr1" placeholder="" value="<?php echo($data["address"]??""); ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="input_addr2" class="col-sm-3 col-form-label">所在地（番地　建物名）：</label>
        <div class="col-sm-5">
        <input readonly required class="form-control" name="address_2" id="input_addr2" placeholder="" value="<?php echo($data["address_2"]??""); ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="input_tel" class="col-sm-3 col-form-label">電話番号：</label>
        <div class="col-sm-5">
        <input readonly required class="form-control" name="tel" id="input_tel" maxlength="15" placeholder="" value="<?php echo($data["tel"]??""); ?>" oninput="value=value.replace(/[^0-9.]+/i,'');">
        </div>
    </div>
    <div class="form-group row">
        <label for="input_mail" class="col-sm-3 col-form-label">メールアドレス：</label>
        <div class="col-sm-5">
        <input readonly required class="form-control" name="mail" id="input_mail" placeholder="" value="<?php echo($data["mail"]??""); ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="input_item" class="col-sm-3 col-form-label">主商品：</label>
        <div class="col-sm-5">
        <input readonly required class="form-control" name="item" id="input_item" placeholder="" value="<?php echo($data["item"]??""); ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="input_listed" class="col-sm-3 col-form-label">上場：</label>
        <div class="col-sm-5">
            <label><input disabled type="radio" <?php echo(($data["listed"]==1)?"checked":"") ?> value="1">上場</label>
            <label><input disabled  type="radio" <?php echo(($data["listed"]==0)?"checked":"") ?>>非上場</label>
            <input type="hidden" name="listed" value="<?php echo($data["listed"]);?>" >
        </div>
    </div>
    <div class="form-group row">
        <label for="input_capital" class="col-sm-3 col-form-label">資本金：</label>
        <div class="col-sm-5">
        <div class="input-group">
        <input readonly required class="form-control" maxlength="30" name="capital" id="input_capital" placeholder="" value="<?php echo($data["capital"]??""); ?>" oninput="value=value.replace(/[^0-9.]+/i,'');">
            <div class="input-group-append">
                <span class="input-group-text">円</span>
            </div>
        </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="input_annual_sales" class="col-sm-3 col-form-label">年商：</label>
        <div class="col-sm-5">
        <div class="input-group">
            <input readonly required class="form-control" maxlength="30" name="annual_sales" id="input_annual_sales" placeholder="" value="<?php echo($data["annual_sales"]??""); ?>" oninput="value=value.replace(/[^0-9.]+/i,'');">
            <div class="input-group-append">
                <span class="input-group-text">円</span>
            </div>
        </div>
        </div>
    </div>

    <div style="text-align: center;margin-top: 15px;">
    <input class="btn btn-primary" type="button" id="edit_btn" value="修正する" />
    <input class="btn btn-primary" type="button" id="submit_btn" value="申し込みする" />
    </div>
</form>
</main>
</div>
</body>
</html>
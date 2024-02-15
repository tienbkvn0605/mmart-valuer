<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
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

<title>バルル商品管理一覧</title>
<script type="text/javascript" language="javascript">
    $(document).ready(function(){
        // $('#seller_all_tbl').DataTable({
        //     "orderClasses": false,
        //     "processing": true,
        //     "stateSave": false,
        //     "lengthChange": true,
        //     "searching": true,
        //     "ordering": true,
        //     "info": true,
        //     "paging": true,
        //     "displayLength": 50,
        //     "language": {
        //         "lengthMenu": '表示件数：<select>'+
        //         '<option value="10">10</option>'+
        //         '<option value="25">25</option>'+
        //         '<option value="50">50</option>'+
        //         '<option value="100">100</option>'+
        //         '<option value="-1">All</option>'+
        //         '</select>',
        //         "search": "検索： _INPUT_",
        //         "infoEmpty": "全 0 件の 0 ～ 0 件を表示",
        //         "info": "全 _TOTAL_ 件の _START_ ～ _END_ 件を表示",
        //         "paginate": {
        //             "previous": "前へ",
        //             "next": "次へ"
        //         },
        //         "emptyTable": "データがありません",
        //         "zeroRecords": "該当データがありません"
        //     }
        // });

        $('.resign').on('click', function(){
            var f_serial = $(this).data('serial');
            // console.log({f_serial});
            var seller_shop = $(this).data('company');

            var f_listed = $(this).closest("tr").find('input[name="listed_' + f_serial + '"]:checked').val();
            var f_capital = $(this).closest("tr").find('input[name="capital_' + f_serial +'"]').val();
            var f_annual_sales = $(this).closest("tr").find('input[name="annual_sales_' + f_serial +'"]').val();

            $("#exampleModalLongTitle").text("申し込み確認");
            $("#mess").text(seller_shop + "を申込しますか？");
            $("#submit_btn").text("申込する");
            
            $('#submit_btn').click(function(){
                // console.log(f_serial,f_listed,f_capital,f_annual_sales);
                const request = $.ajax({
                method: 'POST',
                url: "<?php echo $_SERVER['PHP_SELF']?>",
                data: {'edit_type': 'resign',
                    'f_serial':f_serial,
                    'f_listed':f_listed, 
                    'f_capital':f_capital, 
                    'f_annual_sales':f_annual_sales}
                })
                request.done((response) =>{
                alert("申込が完了しました。");
                location.reload();
                });
            });
        });
    });
</script>

<style type="text/css">
body{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    margin-bottom: 50px;
}
.table-bordered  {
    border: 1px solid black;
}
.table>thead.top {
    background-color: dimgrey;
    color: #fff;
}
.table.top td {
    vertical-align: middle;
}
.btn-group {
    display: flex;
    justify-content: space-around;
}
.btn-group .btn:first-child {
    margin-right: 8px;
}
.btn-group .btn {
    border-radius: 5px !important;
}
#error_message {
    margin: 10px auto 0px;
}
.form-group{
    margin-bottom: 0 !important;
}
.btn-group button {
    width: 100%;
    height: 40px;
    font-size: 18px;
}
table thead tr th{
    vertical-align: middle !important;
    text-align: center !important;
}
.text-primary-emphasis{
    color: #0a58ca !important;
}
#check_tbl tbody tr:hover tr{
    background-color: #DADADA !important;
}
.top-section{
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.pagetop {
    height: 50px;
    width: 50px;
    position: fixed;
    right: 30px;
    bottom: 30px;
    background: #fff;
    opacity: 0.85;
    border: solid 2px #000;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 2;
}
.pagetop__arrow {
    height: 10px;
    width: 10px;
    border-top: 3px solid #000;
    border-right: 3px solid #000;
    transform: translateY(20%) rotate(-45deg);
}
#topbutton{
    display: none;
}
</style>
</head>
<body>
<div class="container-fluid my-2 px-5">
<div class="pt-3">
    <div style="font-size: 18px;font-size: 18px;background-color: #a9a6ff;padding: 10px;border-radius: 8px;
">ログイン： <span class="badge bg-secondary" style="font-size: 18px;"><?php echo($login_staff??"未ログイン"); ?></span></div>
</div>
<h3 class="mt-5">■即売出品社一覧</h3>
<p>＊申込した会社は修正出来ません。</p>
<main>
<section class="top-section">
<div class="pagination mb-3">
    <?php 
        if ($current_page > 1 && $total_page > 1){
            echo '<a class="page-link" href="/outlet/valeur/kanri/seller_list_all.php?page='.($current_page-1).'">前</a>';
        }
        for ($i = 1; $i <= $total_page; $i++){
            if ($i == $current_page){
                echo '<span class="page-link" style="background-color: #ffb24f;">'.$i.'</span>';
            }
            else{
                echo '<a class="page-link" href="/outlet/valeur/kanri/seller_list_all.php?page='.$i.'">'.$i.'</a>';
            }
        }
        if ($current_page < $total_page && $total_page > 1){
            echo '<a class="page-link" href="/outlet/valeur/kanri/seller_list_all.php?page='.($current_page+1).'">次</a>';
        }
    ?>
</div>
<form class="form-inline mb-3" method="post" action="/outlet/valeur/kanri/seller_list_all.php">
    <a href="/outlet/valeur/kanri/seller_list_all.php" class="btn btn-success my-2 mr-3">すべて表示</a>
    <input name="search_val" class="form-control mr-sm-2" type="search" placeholder="会社名" aria-label="Search" size="35">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">検索</button>
</form>
</section>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" target="_self">
    <table class="table table-hover table-bordered top" id="seller_all_tbl">
        <thead class="align-middle text-center top sticky-top">
            <tr>
                <th width="3%">No</th>
                <th>店舗名</th>
                <th width="15%">担当者名</th>
                <th width="11%">主商品</th>
                <th width="10%">上場</th>
                <th width="13%">資本金</th>
                <th width="13%">年商</th>
                <th width="8%">ボータン</th>
            </tr>
        </thead>
        <tbody>
        <?php $cnt = 0; foreach($A_seller as $k => $v): $cnt++; 
        ?>
        <?php
            $readonly = "";
            $pointer_event = "";
            if(isset($v["valeur_serial"])){
                $readonly = "readonly";
                $pointer_event = "style='pointer-events:none;'";
            } 
        ?>
        <tr>
            <!-- NO -->
            <td class="text-center"><?php echo($cnt); ?></td>
            <!-- 出品社名 -->
            <td><?php echo($v["out_coname"]); ?></td>
            <!-- 商品名 -->
            <td><?php echo($v["out_tantou"]); ?></td>
            <!-- 商品名 -->
            <td><?php echo(($v["out_item"])?$v["out_item"]:"未登録"); ?></td>
            <!-- 上場 -->
            <td>
            <div class="form-check">
                <label <?php echo($pointer_event); ?>><input type="radio" name="listed_<?php echo ($v["out_serial"]) ?>" value="1" <?php echo(($v["valeur_listed"] == 1)?'checked="checked"':"") ?>>上場</label>
                <label <?php echo($pointer_event); ?>><input type="radio" name="listed_<?php echo ($v["out_serial"]) ?>" value="0" <?php echo(($v["valeur_listed"] == 0 || empty($v["valeur_listed"]))?'checked="checked"':"") ?>>非上場</label>
            </div>
            </td>
            <!--  -->
            <td>
                <div class="input-group">
                    <input <?php echo $readonly ?> type="text" class="form-control" name="capital_<?php echo ($v["out_serial"]) ?>" oninput="value=value.replace(/[^0-9.]+/i,'')" placeholder="" value="<?php echo(($v["valeur_capital"])?(number_format($v["valeur_capital"], 0,'',',')):""); ?>">
                    <button class="btn btn-outline-secondary" type="button" disabled>円</button>
                </div>
            </td>
            <!-- 商品名 -->
            <td>
            <div class="input-group">
                <input <?php echo $readonly ?> type="text" name="annual_sales_<?php echo ($v["out_serial"]) ?>" class="form-control" oninput="value=value.replace(/[^0-9.]+/i,'')" placeholder="" value="<?php echo(($v["valeur_capital"])?(number_format($v["valeur_annual_sales"], 0,'',',')):""); ?>">
                <button class="btn btn-outline-secondary" type="button" disabled>円</button>
            </div>
            </td>
            <td>
                <div class="btn-group">
                <!-- <button class="btn btn-success btn-sm resign" data-toggle="modal" data-target="#exampleModalCenter" type="button" data-serial="<?php echo($v["out_serial"]) ?>" data-company="<?php echo($v["out_coname"]) ?>" value="申込"> -->
                <?php if(isset($v["valeur_serial"]) && ($v["valeur_serial"] != NULL) && ($v["day_debut"] == NULL)) { ?>
                    <button class="btn btn-secondary btn-sm resign" type="button" data-serial="<?php echo($v["out_serial"]) ?>" data-company="<?php echo($v["out_coname"]) ?>" disabled>審査中
                <?php } elseif (isset($v["valeur_serial"]) && ($v["valeur_serial"] != NULL) && ($v["day_debut"] != NULL)) { ?>
                    <button class="btn btn-danger btn-sm resign"  type="button" data-serial="<?php echo($v["out_serial"]) ?>" data-company="<?php echo($v["out_coname"]) ?>" disabled>申込済み
                <?php } else { ?>
                    <button class="btn btn-primary btn-sm resign" data-toggle="modal" data-target="#exampleModalCenter" type="button" data-serial="<?php echo($v["out_serial"]) ?>" data-company="<?php echo($v["out_coname"]) ?>">申込
                <?php } ?>
                <!-- </button> -->
                </div>
            </td>

        </tr>
        <?php endforeach ?>
        </tbody>
    </table>
    </form>
<div class="pagination mb-3">
<?php 
    if ($current_page > 1 && $total_page > 1){
        echo '<a class="page-link" href="/outlet/valeur/kanri/seller_list_all.php?page='.($current_page-1).'">前</a>';
    }
    for ($i = 1; $i <= $total_page; $i++){
        if ($i == $current_page){
            echo '<span class="page-link" style="background-color: #ffb24f;">'.$i.'</span>';
        }
        else{
            echo '<a class="page-link" href="/outlet/valeur/kanri/seller_list_all.php?page='.$i.'">'.$i.'</a>';
        }
    }
    if ($current_page < $total_page && $total_page > 1){
        echo '<a class="page-link" href="/outlet/valeur/kanri/seller_list_all.php?page='.($current_page+1).'">次</a>';
    }
?>
</div>
</main>

</div><!-- container -->

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">確認商品</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="mess">
            確認？
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal" type="submit" id="submit_btn" name="submit" value="Submit">決定</button>
        </div>
        </div>
    </div>
</div>
<a class="pagetop" href="#" id="topbutton"><div class="pagetop__arrow"></div></a>
<script>
var prevScrollpos = window.pageYOffset;
// console.log(prevScrollpos);
window.onscroll = function() {
var currentScrollPos = window.pageYOffset;
    if (currentScrollPos > 1500) {
    document.getElementById("topbutton").style.display = "flex";
    } else {
    document.getElementById("topbutton").style.display = "none";
    }
}
</script>
</body>
</html>

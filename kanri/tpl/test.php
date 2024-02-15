<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <!-- new -->
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

    <!-- <script type="text/javascript" language="javascript" src='/outlet/valeur/common/js/itemreg.js?<?php echo time()?>'></script> -->
    <title>バルル商品管理一覧</title>
    <script type="text/javascript" language="javascript">
        $(document).ready(function(){
            // $('#seller_all_tbl').DataTable({
            //     ajax: {
            //         url: 'outlet/valeur/kanri/seller_list_all.php',
            //         dataSrc: 'responseData',
            //         data: {'edit_type': 'api'}

            //     },
            //     columns: [
            //     { data: "Name" }, 
            //     { data: "Total" }, 
            //     { data: "Passed" },
            //     { data: "Failed" }
            //     ]
            // })


            $('#seller_all_tbl').DataTable({
                ajax: {
                    url: 'api.php?mode=all',
                    // dataType: "JSON",
                    dataSrc: ""
                    // dataSrc: function(data){
                    //     var length = data.length;
                    //         for(var i = 0; i < length; i++) {}
                    //         item_serial_list.push(data[i]['serial']);
                    //         data[i]["index"] = i + 1;
                    //         make_modal(data[i]);
                    // }
                    // data: {'edit_type': 'api'}

                },
                columns: [
                    { data: "out_serial" },
                    { data: "out_coname" },
                    { data: "out_coname" },
                    { data: "out_tantou" },
                    { data: "out_tantou" },
                    { data: "out_mail" },
                    { data: "out_coname" },
                    { data: "out_coname" }
                ],
                "orderClasses": false,
                "processing": true,
                "stateSave": false,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "paging": true,
                "displayLength": 50,
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

            $('.resign').on('click', function(){
                var f_serial = $(this).data('serial');
                console.log({f_serial});
                var seller_shop = $(this).data('company');

                var f_listed = $(this).closest("tr").find('input[name="listed_' + f_serial + '"]:checked').val();
                var f_capital = $(this).closest("tr").find('input[name="capital_' + f_serial +'"]').val();
                var f_annual_sales = $(this).closest("tr").find('input[name="annual_sales_' + f_serial +'"]').val();

                $("#exampleModalLongTitle").text("申し込み確認");
                $("#mess").text(seller_shop + "を申込しますか？");
                $("#submit_btn").text("申込する");
                
                $('#submit_btn').click(function(){
                    // const f_listed = $('input[name="listed_' + f_serial + '"]:checked').val();
                    // const f_capital = $('input[name="capital_' + f_serial + '"]').val();
                    // const f_annual_sales = $('input[name="annual_sales_'+ f_serial + '"]').val();
                    // const f_capital = $(this).closest("tr").attr('id');
                    
                    console.log(f_serial,f_listed,f_capital,f_annual_sales);
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
	.space{
		margin-right:5em;
	}
	input[type=checkbox] {
		width: 20px;
		height: 20px;
		vertical-align: middle;
	}
	.w-break_date {
		word-wrap: break-word;
		white-space: nowrap;
		width: auto;
	}

	.table>thead.top {
		background-color: dimgrey;
		color: #fff;
		/* darkgrey; */
	}

	.table.edit {
		max-width: 1000px;
	}

	.table.edit>thead th {
		background-color: dimgrey;
		color: #fff;
	}

	.ui-dialog > .ui-widget-header {
		background: #448ACA;
		color: #fff;
		border-bottom: 2px solid #448ACA;
		font-size: 1.5em;
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
    /* table tr th, table tr td{
        border: 1px solid black !important;
    } */
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
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" target="_self">
    <table class="table table-hover table-bordered top" id="seller_all_tbl">
        <thead class="align-middle text-center top">
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
        </tbody>
    </table>
</form>
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
</body>
</html>
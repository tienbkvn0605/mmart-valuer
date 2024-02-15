
var BASE_AJAX_URL = '/outlet/valeur/seller/list_item.php';

jQuery(function(){
	
    $(document.body).on('click', '.re_set_price_html', function(){
        var ai_serial = $(this).data('item_ai_serial'),
            item = $(this).data('item'),
            price_lot = $(this).data('item_price_lot'),
            tani = $(this).data('item_tani'),
            tanka = $(this).data('item_tanka');

        var html = '';
        html += '<div class="p-3" >';
            html += '<div class="alert alert-primary text-dark pt-2 pb-2" role="alert" style="font-size: 20px"><b>'+item+'</b></div>';
            html += '<table class="table table-bordered align-middle">';
                html += '<tbody>';
                    html += '<tr>';
                        html += '<th class="table-light">単価<span class="text-danger">*</span></th>';
                        html += '<td>';
                            html += '<span class="text-primary-emphasis" style="font-size: 0.8em;">半角数字以外は入力不可（卸サイトになりますので「卸価格」を表示）</span><br>';
                            html += '<span class="text-primary-emphasis" style="font-size: 0.8em;">「税込価格」で入力してください</span><br>';
                            html += '<div class="row">';
                                html += '<div class="col-md-6">';
                                    html += '<div class="input-group">';
                                        html += '<input name="tanka" id="tanka" type="text" class="form-control" value="'+tanka+'" oninput="value=value.replace(/[^0-9.]+/i,\'\');">';
                                        html += '<span class="input-group-text">円</span>';
                                    html += '</div>';
                                        html += '<span>単位：'+tani+'</span>';
                                html += '</div>';
                            html += '</div>';
                        html += '</td>';
                    html += '</tr>';
                    html += '<tr>';
                        html += '<th class="table-light">受注最小ロットの<br>合計金額<span class="text-danger">*</span></th>';
                        html += '<td>';
                            html += '<div class="row">';
                                html += '<div class="col-md-6">';
                                    html += '<span class="text-primary-emphasis" style="font-size: 0.8em;">半角数字以外は入力不可</span><br>';
                                    html += '<div class="input-group">';
                                        html += '<input name="lotkingaku" id="lotkingaku" type="text" class="form-control" size="16" value="'+price_lot+'" oninput="value=value.replace(/[^0-9.]+/i,\'\');">';
                                        html += '<span class="input-group-text">円</span>';
                                    html += '</div>';
                                html += '</div>';
                            html += '</div>';
                        html += '</td>';
                    html += '</tr>';
                html += '</tbody>';
            html += '</table>';
            html += '<input type="hidden" id="old_tanka" value="'+tanka+'" />';
            html += '<input type="hidden" id="old_lotkingaku" value="'+price_lot+'" />';
            html += '<button class="btn btn-danger re_set_price_cancel float-end">キャンセル</button>'
            html += '<button class="btn btn-primary re_set_price float-end me-2" data-ai_serial="'+ai_serial+'">価格再設定</button>'
        html += '</div>';
        $('#detail_item .modal-content').html('');
        $('#detail_item .modal-content').html(html);

    })

    // モーダル非表示にする
    $(document.body).on('click', '.re_set_price_cancel', function(){
        $('#detail_item').modal('hide');
    })
  
    // 価格再設定処理
    $(document.body).on('click', '.re_set_price', function(){
        var ai_serial = $(this).data('ai_serial');
        var old_tanka = $('#old_tanka').val();
        var old_lotkingaku = $('#old_lotkingaku').val();
        var new_tanka = $('#tanka').val();
        var new_lotkingaku = $('#lotkingaku').val();

        if(old_tanka == new_tanka){
            alert('新しい単価を入力してください。');
            $('#tanka').focus();
            return false;
        }

        if(old_lotkingaku == new_lotkingaku){
            alert('新しい単価を入力してください。');
            $('#lotkingaku').focus();
            return false;
        }

        var request = $.ajax({
            type : 'POST',
            URL : '/outlet/valeur/seller/list_item.php',
            data: {
                ai_serial, new_tanka, new_lotkingaku, p_kind: 're_set_price'
            }
        })

        request.done(function(res){
            var res_split = res.split(':r:');
            if(res_split[1] == "OK"){
                alert('価格を再設定しました。');
                $('#detail_item').modal('hide');
                location.reload();
            }
        })
    })
	
});




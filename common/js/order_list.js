
var BASE_AJAX_URL = '/outlet/valeur/seller/order_list.php';

jQuery(function(){
	
    // 銀行口座情報取得　html作成
    $(document.body).on('click', '.show_bank_info', function(){
        var seller_id = $(this).data('item_ai_serial');
        var html = '';
        $('#modalTitle').text('銀行口座情報を登録します。');
        $('#modal_loading').show();
        var request = $.ajax({
            type: "POST",
            url : BASE_AJAX_URL,
            data: {seller_id, kind: 'show_bank_info'}
        })
        request.done(function(res){
            loading = false;
            var res_split = res.split(':r:');
            if(res_split[1] == 'OK'){
                var bank_info = JSON.parse(res_split[2]);
                $('#modal_loading').hide();
                $('#staticBackdrop .modal-body').html('');
                html += '<div class="mb-3">';
                    html += '<label for="bank_content" class="form-label">銀行口座情報：</label>';
                    html += '<textarea class="form-control" id="bank_content" rows="10" name="bank_content">'+bank_info+'</textarea>';
                html += '</div>';
                $('#staticBackdrop .modal-body').html(html);
            }
        })
        $('#staticBackdrop').modal('show');
    })	
    
    // 銀行口座情報登録処理
    $(document.body).on('click', '#modal_btn_reg', function(){
        var bank_content = $("#bank_content").val();
        if(!bank_content){
            alert('銀行口座情報を入力してください。');
            $('#bank_content').focus();
            return false;
        }
        $('#kind').val('bank_info_reg');
        $('#base_modal')[0].submit();
        $('#staticBackdrop .modal-body').html('');
        $('#staticBackdrop').modal('hide');

    })	
});




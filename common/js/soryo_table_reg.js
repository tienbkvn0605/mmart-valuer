var BASE_AJAX_URL = '/outlet/valeur/seller/soryo_reg.php';
$(document).ready(function () {
    
    // 都道府県選択
	$(document.body).on('click', '.kubun', function(){
		var region=$(this).data('region');
		if($(this).prop('checked')==false){
			$('.pref_'+region).each(function(){
				if($(this).prop('disabled')==false){
					$(this).prop('checked', false);
				}
			});
		}else{
			$('.pref_'+region).each(function(){
				if($(this).prop('disabled')==false){
					$(this).prop('checked', true);
				}
			});
		}
	})
	
	// 地方区分選択
	$(document.body).on('click', '.pref_all', function(){
		var region=$(this).data('region');
		if($(this).prop('checked')==true){
			if($('#kubun_id_'+region).prop('checked') == false){
				$('#kubun_id_'+region).prop('checked', true);
			}
		}
	})

	//送料設定
	$(document.body).on('click', '#set_soryo_table', function(){
		var soryo_table_name = $('#soryo_table_name').val();
        if(!soryo_table_name){
            alert('配送料表を入力してください。');
            $('#soryo_table_name').focus();
            $('#soryo_table_name').css('border-color', '#dc3545');
            $('#soryo_table_name').val('');
            return false;
        }else{
            $('#soryo_table_name').css('border-color', '#0a58ca');
            $('.invalid-feedback').hide();
        }
		var regionSelected = [];
		$("input[name='region']:checked").each(function() {
            regionSelected.push($(this).val()); // 
        });

		if(regionSelected.length == 0){
			alert('地方区分を選択してください。');
			return false;
		}else{
			var err = false;
			var soryo_data = [];
			$.each(regionSelected, function (key, region_serial) {
				var prefSelected= [];
				if(region_serial == 13){
					var region_text = $('#region_label_13').val();
					var price = $('#soryo_13_0').val();
					var size = $('#size_13_0').val();
					var weight = $('#weight_13_0').val();
					// 配送料
					if(!price){
						alert('配送料を設定してください。');
						$('#soryo_13_0').focus();
						err = true;
						return true;
					}
					// サイズ
					if(!size){
						alert('サイズを設定してください。');
						$('#size_13_0').focus();
						err = true;
						return true;
					}
					// weight
					if(!weight){
						alert('重さを設定してください。');
						$('#weight_13_0').focus();
						err = true;
						return true;
					}

					let pref_data_13 = {};
					let pref_key = ($('#label_region_13').text()).trim();
					pref_data_13[pref_key] = {}; 
					if(region_text){
						pref_data_13[pref_key].region_label = region_text.trim(); 
						pref_data_13[pref_key].region = pref_key; 
					}
					pref_data_13[pref_key].price = price; 
					pref_data_13[pref_key].size = size; 
					pref_data_13[pref_key].weight = weight; 
					prefSelected.push(pref_data_13); 
				}else{
					$("input[name='pref_"+region_serial+"[]']:checked").each(function() {
						var pref = $(this).attr('id');
						var pref_split = pref.split('pref');
	
						// 送料
						var price = $('#soryo'+pref_split[1]).val();
						
						let pref_data = {};
						pref_data[$(this).val()] = {};
	
						if(!price){
							alert('配送料を設定してください。');
							$('#soryo'+pref_split[1]).focus();
							err = true;
							return true;
						}else{
							pref_data[$(this).val()].price = price;
						}
						
						// サイズ
						var size = $('#size'+pref_split[1]).val();
						if(!size){
							alert('サイズを設定してください。');
							$('#size'+pref_split[1]).focus();
							err = true;
							return true;
						}else{
							pref_data[$(this).val()].size = size;
						}
						
						
						// weight
						var weight = $('#weight'+pref_split[1]).val();
						if(!weight){
							alert('重さを設定してください。');
							$('#weight'+pref_split[1]).focus();
							err = true;
							return true;
						}else{
							pref_data[$(this).val()].weight = weight;
						}
	
						// 都道府県のテキスト
						var region_text = $('#region_label_'+region_serial).val();
						if(region_text != ''){
							pref_data[$(this).val()].region_label = region_text;
						}
						
						//　地方区分
						var region = $('#label_region_'+region_serial).text();
						pref_data[$(this).val()].region = region.trim();
						
						prefSelected.push(pref_data); 
					});
				}
			
				soryo_data[region_serial] = prefSelected;
			})
				
			
			if(err){
				return false;
			}
            $('#soryo_data').val(JSON.stringify(soryo_data));
            $('#p_kind').val('set_soryo');
            $('#data_soryo')[0].submit();
			// window.reload();
		}

	})
    
    // 休業日設定表名をチェック
    $(document.body).on('blur', '#soryo_table_name', function(){
        var soryo_table_name = $('#soryo_table_name').val();
        if(soryo_table_name != ''){
            var request = $.ajax({
                type : 'POST',
                URL : BASE_AJAX_URL,
                data : {soryo_table_name, p_kind : 'soryo_table_name_check'},
            })
            request.done(function(res){
                var res_split = res.split(':r:');
                if(res_split[1] == 'error'){
                    $('#soryo_table_name').css('border-color', '#dc3545');
                    $('.invalid-feedback').show();
                    $('#soryo_table_name').val('');
                    return false;
                }else{
                    $('#soryo_table_name').css('border-color', '#0a58ca');
                    $('.invalid-feedback').hide();
                }
            })
        }
        
    })

    // 配送料設定表を削除
    $(document.body).on('click', '.remove_soryo_by_serial', function(){
        var soryo_master_serial = $(this).data('soryo_master_serial');
      
        if(confirm('配送料設定表を削除します。\nよろしいでしょうか？')){
            var request = $.ajax({
                type : 'POST',
                URL : BASE_AJAX_URL,
                data : {soryo_master_serial, p_kind : 'remove_soryo_by_serial'},
            })
            request.done(function(res){
                var res_split = res.split(':r:');
                if(res_split[1] != 'error'){
                    location.reload();
                }
            })
        }
    })
   
});


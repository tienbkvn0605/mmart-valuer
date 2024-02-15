<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <title><?php echo(escape($config['title']));?></title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript">

    jQuery( function() {

    });
    //管理画面へ戻る
    function F_back($f_form, $kind) {
        $f_form['p_kind'].value = $kind;
        $f_form.submit();
    }
    
    //商品登録処理
    function F_set_item($f_form, $kind) {
        // var ai_serial = $f_form['ai_serial'].value;
        
        var request = $.ajax({
			method : "POST", 
			url : '/outlet/valeur/seller/itemreg.php',
			data : {p_kind : 'item_register_check', item : $f_form['item'].value},
		});
		request.done(function(response) {
			if(response == "NAME_ERROR"){
				alert('既に同名のカテゴリが登録されています。');
				$f_form['item'].focus();
				return false;
			}else if(response == "REGISTER_OK"){
                $f_form['p_kind'].value = $kind;
				$f_form.submit();
				return false;
			}
		})

        
      
    }

    //-----------------------------------------------
    //新規登録時項目チェック
    //-----------------------------------------------
    function F_item_chk($f_form){
        cnt=0;
        for(var i=0;i<$f_form.elements.length;i++){//new_up内の入力項目数
            if(($f_form.elements[i].name=="c_box") && ($f_form.elements[i].checked)){//nameがc_boxでチェックされている場合
                cnt ++;
            }
        }
        
        if(cnt == $f_form.elements['c_box'].length){　//c_boxの数だけチェックが入っていたら
            $f_form.b_type.disabled = false; // 有効化
            $('.btn_item_submit').css({'opacity':'1','cursor':'pointer'});
        }
        else{
            $f_form.b_type.disabled = true; // 無効化
            $('.btn_item_submit').css({'opacity':'0.6','cursor':'default'});
        }
    }
    </script>
</head>

    <body>
        <section class="container-fluid mt-3"> 
            <div class="alert alert-primary" role="alert" style="background-color: #a9a6ff; border-color: #a9a6ff">
                <h3 class="mb-0 text-dark">
                    <span class="badge bg-secondary"><?php echo mb_convert_encoding($A_seller['valeur_coname'], 'utf-8', 'auto')?></span>
                    <span class="fw-bold" style="font-size: 20px;">　■バルル商品情報確認</span>
                </h3>
            </div>
            
            <div class="row mt-3">
                <div class="col col-md-8" >
                    <form name="f_base" id="register" action="/outlet/valeur/seller/itemreg.php" method="post" enctype="multipart/form-data" onSubmit="return false">
                    <input type="hidden" name="is_new_cate_add" id="is_new_cate_add" value="<?php echo @$is_new_cate_add;?>" />
                        <table class="table table-bordered align-middle">
                            <tbody>
                                <!-- 送料設定 -->
                                <tr>
                                    <th >運送費設定<span class="text-danger">*</span></th>
                                    <td >
                                        <div class="card border-secondary mb-3">
                                            <div class="card-header">
                                                <?php echo $soryo_arr[$_POST['select_soryo_table']]['soryo_name']?>
                                            </div>
                                            <div class="card-body text-secondary">
                                                <table class="table table-bordered table-hover">
                                                    <thead class="table-dark">
                                                        <tr>
                                                        <th scope="col">都道府県</th>
                                                        <th scope="col">地方区分</th>
                                                        <th scope="col">送料表</th>
                                                        <th scope="col">サイズ（cm）</th>
                                                        <th scope="col">kg</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="soryo_content">
                                                        <?php  foreach ($soryo_arr[$_POST['select_soryo_table']]['soryo_table'] as $key => $value) { ?>
                                                            <tr>
                                                                <td><?php echo $A_region[$value['region_serial']]['region'];?><br/><?php echo $value['region_label'] ?? '';?></td>
                                                                <td><?php echo $value['pref'];?></td>
                                                                <td><?php echo number_format($value['fee']);?>円</td>
                                                                <td><?php echo $value['size'];?></td>
                                                                <td><?php echo $value['weight'];?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <!-- 休業日設定 -->
                                <tr>
                                    <th >休業日設定<span class="text-danger">*</span></th>
                                    <td >
                                        <?php foreach ($f_calendar_arr as $key => $holiday) { ?>
                                            <div class="card border-secondary mb-3" style="max-width: 300px;">
                                                <div class="card-header">
                                                    <?php echo $holiday['holiday_name']?>
                                                </div>
                                                <div class="card-body text-secondary">
                                                    <ol class="list-group list-group-numbered">
                                                        <?php  $f_holiday_arr = explode(',', $holiday['kyugyou_date']);
                                                        
                                                        foreach ($f_holiday_arr as $v) {
                                                            echo '<li class="list-group-item">'.$v.'</li>';
                                                        } ?>
                                                    </ol>
                                                    
                                                </div>
                                            </div>
                                        <?php } ?>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light" align="midle">カテゴリ選択<span class="text-danger">*</span></th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div id="cate1_box">
                                                    第一:<?php echo $item_data['cate1_text']?>
                                                    <input type="hidden" value="<?php echo $item_data['cate1no']?>" name="cate1no" id="cate1no"/>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div id="cate2_box" style="<?php echo isset($item_data['cate2no']) && $item_data['cate2no'] != 0 ? '' : 'display:none;' ?>">
                                                    第二:<?php echo $item_data['cate2_text']?>
                                                    <input type="hidden" value="<?php echo $item_data['cate2no']?>" name="cate2no" id="cate2no"/>
                                                </div>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div id="cate3_box" style="<?php echo isset($item_data['cate3no']) && $item_data['cate3no'] != 0 ? '' : 'display:none;' ?>" >
                                                    第三:<?php echo $item_data['cate3_text']?>
                                                    <input type="hidden" value="<?php echo $item_data['cate3no']?>" name="cate3no" id="cate3no"/>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div id="cate4_box" style="<?php echo isset($item_data['cate4no']) && $item_data['cate4no'] != 0 ? '' : 'display:none;' ?>">
                                                    第四:<?php echo (isset($item_data['cate4_text']) ? $item_data['cate4_text'] : '');?>
                                                    <input type="hidden" value="<?php echo (isset($item_data['cate4no']) ? $item_data['cate4no'] : '') ;?>" name="cate4no" id="cate4no"/>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div id="cate5_box" style="<?php echo isset($item_data['cate5no']) ? '' : 'display:none;' ?>">
                                                    種別:<?php echo isset($item_data['cate5no']) ? $item_data['cate5no'] : ''?>
                                                    <input type="hidden" value="<?php echo isset($item_data['cate5no']) ? $item_data['cate5no'] : '';?>" name="cate5no" id="cate5no"/>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <!-- 商品名 -->
                                <tr>
                                    <th class="table-light">商品名<span class="text-danger">*</span></th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <?php echo $item_data['item']?>
                                                <input type="hidden" value="<?php echo $item_data['item']?>" name="item" id="item"/>
                                            </div>
                                        </div>
                                        
                                    </td>
                                </tr>
                                <!-- 商品名ヨミガナ -->
                                <tr>
                                    <th class="table-light">商品名ヨミガナ<span class="text-danger">*</span></th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <?php echo $item_data['kana']?>
                                                <input type="hidden" value="<?php echo $item_data['kana']?>" name="kana" id="kana"/>
                                            </div>
                                        </div>
                                        
                                    </td>
                                </tr>
                                <!-- 単価 -->
                                <tr>
                                    <th class="table-light">単価<span class="text-danger">*</span></th>
                                    <td>                                      
                                        <?php echo number_format($item_data['tanka'])?>円
                                        <input type="hidden" value="<?php echo $item_data['tanka']?>" name="tanka" id="tanka"/>
                                    </td>
                                </tr>
                                <!-- 単位 -->
                                <tr>
                                    <th class="table-light">単位<span class="text-danger">*</span></th>
                                    <td>
                                        <div class="d-flex flex-row align-items-center mt-2" style="max-width: 400px;">
                                            <?php echo ($item_data['tani2'])?>/<?php echo ($item_data['tani1'])?>(<?php echo ($item_data['tani3'])?>)
                                            <input type="hidden" value="<?php echo $item_data['tani1']?>" name="tani1" id="tani1"/>
                                            <input type="hidden" value="<?php echo $item_data['tani2']?>" name="tani2" id="tani2"/>
                                            <input type="hidden" value="<?php echo $item_data['tani3']?>" name="tani3" id="tani3"/>
                                        </div>
                                    </td>
                                </tr>
                                <!-- 定貫・不定貫 -->
                                <tr>
                                    <th class="table-light">定貫・不定貫<span class="text-danger">*</span></th>
                                    <td>
                                        <?php echo (isset($item_data['teikan']) && $item_data['teikan'] == 'tei' ? '定貫' : '不定貫' )?>
                                        <input type="hidden" value="<?php echo $item_data['teikan']?>" name="teikan" id="teikan"/>
                                    </td>
                                </tr>
                                <!-- 受注最小ロット -->
                                <tr>
                                    <th class="table-light">受注最小ロット<span class="text-danger">*</span></th>
                                    <td>
                                        <?php echo ($item_data['lot'])?>
                                        <input type="hidden" value="<?php echo $item_data['lot']?>" name="lot" id="lot"/>
                                    </td>
                                </tr>
                                <!-- 受注最小ロットの -->
                                <tr>
                                    <th class="table-light">
                                        受注最小ロットの<br />
                                        合計金額<span class="text-danger">*</span>
                                    </th>
                                    <td>
                                        <?php echo number_format($item_data['lotkingaku'])?>円
                                        <input type="hidden" value="<?php echo $item_data['lotkingaku']?>" name="lotkingaku" id="lotkingaku"/>
                                    </td>
                                </tr>
                                <!-- 生(原)産地 -->
                                <tr>
                                    <th class="table-light">生(原)産地<span class="text-danger">*</span></th>
                                    <td>
                                        <?php echo ($item_data['sanchi'])?>
                                        <input type="hidden" value="<?php echo $item_data['sanchi']?>" name="sanchi" id="sanchi"/>
                                    </td>
                                </tr>
                                <!-- 加工地 -->
                                <tr>
                                    <th class="table-light">加工地<span class="text-danger">*</span></th>
                                    <td>
                                        <?php echo ($item_data['kakouchi'])?>
                                        <input type="hidden" value="<?php echo $item_data['kakouchi']?>" name="kakouchi" id="kakouchi"/>
                                    </td>
                                </tr>
                                <!-- 栄養成分表示 -->
                                <?php if($item_data['eiyou']):?>
                                    <tr>
                                        <th class="table-light">栄養成分表示</th>
                                        <td>
                                            <div id="eiyou_textarea">
                                                <div id="eiyou_input" class="eiyou_input" style="<?php echo ($item_data['cate1no'] == 9 ? 'display: block' : 'display: none') ?>">
                                                    <br />
                                                    ●成分値入力(<span style="color: #ff0000">※</span>は入力必須項目)<br />
                                                    <table class="table table-bordered text-center">
                                                        <tbody>
                                                            <tr>
                                                                <th class="table-light">エネルギー<span style="color: #ff0000">※</span></th>
                                                                <th class="table-light">水分</th>
                                                                <th class="table-light">蛋質白<span style="color: #ff0000">※</span></th>
                                                                <th class="table-light">脂質<span style="color: #ff0000">※</span></th>
                                                                <th class="table-light">炭水化物<span style="color: #ff0000">※</span></th>
                                                                <th class="table-light">灰分</th>
                                                            </tr>
                                                            <tr>
                                                                <td style="white-space: nowrap">
                                                                    <div>
                                                                        <div class="input-group">
                                                                            <input name="c_energy" class="form-control" type="text" value="<?php echo @$item_data['c_energy'];?>"size="6" maxlength="10" readonly="readonly"/>
                                                                            <span class="input-group-text">kcal</span>
                                                                        </div>
                                                                        <div class="text-center">(整数)</div>
                                                                    </div>
                                                                </td>
                                                                <td style="white-space: nowrap">
                                                                    <div>
                                                                        <div class="input-group">
                                                                        <input name="c_suibun" class="form-control" type="text" value="<?php echo @$item_data['c_suibun'];?>"	size="6" maxlength="10" readonly="readonly"/>
                                                                            <span class="input-group-text">g</span>
                                                                        </div>
                                                                        <div class="text-center">(小数点第1位迄)</div>
                                                                    </div>
                                                                    
                                                                </td>
                                                                <td style="white-space: nowrap">
                                                                    <div>
                                                                        <div class="input-group">
                                                                        <input name="c_tanpaku" class="form-control" type="text" value="<?php echo @$item_data['c_tanpaku'];?>"	size="6" maxlength="10" readonly="readonly"/>
                                                                            <span class="input-group-text">g</span>
                                                                        </div>
                                                                        <div class="text-center">(小数点第1位迄)</div>
                                                                    </div>
                                                                </td>
                                                                <td style="white-space: nowrap">
                                                                    <div>
                                                                        <div class="input-group">
                                                                        <input name="c_shishitsu" class="form-control" type="text" value="<?php echo @$item_data['c_shishitsu'];?>"	size="6" maxlength="10" readonly="readonly"/>
                                                                            <span class="input-group-text">g</span>
                                                                        </div>
                                                                        <div class="text-center">(小数点第1位迄)</div>
                                                                    </div>
                                                                </td>
                                                                <td style="white-space: nowrap">
                                                                    <div>
                                                                        <div class="input-group">
                                                                        <input name="c_tansui" class="form-control" type="text" value="<?php echo @$item_data['c_tansui'];?>" size="6" maxlength="10" readonly="readonly"/>
                                                                            <span class="input-group-text">g</span>
                                                                        </div>
                                                                        <div class="text-center">(小数点第1位迄)</div>
                                                                    </div>
                                                                </td>
                                                                <td style="white-space: nowrap">
                                                                    <div>
                                                                        <div class="input-group">
                                                                        <input name="c_kaibun" class="form-control" type="text" value="<?php echo @$item_data['c_kaibun'];?>" size="6" maxlength="10" readonly="readonly"/>
                                                                            <span class="input-group-text">g</span>
                                                                        </div>
                                                                        <div class="text-center">(小数点第1位迄)</div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    (100g当たり)<br /><br />○無機質
                                                    <table class="table table-bordered text-center">
                                                        <tbody>
                                                            <tr>
                                                                <th class="table-light">Na</th>
                                                                <th class="table-light">K</th>
                                                                <th class="table-light">Ca</th>
                                                                <th class="table-light">Mg</th>
                                                                <th class="table-light">P</th>
                                                                <th class="table-light">Fe</th>
                                                                <th class="table-light">Zn</th>
                                                            </tr>
                                                            <tr>
                                                                <td style="white-space: nowrap">
                                                                    <div>
                                                                        <div class="input-group">
                                                                            <input name="c_na" class="form-control" type="text" value="<?php echo @$item_data['c_na'];?>"size="6" maxlength="10" readonly="readonly"/>
                                                                            <span class="input-group-text">mg</span>
                                                                        </div>
                                                                        <div class="text-center">(整数)</div>
                                                                    </div>
                                                                </td>
                                                                <td style="white-space: nowrap">
                                                                    <div>
                                                                        <div class="input-group">
                                                                            <input name="c_k" class="form-control" type="text" value="<?php echo @$item_data['c_k'];?>"size="6" maxlength="10" readonly="readonly"/>
                                                                            <span class="input-group-text">mg</span>
                                                                        </div>
                                                                        <div class="text-center">(整数)</div>
                                                                    </div>
                                                                </td>
                                                                <td style="white-space: nowrap">
                                                                    <div>
                                                                        <div class="input-group">
                                                                            <input name="c_ca" class="form-control" type="text" value="<?php echo @$item_data['c_ca'];?>"size="6" maxlength="10" readonly="readonly"/>
                                                                            <span class="input-group-text">mg</span>
                                                                        </div>
                                                                        <div class="text-center">(整数)</div>
                                                                    </div>
                                                                </td>
                                                                <td style="white-space: nowrap">
                                                                    <div>
                                                                        <div class="input-group">
                                                                            <input name="c_mg" class="form-control" type="text" value="<?php echo @$item_data['c_mg'];?>"size="6" maxlength="10" readonly="readonly"/>
                                                                            <span class="input-group-text">mg</span>
                                                                        </div>
                                                                        <div class="text-center">(整数)</div>
                                                                    </div>
                                                                </td>
                                                                <td style="white-space: nowrap">
                                                                    <div>
                                                                        <div class="input-group">
                                                                            <input name="c_p" class="form-control" type="text" value="<?php echo @$item_data['c_p'];?>"size="6" maxlength="10" readonly="readonly"/>
                                                                            <span class="input-group-text">mg</span>
                                                                        </div>
                                                                        <div class="text-center">(整数)</div>
                                                                    </div>
                                                                </td>
                                                                <td style="white-space: nowrap">
                                                                    <div>
                                                                        <div class="input-group">
                                                                            <input name="c_fe" class="form-control" type="text" value="<?php echo @$item_data['c_fe'];?>"size="6" maxlength="10" readonly="readonly"/>
                                                                            <span class="input-group-text">mg</span>
                                                                        </div>
                                                                        <div class="text-center">(小数点第1位迄)</div>
                                                                    </div>
                                                                </td>
                                                                <td style="white-space: nowrap">
                                                                    <div>
                                                                        <div class="input-group">
                                                                            <input name="c_zn" class="form-control" type="text" value="<?php echo @$item_data['c_zn'];?>"size="6" maxlength="10" readonly="readonly"/>
                                                                            <span class="input-group-text">mg</span>
                                                                        </div>
                                                                        <div class="text-center">(小数点第1位迄)</div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    (100g当たり)<br />
                                                    <br />
                                                    ○ビタミン
                                                    <table class="table table-bordered text-center">
                                                        <tbody>
                                                            <tr>
                                                            <th class="table-light">レチノール</th>
                                                            <th class="table-light">カロテン</th>
                                                            <th class="table-light">B1</th>
                                                            <th class="table-light">B2</th>
                                                            <th class="table-light">C</th>
                                                            </tr>
                                                            <tr>
                                                                <td style="white-space: nowrap">
                                                                    <div>
                                                                        <div class="input-group">
                                                                            <input name="c_lechi" class="form-control" type="text" value="<?php echo @$item_data['c_lechi'];?>"size="6" maxlength="10" readonly="readonly"/>
                                                                            <span class="input-group-text">μg</span>
                                                                        </div>
                                                                        <div class="text-center">(整数)</div>
                                                                    </div>
                                                                </td>
                                                                <td style="white-space: nowrap">
                                                                    <div>
                                                                        <div class="input-group">
                                                                            <input name="c_kalo" class="form-control" type="text" value="<?php echo @$item_data['c_kalo'];?>"size="6" maxlength="10" readonly="readonly"/>
                                                                            <span class="input-group-text">μg</span>
                                                                        </div>
                                                                        <div class="text-center">(整数)</div>
                                                                    </div>
                                                                </td>
                                                                <td style="white-space: nowrap">
                                                                    <div>
                                                                        <div class="input-group">
                                                                            <input name="c_b1" class="form-control" type="text" value="<?php echo @$item_data['c_b1'];?>"size="6" maxlength="10" readonly="readonly"/>
                                                                            <span class="input-group-text">mg</span>
                                                                        </div>
                                                                        <div class="text-center">(小数点第2位迄)</div>
                                                                    </div>
                                                                </td>
                                                                <td style="white-space: nowrap">
                                                                    <div>
                                                                        <div class="input-group">
                                                                            <input name="c_b2" class="form-control" type="text" value="<?php echo @$item_data['c_b2'];?>"size="6" maxlength="10" readonly="readonly"/>
                                                                            <span class="input-group-text">mg</span>
                                                                        </div>
                                                                        <div class="text-center">(小数点第2位迄)</div>
                                                                    </div>
                                                                </td>
                                                                <td style="white-space: nowrap">
                                                                    <div>
                                                                        <div class="input-group">
                                                                            <input name="c_c" class="form-control" type="text" value="<?php echo @$item_data['c_c'];?>"size="6" maxlength="10" readonly="readonly"/>
                                                                            <span class="input-group-text">mg</span>
                                                                        </div>
                                                                        <div class="text-center">(整数)</div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    (100g当たり)<br />
                                                    <br />
                                                    ○食物繊維、食塩相当量
                                                    <table class="table table-bordered text-center" style="max-width: 300px">
                                                        <tbody>
                                                            <tr>
                                                                <th class="table-light">食物繊維</th>
                                                                <th class="table-light">食塩相当量</th>
                                                            </tr>
                                                            <tr>
                                                                <td style="white-space: nowrap">
                                                                    <div>
                                                                        <div class="input-group">
                                                                            <input name="c_seni" class="form-control" type="text" value="<?php echo @$item_data['c_seni'];?>"size="6" maxlength="10" readonly="readonly"/>
                                                                            <span class="input-group-text">g</span>
                                                                        </div>
                                                                        <div class="text-center">(小数点第1位迄)</div>
                                                                    </div>
                                                                </td>
                                                                <td style="white-space: nowrap">
                                                                    <div>
                                                                        <div class="input-group">
                                                                            <input name="c_shokuen" class="form-control" type="text" value="<?php echo @$item_data['c_shokuen'];?>"size="6" maxlength="10" readonly="readonly"/>
                                                                            <span class="input-group-text">g</span>
                                                                        </div>
                                                                        <div class="text-center">(小数点第1位迄)</div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    (100g当たり)<br />
                                                    <br />
                                                </div>
                                                <div>
                                                    <div class="row mt-2">
                                                        <div class="col-md-8">
                                                            <textarea name="eiyou" id="eiyou_text" cols="30" rows="10" class="form-control" readonly="readonly"><?php echo @$item_data['eiyou'];?></textarea>
                                                        </div>
                                                    </div>   
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif;?>
                               
                                <!-- 形態 -->
                                <tr>
                                    <th class="table-light">形態<span class="text-danger">*</span></th>
                                    <td>
                                        <?php echo ($item_data['keitai'])?>
                                        <input type="hidden" value="<?php echo $item_data['keitai']?>" name="keitai" id="keitai"/>
                                    </td>
                                </tr>
                                <!-- 荷姿 -->
                                <tr>
                                    <th class="table-light">荷姿<span class="text-danger">*</span></th>
                                    <td>
                                        <?php echo ($item_data['nisugata'])?>
                                        <input type="hidden" value="<?php echo $item_data['nisugata']?>" name="nisugata" id="nisugata"/>
                                    </td>
                                </tr>
                                <!-- サイズ -->
                                <tr>
                                    <th class="table-light">サイズ<span class="text-danger">*</span></th>
                                    <td>
                                        約<?php echo ($item_data['m_lot_weight'])?>kg (<?php echo ($item_data['size'])?>)
                                        <input type="hidden" value="<?php echo $item_data['m_lot_weight']?>" name="m_lot_weight" id="m_lot_weight"/>
                                        <input type="hidden" value="<?php echo $item_data['size']?>" name="size" id="size"/>
                                    </td>
                                </tr>
                                <!-- 賞味期限 -->
                                <tr>
                                    <th class="table-light">賞味期限<span class="text-danger">*</span></th>
                                    <td>
                                        保存方法:<?php echo ($item_data['hozon'])?><br/>
                                        <?php echo ($item_data['kigen'])?>
                                        <input type="hidden" name="kigen" id="kigen" value="<?php echo @$item_data['kigen'];?>"/>
                                        <input type="hidden" value="<?php echo $item_data['hozon']?>" name="hozon" id="hozon"/>
                                    </td>
                                </tr>
                                <!-- 解凍方法 -->
                                <tr>
                                    <th class="table-light">解凍方法</th>
                                    <td>
                                        <?php echo ($item_data['kaitou'])?>
                                        <input type="hidden" value="<?php echo $item_data['kaitou']?>" name="kaitou" id="kaitou"/>
                                    </td>
                                </tr>
                                <!-- 納期/発送体制 -->
                                <tr>
                                    <th class="table-light">納期/発送体制<span class="text-danger">*</span></th>
                                    <td>
                                        <?php echo ($item_data['nouki'])?>
                                        <input type="hidden" value="<?php echo $item_data['nouki']?>" name="nouki" id="nouki"/>
                                    </td>
                                </tr>
                                <!-- 納入実績 -->
                                <tr>
                                    <th class="table-light">納入実績</th>
                                    <td>
                                        <?php echo ($item_data['jisseki'])?>
                                        <input type="hidden" value="<?php echo $item_data['jisseki']?>" name="jisseki" id="jisseki"/>
                                    </td>
                                </tr>
                                <!-- メニュー -->
                                <tr>
                                    <th class="table-light">メニュー<span class="text-danger">*</span></th>
                                    <td>
                                        <?php echo ($item_data['menu'])?>
                                        <input type="hidden" value="<?php echo $item_data['menu']?>" name="menu" id="menu"/>
                                    </td>
                                </tr>
                                <!-- 備考 -->
                                <tr>
                                    <th class="table-light">備考</th>
                                    <td>
                                        <?php echo ($item_data['bikou'])?>
                                        <input type="hidden" value="<?php echo $item_data['bikou']?>" name="bikou" id="bikou"/>
                                    </td>
                                </tr>
                                <!-- 原材料、食品添加物 -->
                                <tr>
                                    <th class="table-light">原材料、食品添加物<span class="text-danger">*</span></th>
                                    <td>
                                        <?php echo ($item_data['zairyo'])?>
                                        <input type="hidden" value="<?php echo $item_data['zairyo']?>" name="zairyo" id="zairyo"/>
                                    </td>
                                </tr>
                                <!-- 詳しい商品説明 -->
                                <tr>
                                    <th class="table-light">詳しい商品説明<span class="text-danger">*</span></th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-9">
                                                <textarea name="setsumei" id="setsumei" cols="49" rows="10"	class="form-control" readonly="readonly"><?php echo @$item_data['setsumei'];?></textarea>
                                            </div>
                                        </div>
                                        
                                    </td>
                                </tr>
                                <!-- 在庫設定 -->
                                <tr>
                                    <th class="table-light">在庫設定</th>
                                    <td>
                                        <label><input name="zaiko_disp_flg" id="zaiko_disp_flg" class="stock_display form-check-input" type="checkbox" data-ai_serial="<?php echo @$item_data['ai_serial'];?>" <?php echo ((isset($item_data['m_zaiko_disp_flg']) && $item_data['m_zaiko_disp_flg'] == 1) ? 'checked':'');?> >
                                            <?php echo ((isset($item_data['m_zaiko_disp_flg']) && $item_data['m_zaiko_disp_flg'] == 1) ? '在庫を表示する':'在庫未設定');?>
                                        </label><br>
                                        <input name="m_zaiko_disp_flg" id="m_zaiko_disp_flg" type="hidden" value="<?php echo (isset($item_data['m_zaiko_disp_flg'])?$item_data['m_zaiko_disp_flg']:'');?>">
                                    </td>
                                </tr>
                                <!-- 総重量（kg） -->
                                <tr class="stock_input_<?php echo @$item_data['ai_serial'];?>" <?php echo ((isset($item_data['m_zaiko_disp_flg']) && $item_data['m_zaiko_disp_flg'] == 1) ? '':'style="display: none"');?>  >
                                    <th class="table-light">総重量（kg）<span class="text-danger">*</span></th>
                                    <td>
                                        <?php echo ($item_data['total_weight'])?>kg
                                        <input type="hidden" value="<?php echo $item_data['total_weight']?>" name="total_weight" id="total_weight"/>
                                    </td>
                                </tr>
                                <!-- 1ロットあたりの数量（kg） -->
                                <tr class="stock_input_<?php echo @$item_data['ai_serial'];?>" <?php echo ((isset($item_data['m_zaiko_disp_flg']) && $item_data['m_zaiko_disp_flg'] == 1) ? '':'style="display: none"');?> >
                                    <th class="table-light">1ロットあたりの数量（kg）<span class="text-danger">*</span></th>
                                    <td>
                                        <?php echo ($item_data['m_lot_weight'])?>kg
                                    </td>
                                </tr>
                                <!-- 在庫数 -->
                                <tr class="stock_input_<?php echo @$item_data['ai_serial'];?>" <?php echo ((isset($item_data['m_zaiko_disp_flg']) && $item_data['m_zaiko_disp_flg'] == 1) ? '':'style="display: none"');?> >
                                    <th class="table-light">在庫数<span class="text-danger">*</span></th>
                                    <td>
                                        <?php echo ($item_data['zaiko'])?>
                                        <input type="hidden" value="<?php echo $item_data['zaiko']?>" name="zaiko" id="zaiko"/>
                                    </td>
                                </tr>

                                <tr id="displimit" <?php echo @$displimit_style;?>>
                                    <th class="table-light">掲載期限</th>
                                    <td>
                                        <?php echo $f_displimit;?>
                                        <input type="hidden" value="<?php echo $item_data['m_disp_limit_y']?>" name="m_disp_limit_y" id="m_disp_limit_y"/>
                                        <input type="hidden" value="<?php echo $item_data['m_disp_limit_m']?>" name="m_disp_limit_m" id="m_disp_limit_m"/>
                                        <input type="hidden" value="<?php echo $item_data['m_disp_limit_d']?>" name="m_disp_limit_d" id="m_disp_limit_d"/>
                                        <input type="hidden" value="<?php echo $item_data['m_disp_limit_h']?>" name="m_disp_limit_h" id="m_disp_limit_h"/>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light">
                                        商品画像<span class="text-danger">*</span>
                                    </th>
                                    <td>
                                        <img src="<?php echo DF_f_pic_fold.$item_data['new_pic'] ?>" width="<?php echo DF_picsize_m ?>"> 
                                        <input type="hidden" name="new_pic" id="new_pic" value="<?php echo @$item_data['new_pic'];?>" data-image_name="new_pic"/>
                                    </td>
                                </tr>
                                <?php if(isset($item_data['new_pic2']) && $item_data['new_pic2']):?>
                                <tr>
                                    <th class="table-light">商品画像2</th>
                                    <td>
                                        <img src="<?php echo DF_f_pic_fold.$item_data['new_pic2'] ?>" width="<?php echo DF_picsize_m ?>"> 
                                        <input type="hidden" name="new_pic2" id="new_pic2" value="<?php echo @$item_data['new_pic2'];?>" data-image_name="new_pic2"/>
                                    </td>
                                </tr>
                                <?php endif?>
                                <?php if(isset($item_data['new_pic3']) && $item_data['new_pic3']):?>
                                    <tr>
                                        <th class="table-light">商品画像3</th>
                                        <td>
                                            <img src="<?php echo DF_f_pic_fold.$item_data['new_pic3'] ?>" width="<?php echo DF_picsize_m ?>"> 
                                            <input type="hidden" name="new_pic3" id="new_pic3" value="<?php echo @$item_data['new_pic3'];?>" data-image_name="new_pic3"/>
                                        </td>
                                    </tr>
                                <?php endif?>
                                
                                <?php if(isset($item_data['new_pic4']) && $item_data['new_pic4']):?>
                                    <tr>
                                        <th class="table-light">商品画像4<br />キャッチコピー</th>
                                        <td>
                                            <img src="<?php echo DF_f_pic_fold.$item_data['new_pic4'] ?>" width="<?php echo DF_picsize_m ?>"> 
                                            <br /><b class="mt-2"><?php echo @$item_data['pic4_catch_copy'];?></b>
                                            <input type="hidden" name="new_pic4" id="new_pic4" value="<?php echo @$item_data['new_pic4'];?>" data-image_name="new_pic4"/>
                                            <input name="pic4_catch_copy" id="pic4_catch_copy" type="hidden" value="<?php echo @$item_data['pic4_catch_copy'];?>"/>
                                        </td>
                                    </tr>
                                <?php endif?>
                                
                                <?php if(isset($item_data['new_pic5']) && $item_data['new_pic5']):?>
                                    <tr>
                                        <th class="table-light">商品画像5<br />キャッチコピー</th>
                                        <td>
                                            <img src="<?php echo DF_f_pic_fold.$item_data['new_pic5'] ?>" width="<?php echo DF_picsize_m ?>"> 
                                            <br /><b class="mt-2"><?php echo @$item_data['pic5_catch_copy'];?></b>
                                            <input type="hidden" name="new_pic5" id="new_pic5" value="<?php echo @$item_data['new_pic5'];?>" data-image_name="new_pic5"/>
                                            <input name="pic5_catch_copy" id="pic5_catch_copy" type="hidden" value="<?php echo @$item_data['pic5_catch_copy'];?>"/>
                                        </td>
                                    </tr>
                                <?php endif?>
                                
                                <?php if(isset($item_data['new_pic6']) && $item_data['new_pic6']):?>
                                    <tr>
                                        <th class="table-light">梱包画像</th>
                                        <td>
                                            <img src="<?php echo DF_f_pic_fold.$item_data['new_pic6'] ?>" width="<?php echo DF_picsize_m ?>"> 
                                            <input type="hidden" name="new_pic6" id="new_pic6" value="<?php echo @$item_data['new_pic6'];?>" data-image_name="new_pic6"/>
                                        </td>
                                    </tr>
                                <?php endif?>
                                
                                <?php if(isset($item_data['new_pic7']) && $item_data['new_pic7']):?>
                                    <tr>
                                        <th class="table-light">栄養成分画像</th>
                                        <td>
                                            <img src="<?php echo DF_f_pic_fold.$item_data['new_pic7'] ?>" width="<?php echo DF_picsize_m ?>"> 
                                            <input type="hidden" name="new_pic7" id="new_pic7" value="<?php echo @$item_data['new_pic7'];?>" data-image_name="new_pic7"/>
                                        </td>
                                    </tr>
                                <?php endif?>

                                
                                
                               
                            </tbody>
                        </table>
                        <div class="kakunin" style="padding-top: 20px" > 
                            <b><font color="#ff0000">・以下の項目を確認してチェックマークを入れ、[ 登録 ]にお進みください。</font></b><br>
                            <label><INPUT type="checkbox" name="c_box" class="form-check-input" onclick="F_item_chk(this.form)"> 商品の劣化なし OK</label><BR>
                            <label><INPUT type="checkbox" name="c_box" class="form-check-input" onclick="F_item_chk(this.form)"> 在庫数確認 OK</label><BR>
                            <label><INPUT type="checkbox" name="c_box" class="form-check-input" onclick="F_item_chk(this.form)"> 登録する画像は販売商品の現物 OK</label><BR>
                            <label><INPUT type="checkbox" name="c_box" class="form-check-input" onclick="F_item_chk(this.form)"> 以上のネット表示は、商品に添付した記載と相違なし OK</label><BR>
                            <div class="text_center padding_20px mt-3" >
                                <input class="btn btn-secondary" type="button" class="" value="　　戻る　　" onClick="F_back(this.form,'reg')">
                                <input class="btn btn-primary btn_item_submit" type="button" class="" name="b_type" value="　　登録　　" onClick="F_set_item(this.form,'item_register_run')" disabled>
                            </div>
                        </div>
                        <input type="hidden" name="p_kind" id="p_kind" value="">
                        <input type="hidden" name="ai_serial" id="ai_serial" value="<?php echo isset($item_data['ai_serial']) ? $item_data['ai_serial'] : 0;?>">
                        <input type="hidden" name="select_soryo_table" id="select_soryo_table" value="<?php echo isset($item_data['select_soryo_table']) ? $item_data['select_soryo_table'] : '';?>">
                        <input type="hidden" name="select_holiday_table" id="select_holiday_table" value="<?php echo isset($item_data['select_holiday_table']) ? $item_data['select_holiday_table'] : '';?>">
                        
                        <input type="hidden" name="p_id" id="p_id" value="<?php echo @$item_data['S_id'];?>">
                    </form>
                </div>
            </div>
        </section>
        
    </body>
</html>

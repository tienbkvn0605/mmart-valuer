<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <title><?php echo(escape($config['title']));?></title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
    <script src="//www.m-mart.co.jp/js/gf_chara_henkan.js"></script>
    <script type="text/javascript" language="javascript" src='/outlet/valeur/common/js/itemreg.js?<?php echo time()?>'></script>
    <script type="text/javascript">

    jQuery( function() {
        // 賞味期限
        // var today = new Date();
        // // 記載期限
        // var kisai_minDate = new Date();
        // kisai_minDate.setDate(today.getDate() + 1);
        // $('#kigen').datepicker({
        //     minDate: kisai_minDate
        // });      

       var cate1_no = "<?php echo isset($item_data['cate1no']) ? $item_data['cate1no'] : '';?>";
       var cate2_no = "<?php echo isset($item_data['cate2no']) ? $item_data['cate2no'] : '';?>";
       var cate3_no = "<?php echo isset($item_data['cate3no']) ? $item_data['cate3no'] : '';?>";
       var cate4_no = "<?php echo isset($item_data['cate4no']) ? $item_data['cate4no'] : '';?>";
       var cate5_no = "<?php echo isset($item_data['cate5no']) ? $item_data['cate5no'] : '';?>";
       var cate6_no = "<?php echo isset($item_data['cate6no']) ? $item_data['cate6no'] : '';?>";
       var cate7_no = "<?php echo isset($item_data['cate7no']) ? $item_data['cate7no'] : '';?>";
       if (cate1_no) {
            $("#cate1no").val(cate1_no);
            $('#cate1no').trigger('change');

            setTimeout(function () {
                if (cate2_no) {
                    $("#cate2no").val(cate2_no);
                    $('#cate2no').trigger('change');

                    setTimeout(function () {
                        if (cate3_no) {
                            $("#cate3no").val(cate3_no);
                            $('#cate3no').trigger('change');

                            setTimeout(function () {
                                if (cate4_no) {
                                    $("#cate4no").val(cate4_no);
                                    $('#cate4no').trigger('change');
                                }
                            }, 1000); 
                        }
                    }, 1000); 
                }
            }, 1000); 
        }
    } );
    
    </script>
    
</head>

<?php 
    //掲載期限
    $f_year='';
    $f_month='';
    $f_day='';
    $f_time='';

    for($i_count=date('Y');$i_count<=date('Y')+1;$i_count++){
        $f_year .= '<option value="'.$i_count.'" '.(isset($item_data['m_disp_limit_y']) && $i_count==$item_data['m_disp_limit_y']? 'selected': '').'>'.$i_count.'</option>';
    };

    for($i_count=1;$i_count<=12;$i_count++){
        $f_month .= '<option value="'.$i_count.'" '.(isset($item_data['m_disp_limit_m']) && $i_count==$item_data['m_disp_limit_m']? 'selected': '').'>'.$i_count.'</option>';
    }

    for($i_count=1;$i_count<=31;$i_count++){
        $f_day .='<option value="'.$i_count.'" '.(isset($item_data['m_disp_limit_d']) && $i_count==$item_data['m_disp_limit_d']? 'selected': '').'>'.$i_count.'</option>';
    }

    for($i_count=1;$i_count<=23;$i_count++){
        $f_time .= '<option value="'.$i_count.'" '.(isset($item_data['m_disp_limit_h']) && $i_count==$item_data['m_disp_limit_h']? 'selected': '').'>'.$i_count.'</option>';
    }
    
    $submit_button = '<input style="border-top: none; border-left: none; border-right: none; opacity:0.6;cursor:default" class="btn width_200px padding_10px btn_submit btn_item_submit" type="button" name="b_type" value="　　登録　　" onClick="F_check_item(this.form,\'item_register_kakunin\');" disabled>';
?>
    <body>
        <section class="container-fluid mt-3"> 
            <?php include_once('/var/www/html3/outlet/valeur/seller/tpl/tpl_header.php')?>
            <div class="mb-3"><a type="button" class="btn btn-outline-primary" href="/outlet/valeur/seller/list_item.php">登録商品一覧</a></div>
            <div class="row mt-3 p-3">
                <div class="col col-md-8 col-sm-12" >
                    <form name="f_base" id="register" action="/outlet/valeur/seller/itemreg.php" method="post" enctype="multipart/form-data" onSubmit="return false">
                        <table class="table table-bordered align-middle">
                            <tbody>
                                <tr>
                                    <th class="table-light" style="min-width: 230px; max-width:230px">送料<span class="text-danger">*</span></th>
                                    <td>
                                        <div class="d-flex flex-row align-items-center mt-2">
                                            <a type="button" href="/outlet/valeur/seller/soryo_reg.php" class="btn btn-success" id="show_soryou">
                                                配送料表設定
                                            </a>
                                            <label for="select_soryo_table" class="form-label ms-3 mb-0">配送料表名選択：</label>
                                            <select class="form-select" id="select_soryo_table" name="select_soryo_table" style="max-width: 300px">
                                            
                                                <?php foreach ($soryo_arr as $soryo_master_serial => $value) {
                                                    $f_selected = '';
                                                    
                                                    if($soryo_master_serial == $item_data['select_soryo_table']){
                                                        $f_selected = 'selected';
                                                    }else{
                                                        $f_selected = '';
                                                    }
                                                    echo '<option '.$f_selected.' value="'.$soryo_master_serial.'">'.$value['soryo_name'].'</option>';    
                                                } ?>
                                            </select>                             
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light">カレンダー<span class="text-danger">*</span></th>
                                    <td>
                                        <div class="d-flex flex-row align-items-center mt-2">
                                            <a type="button" href="/outlet/valeur/seller/calendar_reg.php" class="btn btn-success" id="show_soryou">
                                                休業日表設定
                                            </a>
                                            <label for="select_holiday_table" class="form-label ms-3 mb-0">休業日表名選択：</label>
                                            <select class="form-select" id="select_holiday_table" name="select_holiday_table" style="max-width: 300px">
                                                <?php foreach ($holiday_arr as $value) { 
                                                     $f_selected = '';
                                                     if($value['serial'] == $item_data['select_holiday_table']){
                                                         $f_selected = 'selected';
                                                     }else{
                                                         $f_selected = '';
                                                     }
                                                    echo '<option '.$f_selected.' value="'.$value['serial'].'">'.$value['holiday_name'].'</option>';    
                                                } ?>
                                            </select>                             
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light" align="midle">カテゴリ選択<span class="text-danger">*</span></th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div id="cate1_box">
                                                    第一:
                                                    <select class="form-select" id="cate1no" name="cate1no">
                                                        <option value="0">‐選択‐</option>
                                                        <?php 
                                                            foreach ($A_cate as $key => $value) {
                                                                echo '<option value="'.$value.'">'.$key.'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                <!-- <input type="hidden" value="" name="cate1_serial" id="cate1_serial"/> -->
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div id="cate2_box" style="display:none;">
                                                    第二:
                                                    <select id="cate2no" class="form-select" name="cate2no" value="2"></select>
                                                    <!-- <input type="hidden" value="" name="cate2_serial" id="cate2_serial"/> -->
                                                </div>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div id="cate3_box" style="display:none;" >
                                                    第三:
                                                    <select id="cate3no" class="form-select" name="cate3no"></select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div id="cate4_box" style="display:none;">
                                                    第四:
                                                    <select id="cate4no" class="form-select" name="cate4no"></select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div id="cate5_box" style="display:none;">
                                                    種別:
                                                    <select id="cate5no" class="form-select" name="cate5no"></select>
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
                                                <span class="text-primary-emphasis" style="font-size: 0.8em;">一般的な呼称で登録して下さい（産地を記入する等は可）</span><br />
                                                <span class="text-primary-emphasis" style="font-size: 0.8em;">「格安」「処分」「激安」「送料無料」「アウトレット」「オープン特価」「%オフ」といった単語は使用不可</span><br />
                                                <span class="text-primary-emphasis" style="font-size: 0.8em;">全角「×」は半角「x」に置換されます</span><br />
                                                <span class="text-primary-emphasis" style="font-size: 0.8em;">半角スペースは全角スペースに置換されます</span><br />
                                                <span class="text-primary-emphasis" style="font-size: 0.8em;">30文字まで入力できます</span><br />
                                                <span class="text-primary-emphasis" style="font-size: 0.8em;">商品名に価格を表示する事は不可</span><br />
                                                <input name="item" id="item" type="text" class="form-control" size="70"	value="<?php echo @$item_data['item'];?>" maxlength="60"/>
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
                                                <span class="text-primary-emphasis" style="font-size: 0.8em;">上の欄で入力した商品名のヨミガナを入力して下さい</span><br />
                                                <span class="text-primary-emphasis" style="font-size: 0.8em;">全角カタカナで入力して下さい</span><br />
                                                <input name="kana" id="kana" type="text" class="form-control" size="100" value="<?php echo @$item_data['kana'];?>" maxlength="200"/>
                                            </div>
                                        </div>
                                        
                                    </td>
                                </tr>
                                <!-- 単価 -->
                                <tr>
                                    <th class="table-light">単価<span class="text-danger">*</span></th>
                                    <td>
                                        <span class="text-primary-emphasis" style="font-size: 0.8em;">半角数字以外は入力不可（卸サイトになりますので「卸価格」を表示）</span><br />
                                        <span class="text-primary-emphasis" style="font-size: 0.8em;">「税込価格」で入力してください</span><br />
                                        <div class="row">
                                            <div class="col-md-3">
                                                <!-- <input name="tanka"	id="tanka" type="text" class="form-control" size="16" value="<?php echo @$item_data['tanka'];?>"/>円 -->
                                                <div class="input-group">
                                                    <input name="tanka"	id="tanka" type="text" class="form-control"value="<?php echo @$item_data['tanka'];?>" oninput="value=value.replace(/[^0-9.]+/i,'');"/>
                                                    <span class="input-group-text">円</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <!-- 単位 -->
                                <tr>
                                    <th class="table-light">単位<span class="text-danger">*</span></th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <span class="text-primary-emphasis" style="font-size: 0.8em;">形態は10文字まで入力できます</span><br />
                                                <span class="text-primary-emphasis" style="font-size: 0.8em;">重量の単位を選択　([数値]　[▼単位選択]　[単位形態]　数値と単位形態はあれば入力して下さい)</span><br />
                                                <?php
                                                //  echo @$tani_moto;
                                                 ?>
                                                 <div class="d-flex flex-row align-items-center mt-2" style="max-width: 400px;">
                                                    <input size="10" maxlength="10" type="number" name="tani2" id="tani2" class="form-control" value="<?php echo @$item_data['tani2'];?>"/>
                                                    <select name="tani1" id="tani1" class="form-control">
                                                        <option value="">▼単位選択</option>
                                                        <option value="kg" <?php echo isset($item_data['tani1']) && $item_data['tani1'] == 'kg' ? 'selected' : '';?> >├kg（キログラム）</option>
                                                        <option value="g" <?php echo isset($item_data['tani1']) && $item_data['tani1'] == 'g' ? 'selected' : '';?> >├g（グラム）</option>
                                                        <option value="リットル" <?php echo isset($item_data['tani1']) && $item_data['tani1'] == 'リットル' ? 'selected' : '';?> >├リットル</option>
                                                        <option value="ml" <?php echo isset($item_data['tani1']) && $item_data['tani1'] == 'ml' ? 'selected' : '';?> >└ml（ミリリットル）</option>
                                                    </select>
                                                    (<input size="10" maxlength="10" type="text" name="tani3" id="tani3" class="form-control" value="<?php echo @$item_data['tani3'];?>"/>)<br />
                                                </div>
                                                <span class="ex">例：「250g」「kg」「400ml（パック）」「リットル(本)」等</span><br />
                                              
                                            </div>
                                            <div class="col-md-4">
                                          </div>
                                        </div>
                                    </td>
                                </tr>
                                <!-- 定貫・不定貫 -->
                                <tr>
                                    <th class="table-light">定貫・不定貫<span class="text-danger">*</span></th>
                                    <td>
                                        <label><input type="radio" name="teikan" value="tei" <?php echo isset($item_data['teikan']) && $item_data['teikan'] == 'tei' ? 'checked' : '';?> />定貫</label>
                                        <label><input type="radio" name="teikan" value="futei" <?php echo isset($item_data['teikan']) && $item_data['teikan'] == 'futei' ? 'checked' : '';?> />不定貫</label>
                                    </td>
                                </tr>
                                <!-- 受注最小ロット -->
                                <tr>
                                    <th class="table-light">受注最小ロット<span class="text-danger">*</span></th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <span class="text-primary-emphasis" style="font-size: 0.8em;">単位（kg等）まで明記して下さい</span><br />
                                                <span class="text-primary-emphasis" style="font-size: 0.8em;">半角スペースは全角スペースに置換されます</span><br />
                                                <span class="ex">例：20kg、3袋、5ケース(20個/ケース)等</span><br />
                                                <input name="lot" id="lot" type="text" class="form-control"	size="70" value="<?php echo @$item_data['lot'];?>"/>
                                            </div>
                                        </div>
                                       
                                    </td>
                                </tr>
                                <!-- 受注最小ロットの -->
                                <tr>
                                    <th class="table-light">
                                        受注最小ロットの<br />
                                        合計金額<span class="text-danger">*</span>
                                    </th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <span class="text-primary-emphasis" style="font-size: 0.8em;">半角数字以外は入力不可</span><br />
                                                <div class="input-group">
                                                    <input name="lotkingaku" id="lotkingaku" type="text" class="form-control" size="16"	value="<?php echo @$item_data['lotkingaku'];?>" oninput="value=value.replace(/[^0-9.]+/i,'');"/>
                                                    <span class="input-group-text">円</span>
                                                </div>
                                            </div>
                                        </div>
                                       
                                    </td>
                                </tr>
                                <!-- 生(原)産地 -->
                                <tr>
                                    <th class="table-light">生(原)産地<span class="text-danger">*</span></th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <span class="text-primary-emphasis" style="font-size: 0.8em;">マイナス記号「-」は使用できません</span><br />
                                                <span class="ex">例：中国、アメリカ、北海道、沖縄、等</span><br />
                                                <input name="sanchi" id="sanchi" type="text" class="form-control" size="70"	value="<?php echo @$item_data['sanchi'];?>"/>
                                            </div>
                                        </div>
                                       
                                    </td>
                                </tr>
                                <!-- 加工地 -->
                                <tr>
                                    <th class="table-light">加工地<span class="text-danger">*</span></th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <span class="text-primary-emphasis" style="font-size: 0.8em;">マイナス記号「-」は使用できません</span><br />
                                                <span class="ex">例：中国、アメリカ、北海道、沖縄、等</span><br />
                                                <input name="kakouchi" id="kakouchi" type="text" class="form-control" size="70"	value="<?php echo @$item_data['kakouchi'];?>"/>
                                            </div>
                                        </div>
                                       
                                    </td>
                                </tr>
                                <!-- 栄養成分表示 -->
                                <tr>
                                    <th class="table-light">栄養成分表示</th>
                                    <td>
                                        <div id="eiyou_textarea">
                                            <div id="eiyou_input" class="eiyou_input" style="display: none">
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
                                                                        <input name="c_energy" class="form-control" type="text" value="<?php echo @$item_data['c_energy'];?>"size="6" maxlength="10"/>
                                                                        <span class="input-group-text">kcal</span>
                                                                    </div>
                                                                    <div class="text-center">(整数)</div>
                                                                </div>
                                                            </td>
                                                            <td style="white-space: nowrap">
                                                                <div>
                                                                    <div class="input-group">
                                                                    <input name="c_suibun" class="form-control" type="text" value="<?php echo @$item_data['c_suibun'];?>"	size="6" maxlength="10"/>
                                                                        <span class="input-group-text">g</span>
                                                                    </div>
                                                                    <div class="text-center">(小数点第1位迄)</div>
                                                                </div>
                                                                
                                                            </td>
                                                            <td style="white-space: nowrap">
                                                                <div>
                                                                    <div class="input-group">
                                                                    <input name="c_tanpaku" class="form-control" type="text" value="<?php echo @$item_data['c_tanpaku'];?>"	size="6" maxlength="10"/>
                                                                        <span class="input-group-text">g</span>
                                                                    </div>
                                                                    <div class="text-center">(小数点第1位迄)</div>
                                                                </div>
                                                            </td>
                                                            <td style="white-space: nowrap">
                                                                <div>
                                                                    <div class="input-group">
                                                                    <input name="c_shishitsu" class="form-control" type="text" value="<?php echo @$item_data['c_shishitsu'];?>"	size="6" maxlength="10"/>
                                                                        <span class="input-group-text">g</span>
                                                                    </div>
                                                                    <div class="text-center">(小数点第1位迄)</div>
                                                                </div>
                                                            </td>
                                                            <td style="white-space: nowrap">
                                                                <div>
                                                                    <div class="input-group">
                                                                    <input name="c_tansui" class="form-control" type="text" value="<?php echo @$item_data['c_tansui'];?>" size="6" maxlength="10"/>
                                                                        <span class="input-group-text">g</span>
                                                                    </div>
                                                                    <div class="text-center">(小数点第1位迄)</div>
                                                                </div>
                                                            </td>
                                                            <td style="white-space: nowrap">
                                                                <div>
                                                                    <div class="input-group">
                                                                    <input name="c_kaibun" class="form-control" type="text" value="<?php echo @$item_data['c_kaibun'];?>" size="6" maxlength="10"/>
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
                                                                        <input name="c_na" class="form-control" type="text" value="<?php echo @$item_data['c_na'];?>"size="6" maxlength="10"/>
                                                                        <span class="input-group-text">mg</span>
                                                                    </div>
                                                                    <div class="text-center">(整数)</div>
                                                                </div>
                                                            </td>
                                                            <td style="white-space: nowrap">
                                                                <div>
                                                                    <div class="input-group">
                                                                        <input name="c_k" class="form-control" type="text" value="<?php echo @$item_data['c_k'];?>"size="6" maxlength="10"/>
                                                                        <span class="input-group-text">mg</span>
                                                                    </div>
                                                                    <div class="text-center">(整数)</div>
                                                                </div>
                                                            </td>
                                                            <td style="white-space: nowrap">
                                                                <div>
                                                                    <div class="input-group">
                                                                        <input name="c_ca" class="form-control" type="text" value="<?php echo @$item_data['c_ca'];?>"size="6" maxlength="10"/>
                                                                        <span class="input-group-text">mg</span>
                                                                    </div>
                                                                    <div class="text-center">(整数)</div>
                                                                </div>
                                                            </td>
                                                            <td style="white-space: nowrap">
                                                                <div>
                                                                    <div class="input-group">
                                                                        <input name="c_mg" class="form-control" type="text" value="<?php echo @$item_data['c_mg'];?>"size="6" maxlength="10"/>
                                                                        <span class="input-group-text">mg</span>
                                                                    </div>
                                                                    <div class="text-center">(整数)</div>
                                                                </div>
                                                            </td>
                                                            <td style="white-space: nowrap">
                                                                <div>
                                                                    <div class="input-group">
                                                                        <input name="c_p" class="form-control" type="text" value="<?php echo @$item_data['c_p'];?>"size="6" maxlength="10"/>
                                                                        <span class="input-group-text">mg</span>
                                                                    </div>
                                                                    <div class="text-center">(整数)</div>
                                                                </div>
                                                            </td>
                                                            <td style="white-space: nowrap">
                                                                <div>
                                                                    <div class="input-group">
                                                                        <input name="c_fe" class="form-control" type="text" value="<?php echo @$item_data['c_fe'];?>"size="6" maxlength="10"/>
                                                                        <span class="input-group-text">mg</span>
                                                                    </div>
                                                                    <div class="text-center">(小数点第1位迄)</div>
                                                                </div>
                                                            </td>
                                                            <td style="white-space: nowrap">
                                                                <div>
                                                                    <div class="input-group">
                                                                        <input name="c_zn" class="form-control" type="text" value="<?php echo @$item_data['c_zn'];?>"size="6" maxlength="10"/>
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
                                                                        <input name="c_lechi" class="form-control" type="text" value="<?php echo @$item_data['c_lechi'];?>"size="6" maxlength="10"/>
                                                                        <span class="input-group-text">μg</span>
                                                                    </div>
                                                                    <div class="text-center">(整数)</div>
                                                                </div>
                                                            </td>
                                                            <td style="white-space: nowrap">
                                                                <div>
                                                                    <div class="input-group">
                                                                        <input name="c_kalo" class="form-control" type="text" value="<?php echo @$item_data['c_kalo'];?>"size="6" maxlength="10"/>
                                                                        <span class="input-group-text">μg</span>
                                                                    </div>
                                                                    <div class="text-center">(整数)</div>
                                                                </div>
                                                            </td>
                                                            <td style="white-space: nowrap">
                                                                <div>
                                                                    <div class="input-group">
                                                                        <input name="c_b1" class="form-control" type="text" value="<?php echo @$item_data['c_b1'];?>"size="6" maxlength="10"/>
                                                                        <span class="input-group-text">mg</span>
                                                                    </div>
                                                                    <div class="text-center">(小数点第2位迄)</div>
                                                                </div>
                                                            </td>
                                                            <td style="white-space: nowrap">
                                                                <div>
                                                                    <div class="input-group">
                                                                        <input name="c_b2" class="form-control" type="text" value="<?php echo @$item_data['c_b2'];?>"size="6" maxlength="10"/>
                                                                        <span class="input-group-text">mg</span>
                                                                    </div>
                                                                    <div class="text-center">(小数点第2位迄)</div>
                                                                </div>
                                                            </td>
                                                            <td style="white-space: nowrap">
                                                                <div>
                                                                    <div class="input-group">
                                                                        <input name="c_c" class="form-control" type="text" value="<?php echo @$item_data['c_c'];?>"size="6" maxlength="10"/>
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
                                                                        <input name="c_seni" class="form-control" type="text" value="<?php echo @$item_data['c_seni'];?>"size="6" maxlength="10"/>
                                                                        <span class="input-group-text">g</span>
                                                                    </div>
                                                                    <div class="text-center">(小数点第1位迄)</div>
                                                                </div>
                                                            </td>
                                                            <td style="white-space: nowrap">
                                                                <div>
                                                                    <div class="input-group">
                                                                        <input name="c_shokuen" class="form-control" type="text" value="<?php echo @$item_data['c_shokuen'];?>"size="6" maxlength="10"/>
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
                                                <span class="text-primary-emphasis" style="font-size: 0.8em;">加工品の場合は栄養成分表示として、熱量、たんぱく質、脂質、炭水化物、ナトリウム（食塩相当量で表示）が必要です。</span><br />
                                                <span class="text-primary-emphasis" style="font-size: 0.8em;">
                                                    <a href="https://www.maff.go.jp/tohoku/6zi_koudou/attach/pdf/190718gaiyou-2.pdf" target="_blank">参照(消費者庁)：食品の栄養成分表示について</a>
                                                </span><br />
                                                <div class="row mt-2">
                                                    <div class="col-md-8">
                                                        <textarea name="eiyou" id="eiyou_text" cols="30" rows="10" class="form-control"><?php echo @$item_data['eiyou'];?></textarea>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <textarea name="example" cols="30" rows="10" readonly="" style="font-size : 15px" class="form-control" >
記入例
1食（○g）当たり
熱量　　○kcal
たんぱく質　　○g
脂質　　○g
炭水化物　　○g
食塩相当量　　○g
                                                        </textarea>
                                                    </div>
                                                </div>   
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <!-- 形態 -->
                                <tr>
                                    <th class="table-light">形態<span class="text-danger">*</span></th>
                                    <td>
                                        <div class="col-md-6">
                                            <span class="ex">例：箱、袋、等</span><br />
                                            <input name="keitai" id="keitai" type="text" class="form-control" size="70" value="<?php echo @$item_data['keitai'];?>">
                                        </div>
                                    </td>
                                </tr>
                                <!-- 荷姿 -->
                                <tr>
                                    <th class="table-light">荷姿<span class="text-danger">*</span></th>
                                    <td>
                                        <div class="col-md-6">
                                            <span class="ex">例：24袋/ケース、10コ×10パック/ケース、等</span><br />
                                            <input name="nisugata" id="nisugata" type="text" class="form-control" size="70" value="<?php echo @$item_data['nisugata'];?>">
                                        </div>
                                    </td>
                                </tr>
                                <!-- サイズ -->
                                <tr>
                                    <th class="table-light">サイズ<span class="text-danger">*</span></th>
                                    <td>
                                        <span class="ex">重量欄は、kg表記で入力。例：600g→0.6kg＜必須＞<br />()欄は、取引単位の内訳を入力。例：200gパック×3＜任意＞</span>
                                        <div class="d-flex flex-row align-items-center mt-2" style="max-width: 450px;white-space: nowrap" >
                                            約<input name="m_lot_weight" id="m_lot_weight" type="text" class="form-control" style="max-width: 100px;" value="<?php echo @$item_data['m_lot_weight'];?>">kg (<input name="size" id="size" type="text" class="form-control" size="58" value="<?php echo @$item_data['size'];?>">)
                                        </div>
                                    </td>
                                </tr>
                                <!-- 賞味期限 -->
                                <tr>
                                    <th class="table-light">賞味期限<span class="text-danger">*</span></th>
                                    <td>
                                        <span class="text-primary-emphasis" style="font-size: 0.8em;">保存方法を選択し、年月日を明記して下さい</span><br />
                                        <div class="row">
                                            <div class="col-md-3">
                                                保存方法:
                                                <select class="form-select" id="hozon" name="hozon">
                                                    <?php 
                                                    
                                                        $f_selected = '';
                                                        $f_hozon = isset($item_data['hozon']) ? mb_convert_encoding($item_data['hozon'], 'UTF-8', 'auto') : '';
                                                        foreach ($config['A_hozon'] as $value) {
                                                            if($f_hozon && $value == $f_hozon){
                                                                $f_selected = 'selected';
                                                            }else{
                                                                $f_selected = '';
                                                            }
                                                            echo '<option '.$f_selected.' value="'.$value.'">'.$value.'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-10"></div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <input name="kigen" id="kigen" type="text" class="form-control" size="70" value="<?php echo @$item_data['kigen'];?>"/>
                                                <span class="text-danger-emphasis" style="font-size: 0.8em;">賞味期限は3文字以上入力してください。例：<b>一年間</b></span><br />
                                            </div>
                                            <div class="col-md-6"></div>
                                        </div>
                                    </td>
                                </tr>
                                <!-- 解凍方法 -->
                                <tr>
                                    <th class="table-light">解凍方法</th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <span class="text-primary-emphasis" style="font-size: 0.8em;">冷凍品のみ入力して下さい</span><br />
                                                <input name="kaitou" id="kaitou" type="text" class="form-control" size="70" value="<?php echo @$item_data['kaitou'];?>">
                                            </div>
                                        </div>
                                        
                                    </td>
                                </tr>
                                <!-- 納期/発送体制 -->
                                <tr>
                                    <th class="table-light">納期/発送体制<span class="text-danger">*</span></th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <span class="ex">例：受注日より3日以内/冷凍便、等</span><br />
                                                <input name="nouki" id="nouki" type="text" class="form-control" size="70" value="<?php echo @$item_data['nouki'];?>">
                                            </div>
                                        </div>
                                       
                                    </td>
                                </tr>
                                <!-- 納入実績 -->
                                <tr>
                                    <th class="table-light">納入実績</th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <span class="ex">例：レストラン、居酒屋、スーパー、百貨店、等</span><br />
                                                <input name="jisseki" id="jisseki" type="text" class="form-control" size="70" value="<?php echo @$item_data['jisseki'];?>">
                                            </div>
                                        </div>
                                        
                                    </td>
                                </tr>
                                <!-- メニュー -->
                                <tr>
                                    <th class="table-light">メニュー<span class="text-danger">*</span></th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <span class="ex">例：刺身、サラダ、ステーキ、等</span><br />
                                                <input name="menu" id="menu" type="text" class="form-control" size="70" value="<?php echo @$item_data['menu'];?>">
                                            </div>
                                        </div>
                                        
                                    </td>
                                </tr>
                                <!-- 備考 -->
                                <tr>
                                    <th class="table-light">備考</th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <span class="text-primary-emphasis" style="font-size: 0.8em;">商品の特記事項を入力して下さい（必須ではありません）</span><br />
                                                <input name="bikou" id="bikou" type="text" class="form-control" size="70" value="<?php echo @$item_data['bikou'];?>">
                                            </div>
                                        </div>
                                        
                                    </td>
                                </tr>
                                <!-- 原材料、食品添加物 -->
                                <tr>
                                    <th class="table-light">原材料、食品添加物<span class="text-danger">*</span></th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <span class="ex">例：小麦粉、砂糖、マーガリン、卵、食塩、保存料(ポリリジン)、グリシン</span><br />
                                                <input name="zairyo" id="zairyo" type="text" class="form-control" size="70" value="<?php echo @$item_data['zairyo'];?>"/>
                                            </div>
                                        </div>
                                        
                                    </td>
                                </tr>
                                <!-- 詳しい商品説明 -->
                                <tr>
                                    <th class="table-light">詳しい商品説明<span class="text-danger">*</span></th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-9">
                                                <span class="text-primary-emphasis" style="font-size: 0.8em;">150字～200字程度で入力して下さい</span><br />
                                                <span class="text-primary-emphasis" style="font-size: 0.8em;">入力文字数が多すぎると画面が次に進まないことがございます<br />
                                                </span>
                                                <span class="text-primary-emphasis" style="font-size: 0.8em;">htmlタグは使用しないで下さい</span><br />
                                                <span class="text-primary-emphasis" style="font-size: 0.8em;">URL、メールアドレスは記載しないでください。</span><br />
                                                <span class="text-primary-emphasis" style="font-size: 0.8em;">電話番号は絶対に入力しないでください。</span><br />
                                                <div id="ai-html-content"></div>
                                                <textarea name="setsumei" id="setsumei" cols="49" rows="10"	class="form-control"><?php echo (@$item_data['setsumei']);?></textarea>
                                            </div>
                                        </div>
                                        
                                    </td>
                                </tr>
                                <!-- 在庫設定 -->
                                <tr>
                                    <th class="table-light">在庫設定</th>
                                    <td>
                                        <label><input name="zaiko_disp_flg" id="zaiko_disp_flg" class="stock_display form-check-input" type="checkbox" data-ai_serial="<?php echo @$item_data['ai_serial'];?>" <?php echo ((isset($item_data['m_zaiko_disp_flg']) && $item_data['m_zaiko_disp_flg'] == 1) ? 'checked':'');?> >在庫を表示する</label><br>
                                        <input name="m_zaiko_disp_flg" id="m_zaiko_disp_flg" type="hidden" value="<?php echo (isset($item_data['m_zaiko_disp_flg'])?$item_data['m_zaiko_disp_flg']:'');?>">
                                    </td>
                                </tr>
                                <!-- 総重量（kg） -->
                                <tr class="stock_input_<?php echo @$item_data['ai_serial'];?>" <?php echo ((isset($item_data['m_zaiko_disp_flg']) && $item_data['m_zaiko_disp_flg'] == 1) ? '':'style="display: none"');?>  >
                                    <th class="table-light">総重量（kg）<span class="text-danger">*</span></th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input name="total_weight" id="total_weight" type="text" class="form-control" size="10" value="<?php echo @$item_data['total_weight'];?>" oninput="value=value.replace(/[^0-9.]+/i,'');"/>
                                            </div>
                                        </div>
                                        
                                    </td>
                                </tr>
                                <!-- 1ロットあたりの数量（kg） -->
                                <tr class="stock_input_<?php echo @$item_data['ai_serial'];?>" <?php echo ((isset($item_data['m_zaiko_disp_flg']) && $item_data['m_zaiko_disp_flg'] == 1) ? '':'style="display: none"');?> >
                                    <th class="table-light">1ロットあたりの数量（kg）<span class="text-danger">*</span></th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                <input name="lot_weight_hidden" id="lot_weight_hidden" type="text" size="2" class="form-control" value="<?php echo @$item_data['m_lot_weight'];?>" disabled >
                                                    <span class="input-group-text">kg</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </td>
                                </tr>
                                <!-- 在庫数 -->
                                <tr class="stock_input_<?php echo @$item_data['ai_serial'];?>" <?php echo ((isset($item_data['m_zaiko_disp_flg']) && $item_data['m_zaiko_disp_flg'] == 1) ? '':'style="display: none"');?> >
                                    <th class="table-light">在庫数<span class="text-danger">*</span></th>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input name="zaiko" id="zaiko" type="text" class="form-control" size="10" value="<?php echo @$item_data['zaiko'];?>" oninput="value=value.replace(/[^0-9.]+/i,'');">
                                            </div>
                                        </div>
                                        
                                    </td>
                                </tr>

                                <tr id="displimit" <?php echo @$item_data['t_style'];?>>
                                    <th class="table-light">掲載期限</th>
                                    <td>
                                        <span class="text-primary-emphasis" style="font-size: 0.8em;"><?php echo join('、',$config['G_displimit_cate1_arr'])?>の場合のみ入力</span><br />
                                        <span class="text-primary-emphasis" style="font-size: 0.8em;">設定しない場合は何も入力しないで下さい</span><br />
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="d-flex flex-row align-items-center mt-2" style="white-space: nowrap">
                                                    <select name="m_disp_limit_y" id="m_disp_limit_y" class="form-select">
                                                        <option value=""></option>
                                                        <?php echo @$f_year;?>
                                                    </select>年
                                                    <select name="m_disp_limit_m" id="m_disp_limit_m" class="form-select">
                                                        <option value=""></option>
                                                        <?php echo @$f_month;?>
                                                    </select>月
                                                    <select name="m_disp_limit_d" id="m_disp_limit_d" class="form-select">
                                                        <option value=""></option>
                                                        <?php echo @$f_day;?>
                                                    </select>日
                                                    <select name="m_disp_limit_h" id="m_disp_limit_h" class="form-select">
                                                        <option value=""></option>
                                                        <?php echo @$f_time;?>
                                                    </select>時まで掲載
                                                </div>
                                            </div>
                                        </div>
                                
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light">
                                        商品画像<span class="text-danger">*</span>
                                    </th>
                                    <td>
                                        「参照」ボタンをクリックし登録する画像ファイルを選択後「完了」ボタンをクリックしてください。<br />
                                        画像は600×600ピクセルの大きさになります。<br />
                                        画像ファイルの拡張子はjpg,jpeg,gifのみ登録可能です。<br />
                                        現物商品の素材画像か盛付例をご登録ください。<br />
                                        <font color="#ff0000">※画像内に文字を入れないでください。<br />画像に文字が入っている場合、登録を削除する場合がございます。</font>
                                        <div class="row">
                                            <div class="col-md-6 mt-2">
                                                <div id="list"><?php echo @$A_gazo['new_pic'];?></div>
                                                <input type="file" name="new_pic" id="new_pic" class="form-control image_onChange_size" data-image_name="new_pic"/>
                                            </div>
                                        </div>
                                       
                                    </td>
                                </tr>
                                <tr>
                                <th class="table-light">商品画像2</th>
                                <td>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div id="list_2"><?php echo @$A_gazo['new_pic2'];?></div>
                                            <input type="file" name="new_pic2" id="new_pic2" class="form-control image_onChange_size" data-image_name="new_pic2"/><br />
                                            ※不適格な画像の場合は掲載から落とします<br />
                                            ※画像を削除する際は、「画像修正・削除」からお願いします
                                        </div>
                                    </div>
                                </td>
                                </tr>
                                <tr>
                                    <th class="table-light">商品画像3</th>
                                    <td>
                                        <div class="col-md-6">
                                            <div id="list_3"><?php echo @$A_gazo['new_pic3'];?></div>
                                            <input type="file" name="new_pic3" id="new_pic3" class="form-control image_onChange_size" data-image_name="new_pic3"/><br />
                                            ※不適格な画像の場合は掲載から落とします<br />
                                            ※画像を削除する際は、「画像修正・削除」からお願いします
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light">商品画像4<br />キャッチコピー</th>
                                    <td>
                                        <div class="col-md-6">
                                            <div id="list_4"><?php echo @$A_gazo['new_pic4'];?></div>
                                            <input type="file" name="new_pic4" id="new_pic4" class="form-control image_onChange_size" data-image_name="new_pic4"/><br />
                                            ※不適格な画像の場合は掲載から落とします<br />
                                            ※画像を削除する際は、「画像修正・削除」からお願いします<br />
                                            <span class="text-primary-emphasis" style="font-size: 0.8em;">キャッチコピーは、23文字まで入力できます</span><br />
                                            <input name="pic4_catch_copy" id="pic4_catch_copy" type="text" class="form-control" size="70" value="<?php echo @$item_data['pic4_catch_copy'];?>" placeholder="キャッチコピー">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light">商品画像5<br />キャッチコピー</th>
                                    <td>
                                        <div class="col-md-6">
                                            <div id="list_5"><?php echo @$A_gazo['new_pic5'];?></div>
                                            <input type="file" name="new_pic5" id="new_pic5" class="form-control image_onChange_size" data-image_name="new_pic5"/><br />
                                            ※不適格な画像の場合は掲載から落とします<br />
                                            ※画像を削除する際は、「画像修正・削除」からお願いします<br />
                                            <span class="text-primary-emphasis" style="font-size: 0.8em;">キャッチコピーは、23文字まで入力できます</span><br />
                                            <input name="pic5_catch_copy" id="pic5_catch_copy" type="text" class="form-control" size="70" value="<?php echo @$item_data['pic5_catch_copy'];?>" placeholder="キャッチコピー">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light">梱包画像</th>
                                    <td>
                                        <div class="col-md-6">
                                            <div id="list_6"><?php echo @$A_gazo['new_pic6'];?></div>
                                            <input type="file" name="new_pic6" id="new_pic6" class="form-control image_onChange_size" data-image_name="new_pic6"/><br />
                                            ※不適格な画像の場合は掲載から落とします<br />
                                            ※画像を削除する際は、「画像修正・削除」からお願いします<br />
                                            <font color="#ff0000">※買い手に届く梱包や荷姿の画像を掲載してください。</font>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light">栄養成分画像</th>
                                    <td>
                                        <div class="col-md-6">
                                            <div id="list_7"><?php echo @$A_gazo['new_pic7'];?></div>
                                            <input type="file" name="new_pic7" id="new_pic7" class="form-control image_onChange_size" data-image_name="new_pic7"/><br />
                                            ※不適格な画像の場合は掲載から落とします<br />
                                            ※画像を削除する際は、「画像修正・削除」からお願いします<br />
                                            <font color="#ff0000">※成分表のシールなど、商品の栄養成分が記載されている画像を撮って掲載してください。</font>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="kakunin" style="padding-top: 20px" > 
                            <div class="text_center padding_20px" >
                                <!-- <?php echo $submit_button ?> -->
                                <input class="btn btn-primary" type="button" name="b_type" value="　　確認　　" onClick="F_check_item(this.form,'item_register_kakunin')">
                            </div>
                        </div>
                        

                        <?php if(isset($item_data['new_pic'])):?>
                            <input type="hidden" name="gazo" value="<?php echo @$item_data['new_pic'];?>" id="gazo">
                        <?php endif;?>
                        <?php if(isset($item_data['new_pic2'])):?>
                            <input type="hidden" name="gazo2" value="<?php echo @$item_data['new_pic2'];?>" id="gazo2">
                        <?php endif;?>
                        <?php if(isset($item_data['new_pic3'])):?>
                            <input type="hidden" name="gazo3" value="<?php echo @$item_data['new_pic3'];?>" id="gazo3">
                        <?php endif;?>
                        <?php if(isset($item_data['new_pic4'])):?>
                            <input type="hidden" name="gazo4" value="<?php echo @$item_data['new_pic4'];?>" id="gazo4">
                        <?php endif;?>
                        <?php if(isset($item_data['new_pic5'])):?>
                            <input type="hidden" name="gazo5" value="<?php echo @$item_data['new_pic5'];?>" id="gazo5">
                        <?php endif;?>
                        <?php if(isset($item_data['new_pic6'])):?>
                            <input type="hidden" name="gazo6" value="<?php echo @$item_data['new_pic6'];?>" id="gazo6">
                        <?php endif;?>
                        <?php if(isset($item_data['new_pic7'])):?>
                            <input type="hidden" name="gazo7" value="<?php echo @$item_data['new_pic7'];?>" id="gazo7">
                        <?php endif;?>
                        <input type="hidden" name="p_m_data_dat_ai_serial" value="" id="p_m_data_dat_ai_serial">
                        <input type="hidden" name="p_kind" id="p_kind" value="">
                        <input type="hidden" name="p_id" id="p_id" value="<?php echo @$item_data['S_id'];?>">
                        <input type="hidden" name="p_scroll" id="p_scroll" value="">
                        <?php if(isset($item_data['cate2no'])): ?>
                            <input type="hidden" name="cate2_serial_ajax" id="cate2_serial_ajax" value="<?php echo $item_data['cate2no']?>">
                        <?php endif; ?>
                        <?php if(isset($item_data['cate3no'])): ?>
                            <input type="hidden" name="cate3_serial_ajax" id="cate3_serial_ajax" value="<?php echo $item_data['cate3no']?>">
                        <?php endif; ?>
                        <?php if(isset($item_data['cate4no'])): ?>
                            <input type="hidden" name="cate4_serial_ajax" id="cate4_serial_ajax" value="<?php echo $item_data['cate4no']?>">
                        <?php endif; ?>
                        <?php if(isset($item_data['cate5no'])): ?>
                            <input type="hidden" name="cate5_serial_ajax" id="cate5_serial_ajax" value="<?php echo $item_data['cate5no']?>">
                        <?php endif; ?>
                        
                    </form>
                </div>
            </div>
        </section>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</html>

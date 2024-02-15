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
    
    <script type="text/javascript">

    jQuery( function() {
      
    } );
    
    </script>
    
</head>


<body>
    <section class="container-fluid mt-3"> 
    <?php include_once('/var/www/html3/outlet/valeur/seller/tpl/tpl_header.php')?>
        <a href="/outlet/valeur/seller/itemreg.php" class="btn btn-outline-primary">登録商品申請に戻る</a>
        <div class="p-3">
            <p class="mb-0 text-danger">※送料を設定して配送料表を登録してください。</p>
            <p class="mb-0 text-danger">※配送料表は最大で10個まで登録できます。</p>
            <p class="mb-0 text-danger">※登録済みの配送料表を商品登録申請時に選択できるようになります。</p>
            <p class="mb-0 text-danger">※サイズとは配送する荷物の縦横高さの最大サイズ(cm)を選択してください。</p>
            <p class="mb-0 text-danger">※kgは配送する荷物の最大重量を選択してください。</p>
            
        </div>
        <div class="row p-3">
            <div class="col col-md-8" >
                <div class="alert alert-<?php echo (isset($error_mess['status']) && $error_mess['status'] == 'ok' ? 'success': 'danger')?>" role="alert" style="<?php echo isset($error_mess['mess']) && !empty($error_mess['mess']) ? 'display: block' : 'display: none'?>">
                    <?php echo isset($error_mess['mess']) ? $error_mess['mess'] : '';?>
                </div>
                <div class="row ">
                    <div class="col-md-12 shadow-sm p-3 mb-5 bg-body-tertiary rounded">
                        <form name="data_soryo" id="data_soryo" action="/outlet/valeur/seller/soryo_reg.php" method="post" >
                            <div class="mb-3" style="max-width: 300px">
                                <label for="soryo_table_name" class="form-label" >配送料表名<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="soryo_table_name" name="soryo_table_name" maxlength="100" required>
                                <div class="invalid-feedback">
                                    配送料表名が既に存在します。
                                </div>

                            </div>
                            <label for="soryo_table_name" class="form-label" >配送料表<span class="text-danger">*</span></label>
                            <div id="soryo_table_content" class="mb-3">
                                
                                <div class="card">
                               
                                    <ul class="list-group list-group-flush">
                                    <?php foreach ($A_region_master as $key => $region) { ?>
                                        <li class="list-group-item" id="kubun_<?php echo $key;?>">
                                        <div class="row align-items-center">
                                            <div class="col-md-2">
                                            <input class="form-check-input kubun" type="checkbox" value="<?php echo $key;?>" id="kubun_id_<?php echo $key;?>" data-region="<?php echo $key;?>" name="region" value="<?php echo $region['region'];?>">
                                            <label class="form-check-label" for="kubun_id_<?php echo $key;?>" id="label_region_<?php echo $key;?>">
                                                <?php echo $region['region'];?>
                                            </label>
                                            </div>
                                            <div class="col-md-4">
                                                <lable class="d-flex align-items-center"><span style="width: 70px;">備考：</span><input type="email" class="form-control" width="100" id="region_label_<?php echo $key;?>" name="region_label_<?php echo $key;?>"></lable>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="d-flex flex-column align-items-start">
                                                <?php foreach ($region['pref'] as $pref_key => $pref) { ?>
                                                    <?php if(!empty($pref)):?>
                                                    <div class="d-flex flex-row align-items-center mb-2">
                                                        <div class="form-check me-3">
                                                        <input class="form-check-input pref_all pref_<?php echo $key;?>" data-region="<?php echo $key;?>" name="pref_<?php echo $key?>[]" type="checkbox" value="<?php echo $pref;?>" id="pref_<?php echo $key?>_<?php echo $pref_key?>">
                                                        <label class="form-check-label" for="pref_<?php echo $key?>_<?php echo $pref_key?>">
                                                            <?php echo $pref;?>
                                                        </label>
                                                        </div>
                                                        
                                                        <div class="input-group input-group-sm" style="width: 180px">
                                                        <span class="input-group-text" >配送料<span class="text-danger">*</span></span>
                                                        <input type="text" class="form-control" value="" id="soryo_<?php echo $key;?>_<?php echo $pref_key;?>" oninput="value=value.replace(/[^0-9.]+/i,'');">
                                                        <span class="input-group-text" >円</span>
                                                        </div>
                                                        <select class="form-select ms-2" id="size_<?php echo $key;?>_<?php echo $pref_key;?>" style="width: 80px" name="size_<?php echo $key;?>">
                                                        <?php foreach ($config['soryo_size'] as $size_key => $size) { 
                                                            echo '<option value="'.$size.'">'.$size.'</option>';
                                                        }?>
                                                        </select><span class="ms-0 mx-2">サイズ</span>
                                                        <select class="form-select" id="weight_<?php echo $key;?>_<?php echo $pref_key;?>" style="width: 80px" name="weight_<?php echo $key;?>">
                                                        <?php foreach ($config['soryo_weight'] as $weight_key => $weight) { 
                                                            echo '<option value="'.$weight.'">'.$weight.'</option>';
                                                        }?>
                                                        </select><span>kg</span>
                                                    </div>
                                                    <?php else:?>
                                                    <div class="d-flex flex-row align-items-center mb-2">
                                                        <div class="input-group input-group-sm" style="width: 180px">
                                                            <span class="input-group-text" >配送料</span>
                                                            <input type="text" class="form-control" value="" id="soryo_<?php echo $key;?>_<?php echo $pref_key;?>" oninput="value=value.replace(/[^0-9.]+/i,'');">
                                                            <span class="input-group-text" >円</span>
                                                        </div>
                                                        <select class="form-select ms-2" id="size_<?php echo $key;?>_<?php echo $pref_key;?>" style="width: 80px" name="size_<?php echo $key;?>">
                                                            <?php foreach ($config['soryo_size'] as $size_key => $size) { 
                                                            echo '<option value="'.$size.'">'.$size.'</option>';
                                                            }?>
                                                        </select><span class="ms-0 mx-2">サイズ</span>
                                                        <select class="form-select" id="weight_<?php echo $key;?>_<?php echo $pref_key;?>" style="width: 80px" name="weight_<?php echo $key;?>">
                                                            <?php foreach ($config['soryo_weight'] as $weight_key => $weight) { 
                                                            echo '<option value="'.$weight.'">'.$weight.'</option>';
                                                            }?>
                                                        </select><span>kg</span>
                                                    </div>
                                                    <?php endif;?>
                                                <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                        </li>
                                    <?php } ?>
                                    </ul>
                        
                                
                                </div>

                            </div>
                            <div>
                                <input type="hidden" name="soryo_data" id="soryo_data" value="" />
                                <input type="hidden" name="p_kind" id="p_kind" value="" />
                                <button class="btn btn-primary" id="set_soryo_table">配送料表設定</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- 配送料表リスト -->
                <?php if(!empty($soryo_arr)):?>
                    <div class="row">
                        <h4 class="mb-0">登録済み配送料表リスト：</h4>
                        <div class="row row-cols-1 row-cols-md-1 g-4 mt-0">
                            
                            <?php foreach ($soryo_arr as $master_serial => $soryo) { 
                                
                                ?>
                                <div class="col">
                                    <div class="card border-secondary mb-3">
                                        <div class="card-header">
                                            <?php echo $soryo['soryo_name']?>
                                            <button data-soryo_master_serial="<?php echo $master_serial ?>" class="btn btn-danger pt-0 pb-0 float-end remove_soryo_by_serial">削除</button>
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
                                                    <?php foreach ($soryo['soryo_table'] as $region_serial => $value) { ?>
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
                                </div>
                            <?php } ?>                           
                        
                        </div>
                    </div>
                <?php endif;?>
                
            </div>
        </div>
    </section>
</body>
<script src="/outlet/valeur/common/js/soryo_table_reg.js?<?php echo time();?>"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</html>
